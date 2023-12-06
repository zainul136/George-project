<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Client;
use App\Models\Company;
use App\Models\Contractors;
use App\Models\Employee;
use App\Models\EmployeePayment;
use App\Models\Invitation;
use App\Models\Project;
use App\Models\RolePermission;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function login()
    {
        if (session()->get('admin_id')) {
            return redirect('admins/dashboard');
        } else {
            return view('admin.auth.login');
        }
    }

    public function auth(Request $request)
    {
        try {
            $data = User::where('email', '=', $request->email)->first();
            if (Hash::check($request['password'], $data->password)) {
                Session::put('admin_id', $data->id);
                Session::put('name', $data->name);
                Session::put('email', $data->email);
                Session::put('type', $data->type);
                return response()->json(['status' => 'true', 'msg' => 'You are logged in succesfully']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'This Email and Password Are Not Matched']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'false', 'msg' => 'This Email and Password Are Not Matched']);
        }
    }

    public function dashboard()
    {
        if (session()->get('admin_id')) {
            $role = RolePermission::all();
            if (session()->get('type') == 'admin') {
                // Fetch data for admin
                $data['admins'] = User::where('type', 'admin')->count();
                $data['contractors'] = Contractors::join('users', 'users.id', '=', 'contractors.user_id')
                    ->where('users.type', '=', 'contractor')
                    ->count();
                $data['employees'] = Employee::join('users', 'users.id', '=', 'employees.user_id')
                    ->where('users.type', '=', 'employee')
                    ->count();
                $data['clients'] = Client::join('users', 'users.id', '=', 'clients.user_id')
                    ->where('users.type', '=', 'client')
                    ->count();
                $data['projects'] = Project::count();
            } elseif (session()->get('type') == 'contractor') {
                // Fetch data for contractor
                $contractor_id = session()->get('admin_id');
                $data['projects'] = Project::join('invitations', 'projects.project_id', '=', 'invitations.project_id')
                    ->where('invitations.contractor_id', '=', $contractor_id)
                    ->where('invitations.status', '=', 2)
                    ->count();
            } elseif (session()->get('type') == 'employee') {
                // Fetch data for employee
                $employee_id = session()->get('admin_id');
                $data['projects'] = Project::join('employees', 'projects.company', '=', 'employees.company')
                    ->where('employees.employee_id', '=', $employee_id)
                    ->count();
            }

            $contractorInvitation = Invitation::join('users', 'users.id', '=', 'invitations.contractor_id')->select('users.name as contractor', 'invitations.price as price', 'invitations.status as status')->where('invitations.status', '0')->get();
            return view('admin.dashboard.dashboard', ['role' => $role, 'contractorInvitation' => $contractorInvitation], compact('data'));
        } else {
            return redirect("/");
        }
    }

    public function dashboard_calendar()
    {

        if (!session()->get('admin_id')) {
            return response()->json([]);
        } else {

            $project_ids = [];
            $company_ids = [];
            $id = session()->get('admin_id');
            if (session()->get('type') == "contractor") {
                $project_ids = Invitation::where("contractor_id", $id)->select('project_id')->where('status', '=', 2)->get();
                // $projects = Project::whereIn('project_id', $project_id)->orderBy('project_id', 'desc')->get();
            } elseif (session()->get('type') == "employee") {
                $company_ids = Employee::where('user_id', $id)->select('company')->get();
                // $projects = Project::whereIn('company', $company_id)->orderBy('project_id', 'desc')->get();
            }

            // get projects
            $projects = Project::when(!empty($project_ids), function ($query) use ($project_ids) {

                $query->whereIn('project_id', $project_ids);
            })
                ->when(!empty($company_ids), function ($query) use ($company_ids) {

                    $query->whereIn('company', $company_ids);
                })
                ->orderBy('project_id', 'desc')
                ->select('project_id', 'name', 'project_date')
                ->get();

            $output = [];

            foreach ($projects as $v) {
                $output[] = [
                    'id' => $v->project_id,
                    'title' => $v->name,
                    'start' => $v->project_date,
                    'end' => $v->project_date,
                    'details' => ['link' => route('project:view', $v->project_id)]
                ];
            }

            return response()->json($output);
        }
    }

    public function logout()
    {
        session()->forget('admin_id');
        session()->forget('name');
        session()->forget('email');
        return redirect('/');
    }

    public function forgot()
    {
        return view('admin.auth.forgot');
    }


    public function get_income_expense_chart(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        // Calculate the start and end date based on the provided from_date and to_date
        if ($from_date && $to_date) {
            $startDate = $from_date;
            $endDate = $to_date;
        } else {
            $startDate = Carbon::now()->startOfMonth()->toDateString();
            $endDate = Carbon::now()->toDateString();
        }
        // Fetch income from Project model
        $incomeQuery = Project::query();
        if ($from_date && $to_date) {
            $incomeQuery->whereBetween('project_date', [$startDate, $endDate]);
        }
        $income = $incomeQuery->sum('cost');

        // Fetch expense from Invitation model
        $expenseQuery = Invitation::query();
        if ($from_date && $to_date) {
            $expenseQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        $invitationExpense = $expenseQuery->sum('price');

        // Fetch expense from EmployeePayment model
        $employeePaymentExpense = EmployeePayment::whereBetween('date', [$startDate, $endDate])
            ->sum('payment');

        // Calculate the total expense by summing the expenses from both Invitation and EmployeePayment
        $totalExpense = $invitationExpense + $employeePaymentExpense;


        return response()->json([
            'income' => $income,
            'expense' => $totalExpense,
        ]);
    }

    public function get_profit_data(Request $request)
    {
        $year = $request->input('year');

        $months = [
            "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];

        // Fetch income from Project model
        $incomeQuery = Project::query();
        if ($year) {
            $incomeQuery->whereYear('project_date', $year);
        }
        $income = $incomeQuery->sum('cost');

        // Fetch expense from Invitation model
        $expenseQuery = Invitation::query();
        if ($year) {
            $expenseQuery->whereYear('created_at', $year);
        }
        $invitationExpense = $expenseQuery->sum('price');

        // Fetch expense from EmployeePayment model
        $employeePaymentExpense = EmployeePayment::query();
        if ($year) {
            $employeePaymentExpense->whereYear('date', $year);
        }
        $employeePaymentExpense = $employeePaymentExpense->sum('payment');

        // Calculate total expense from both Invitation and EmployeePayment models
        $expense = $invitationExpense + $employeePaymentExpense;

        // Calculate profit
        $profit = $income - $expense;

        // Calculate profit for the previous year
        $previousYear = $year ? ($year - 1) : null;
        $previousYearIncomeQuery = Project::query();
        if ($previousYear) {
            $previousYearIncomeQuery->whereYear('project_date', $previousYear);
        }
        $previousYearIncome = $previousYearIncomeQuery->sum('cost');

        $previousYearExpenseQuery = Invitation::query();
        if ($previousYear) {
            $previousYearExpenseQuery->whereYear('created_at', $previousYear);
        }
        $previousYearExpense = $previousYearExpenseQuery->sum('price');

        $previousYearEmpExpenseQuery = EmployeePayment::query();
        if ($previousYear) {
            $previousYearEmpExpenseQuery->whereYear('date', $previousYear);
        }
        $previousYearEmpExpense = $previousYearEmpExpenseQuery->sum('payment');

        $previousYearProfit = $previousYearIncome - ($previousYearExpense + $previousYearEmpExpense);

        // Fetch profit data month-wise
        $profitData = [];
        $previousYearProfitData = [];
        for ($monthIndex = 1; $monthIndex <= 12; $monthIndex++) {
            $incomeQuery = Project::query();
            $expenseQuery = Invitation::query();
            $employeePaymentExpense = EmployeePayment::query();

            if ($year) {
                $incomeQuery->whereYear('project_date', $year);
                $expenseQuery->whereYear('created_at', $year);
                $employeePaymentExpense->whereYear('date', $year);
            }

            $incomeQuery->whereMonth('project_date', $monthIndex);
            $expenseQuery->whereMonth('created_at', $monthIndex);
            $employeePaymentExpense->whereMonth('date', $monthIndex);

            $income = $incomeQuery->sum('cost');
            $invitationExpense = $expenseQuery->sum('price');
            $employeePaymentExpense = $employeePaymentExpense->sum('payment');

            $expense = $invitationExpense + $employeePaymentExpense;

            $profitData[] = $income - $expense;

            // Calculate profit for the previous year month-wise
            if ($previousYear) {
                $previousYearIncomeQuery = Project::query();
                $previousYearExpenseQuery = Invitation::query();
                $previousYearEmpExpenseQuery = EmployeePayment::query();
                $previousYearIncomeQuery->whereYear('project_date', $previousYear);
                $previousYearExpenseQuery->whereYear('created_at', $previousYear);
                $previousYearEmpExpenseQuery->whereYear('date', $previousYear);
                $previousYearIncomeQuery->whereMonth('project_date', $monthIndex);
                $previousYearExpenseQuery->whereMonth('created_at', $monthIndex);
                $previousYearEmpExpenseQuery->whereMonth('date', $monthIndex);
                $previousYearIncome = $previousYearIncomeQuery->sum('cost');
                $invitationExpense = $previousYearExpenseQuery->sum('price');
                $employeePaymentExpense = $previousYearEmpExpenseQuery->sum('payment');
                $previousYearExpense = $invitationExpense + $employeePaymentExpense;
                $previousYearProfitData[] = $previousYearIncome - $previousYearExpense;
            }
        }
        return response()->json([
            'profit' => $profitData,
            'previous_year_profit' => $previousYearProfitData,
            'months' => $months,
            'year' => $year
        ]);
    }

    public function forgot_password(Request $request)
    {
        $data = User::where('email', $request->email)->first();
        if (!$data) {
            return response()->json(['status' => 'false', 'msg' => "Email doesn't exist!"]);
        } else {
            DB::table('password_resets')->where('email', $request->email)->delete();
            $token = Str::random(64);
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'expires_at' => Carbon::now()->addMinutes(5),
                'created_at' => Carbon::now()
            ]);

            $result = Mail::send('email.forgetPassword', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            });

            if ($result) {
                return response()->json(['status' => 'true', 'msg' => 'We have e-mailed your password reset link!']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Something is wrong!']);
            }
        }
    }

    public function reset_password($token)
    {
        // $mytime = Carbon::now();
        $data = DB::table('password_resets')->where('token', $token)->where('expires_at', '>', Carbon::now())->first();
        $email = $data->email;
        if (!$data) {
            return redirect()->route('admin:forgot')->with('msg', 'This Link is Expired');
        } else {
            return view('admin.auth.change', ['token' => $token, 'email' => $email]);
        }
    }

    public function change_password(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:password_resets',
            'password' => 'required',
            'c_password' => 'required'
        ]);
        $updatePassword = DB::table('password_resets')->where('email', '=', $request->email)->first();
        if (!$updatePassword) {
            return response()->json(['status' => 'false', 'msg' => 'Something is wrong. Try again']);
        } else {
            $result = User::where('email', $request->email)
                ->update(['password' => Hash::make($request->password)]);
            DB::table('password_resets')->where(['email' => $request->email])->delete();
            if ($result) {
                return response()->json(['status' => 'true', 'msg' => 'Your Password has been changed']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Something is wrong Try again']);
            }
        }
    }

    public function profile()
    {

        $id =  session()->get('admin_id');
        $companies = Company::all();
        $role = RolePermission::all();
        $contractor = Contractors::join('users', 'users.id', '=', 'contractors.user_id')
            ->where('users.type', '=', 'contractor')
            ->where('users.id', '=', $id)
            ->first();
        if ($contractor) {
            $projects = Project::whereRaw('FIND_IN_SET(?, contractors)', [$contractor->user_id])
                ->get();
        } else {
            // Contractor not found, handle the case accordingly
            $projects = collect(); // Empty collection
        }
        $contractors = Contractors::join('users', 'users.id', '=', 'contractors.user_id')->select('contractors.user_id as contractor_id', 'users.name as contractor_name')->orderBy('contractors.contractor_id', 'DESC')->get();
        $contractorDetails = Contractors::join('users', 'users.id', '=', 'contractors.user_id')->where('users.id', session()->get('admin_id'))->first();
        return view('admin.auth.profile', ['companies' => $companies, 'role' => $role, 'contractorDetails' => $contractorDetails, 'projects' => $projects, 'contractors' => $contractors]);
    }

    public function create()
    {
        if (session()->get('admin_id')) {
            $companies = Company::where('status', 1)->get();
            $role = RolePermission::all();
            return view('admin.admins.create', ['companies' => $companies, 'role' => $role]);
        } else {
            return redirect("/");
        }
    }

    public function list()
    {
        if (session()->get('admin_id')) {
            $role = RolePermission::all();
            $admins = Admin::join('users', 'users.id', '=', 'admins.user_id')->where('users.type', '=', 'admin')->orderBy('admins.admin_id', 'DESC')->get();
            return view('admin.admins.list', ['admins' => $admins, 'role' => $role]);
        } else {
            return redirect("/");
        }
    }

    public function admin_change_password(Request $request)
    {
        $id = $request->id;
        $messages = array(
            'new_password.required' => __('New Password field is required.'),
            'confirm_password.required' => __('Confirm Password field is required.'),
        );
        $validator = Validator::make($request->all(), [
            'new_password' => 'required',
            'confirm_password' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->messages())->withInput();
        }
        $user = new User();
        $result = $user->adminUpdatePassword($id, $request->new_password, $request->confirm_password);
        if ($result['success'] == true) {
            // Password updated successfully
            return redirect()->back()->with('success', $result['message']);
        } else {
            // Current password was incorrect or new password/confirm password did not match
            return redirect()->back()->withErrors([
                'errors' => __($result['message']),
            ])->withInput();
        }
    }

    public function store(Request $request)
    {
        $client = User::where('email', '=', $request->email)->get();
        if (count($client) > 0) {
            return response()->json(['status' => 'false', 'msg' => 'This Email already Exists']);
        } else {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extention = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extention;
                $file->move('public/project_images/admin/', $filename);
                // $image = $request->file('image');
                // $filename = $input['imagename'] = time() . '.' . $image->extension();
                // $thumbnailDirectory = public_path('public/project_images/admin/');
                // if (!file_exists($thumbnailDirectory)) {
                //     mkdir($thumbnailDirectory, 0755, true);
                // }
                // $img = Image::make($image->path());
                // $img->resize(100, 100, function ($constraint) {
                //     $constraint->aspectRatio();
                // })->save($thumbnailDirectory . '/' . $input['imagename']);
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'type' => 'admin'
                ]);
                $UserId = DB::getPdo()->lastInsertId();
                $result = Admin::create([
                    'user_id' => $UserId,
                    'contact' => $request->contact,
                    'company' => $request->company,
                    'dob' => $request->dob,
                    'address' => $request->address,
                    'image' => $filename,
                    'status' => 1,
                ]);
            } else {
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'type' => 'admin'
                ]);
                $UserId = DB::getPdo()->lastInsertId();
                $result = Admin::create([
                    'user_id' => $UserId,
                    'contact' => $request->contact,
                    'company' => $request->company,
                    'dob' => $request->dob,
                    'address' => $request->address,
                    'status' => 1,
                ]);
            }
            if ($result) {
                return response()->json(['status' => 'true', 'msg' => 'Admin Added Successfully']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Admin Could not Added Successfully']);
            }
        }
    }

    public function view($code)
    {
        if (session()->get('admin_id')) {
            $role = RolePermission::all();
            $admin = Admin::join('users', 'users.id', '=', 'admins.user_id')->where('admins.admin_id', '=', $code)->first();
            $companies = Company::all();
            return view('admin.admins.view', ['admin' => $admin, 'companies' => $companies, 'role' => $role]);
        } else {
            return redirect("/");
        }
    }

    public function edit($code)
    {
        if (session()->get('admin_id')) {
            $role = RolePermission::all();
            $admin = Admin::join('users', 'users.id', '=', 'admins.user_id')->where('admins.admin_id', '=', $code)->first();
            $companies = Company::all();
            return view('admin.admins.edit', ['admin' => $admin, 'companies' => $companies, 'role' => $role]);
        } else {
            return redirect("/");
        }
    }

    public function update(Request $request)
    {
        if ($request->hasFile('image')) {
            $data = Admin::where('admin_id', $request->code)->first();
            if (!is_null($data->image)) {
                $desitination = 'public/project_images/admin/' . $data->image;
                if (File::exists($desitination)) {
                    File::delete($desitination);
                }
            }
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('public/project_images/admin/', $filename);
            // $image = $request->file('image');
            // $filename = $input['imagename'] = time() . '.' . $image->extension();
            // $thumbnailDirectory = public_path('public/project_images/admin/');
            // if (!file_exists($thumbnailDirectory)) {
            //     mkdir($thumbnailDirectory, 0755, true);
            // }
            // $img = Image::make($image->path());
            // $img->resize(100, 100, function ($constraint) {
            //     $constraint->aspectRatio();
            // })->save($thumbnailDirectory . '/' . $input['imagename']);

            $getAdmin = Admin::where('admin_id', $request->code)->first();
            $data = User::where('id', '=', $getAdmin->admin_id)->first();
            User::where('id', $getAdmin->admin_id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $result = Admin::where('admin_id', $request->code)->update([
                'contact' => $request->contact,
                'company' => $request->company,
                'dob' => $request->dob,
                'address' => $request->address,
                'image' => $filename,
                'status' => $request->status
            ]);
        } else {
            $getAdmin = Admin::where('admin_id', $request->code)->first();
            User::where('id', $getAdmin->user_id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $result = Admin::where('admin_id', $request->code)->update([
                'contact' => $request->contact,
                'company' => $request->company,
                'dob' => $request->dob,
                'address' => $request->address,
                'status' => $request->status
            ]);
        }
        if ($result) {
            return response()->json(['status' => 'true', 'msg' => 'Admin Updated Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Admin Could not Updated Successfully']);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $result = Admin::where('admin_id', '=', $id)->first();
        if ($result) {
            $data = $result->user_id;
            if (!is_null($result->image)) {
                $desitination = 'public/project_images/admin/' . $result->image;
                if (File::exists($desitination)) {
                    File::delete($desitination);
                }
            }
            User::where('id', '=', $data)->delete();
            Admin::where('admin_id', '=', $id)->delete();
            return response()->json(['status' => 'true', 'msg' => 'Admin Deleted Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Admin could not Deleted']);
        }
    }

    public function find(Request $request)
    {
        $id = $request->id;
        return Admin::where('admin_id', $id)->first();
    }

    public function update_status(Request $request)
    {
        $result = Admin::where('admin_id', $request->code)->update([
            'status' => $request->status
        ]);

        if ($result) {
            return response()->json(['status' => 'true', 'msg' => 'Status Updated Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Status could not Updated Successfully']);
        }
    }
}
