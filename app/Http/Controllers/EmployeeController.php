<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use App\Models\EmployeePayment;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;


class EmployeeController extends Controller
{
    public function create()
    {
        if (session()->get('admin_id')) {
            $companies = Company::where('status', 1)->get();
            $role = RolePermission::all();
            return view('admin.employee.create', ['companies' => $companies, 'role' => $role]);
        } else {
            return redirect("/");
        }
    }

    public function list()
    {
        if (session()->get('admin_id')) {
            $role = RolePermission::all();
            $employees = Employee::join('users', 'users.id', '=', 'employees.user_id')
                ->join('companies', 'companies.company_id', '=', 'employees.company', 'left')
                ->where('users.type', '=', 'employee')
                ->select('users.*', 'employees.*', 'companies.name as company_name')->orderBy('employees.employee_id', 'DESC')->get();
            if ($employees) {
                return view('admin.employee.list', ['employees' => $employees, 'role' => $role]);
            } else {
                return redirect()->back();
            }
        } else {
            return redirect("/");
        }
    }

    public function store(Request $request)
    {
        $employee = User::where('email', '=', $request->e_email)->get();
        if (count($employee) > 0) {
            return response()->json(['status' => 'false', 'msg' => 'This Email already Exists']);
        } else {
            if ($request->hasFile('e_image')) {
                // $image = $request->file('e_image');
                // $filename = $input['imagename'] = time() . '.' . $image->extension();
                // $thumbnailDirectory = public_path('public/project_images/employee/');
                // if (!file_exists($thumbnailDirectory)) {
                //     mkdir($thumbnailDirectory, 0755, true);
                // }
                // $img = Image::make($image->path());
                // $img->resize(100, 100, function ($constraint) {
                //     $constraint->aspectRatio();
                // })->save($thumbnailDirectory . '/' . $input['imagename']);

                $file = $request->file('e_image');
                $extention = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extention;
                $file->move('public/project_images/employee/', $filename);

                User::create([
                    'name' => $request->e_name,
                    'email' => $request->e_email,
                    'password' => Hash::make($request->e_password),
                    'type' => 'employee'
                ]);
                $UserId = DB::getPdo()->lastInsertId();
                $result = Employee::create([
                    'user_id' => $UserId,
                    'contact' => $request->e_contact,
                    'company' => $request->e_company,
                    'dob' => $request->e_dob,
                    'description' => $request->e_details,
                    'image' => $filename,
                    'status' => 1,
                ]);
            } else {
                User::create([
                    'name' => $request->e_name,
                    'email' => $request->e_email,
                    'password' => Hash::make($request->e_password),
                    'type' => 'employee'
                ]);
                $UserId = DB::getPdo()->lastInsertId();
                $result = Employee::create([
                    'user_id' => $UserId,
                    'contact' => $request->e_contact,
                    'company' => $request->e_company,
                    'dob' => $request->e_dob,
                    'description' => $request->e_details,
                    'status' => 1,
                ]);
            }
            if ($result) {
                return response()->json(['status' => 'true', 'msg' => 'Employee Added Successfully']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Employee Could not Added Successfully']);
            }
        }
    }

    public function view($code)
    {
        if (session()->get('admin_id')) {
            $companies = Company::all();
            $role = RolePermission::all();
            $employee = Employee::join('users', 'users.id', '=', 'employees.user_id')
                ->join('companies', 'companies.company_id', '=', 'employees.company', 'left')
                ->where('users.type', '=', 'employee')
                ->select('users.*', 'employees.*', 'companies.name as company_name')
                ->where('employees.employee_id', '=', $code)->first();
            $payment_logs = EmployeePayment::where('employee_id', $employee->user_id)->orderBy('id', 'desc')->get();
            if ($employee) {
                return view('admin.employee.view', ['companies' => $companies, 'employee' => $employee, 'role' => $role, 'payment_logs' => $payment_logs]);
            } else {
                return redirect()->back();
            }
        } else {
            return redirect("/");
        }
    }


    public function add_payment(Request $request)
    {
        $result = EmployeePayment::create([
            'employee_id' => $request->employee_id,
            'payment' => $request->payment,
            'date' => $request->date,
            'payment_type' => $request->payment_type,
            'message' => $request->message
        ]);
        if ($result) {
            return response()->json(['status' => true, 'msg' => 'Payment Added Successfully']);
        } else {
            return response()->json(['status' => false, 'msg' => 'Payment Could not Added Successfully']);
        }
    }

    public function edit($code)
    {
        if (session()->get('admin_id')) {
            $companies = Company::all();
            $role = RolePermission::all();
            $employee = Employee::join('users', 'users.id', '=', 'employees.user_id')
                ->where('users.type', '=', 'employee')
                ->where('employees.employee_id', '=', $code)->first();
            return view('admin.employee.edit', ['employee' => $employee, 'companies' => $companies, 'role' => $role]);
        } else {
            return redirect("/");
        }
    }

    public function update(Request $request)
    {
        if ($request->hasFile('e_image')) {
            $data = Employee::where('employee_id', $request->code)->first();
            if (!is_null($data->image)) {
                $desitination = 'public/project_images/employee/' . $data->image;
                if (File::exists($desitination)) {
                    File::delete($desitination);
                }
            }
            // $image = $request->file('e_image');
            // $filename = $input['imagename'] = time() . '.' . $image->extension();
            // $thumbnailDirectory = public_path('public/project_images/employee/');
            // if (!file_exists($thumbnailDirectory)) {
            //     mkdir($thumbnailDirectory, 0755, true);
            // }
            // $img = Image::make($image->path());
            // $img->resize(100, 100, function ($constraint) {
            //     $constraint->aspectRatio();
            // })->save($thumbnailDirectory . '/' . $input['imagename']);
            $file = $request->file('e_image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('public/project_images/employee/', $filename);

            $getEmployee = Employee::where('employee_id', $request->code)->first();
            $result = User::where('id', $getEmployee->user_id)->update([
                'name' => $request->e_name,
                'email' => $request->e_email,
                'password' => Hash::make($request->e_password),
            ]);
            $result = Employee::where('employee_id', $request->code)->update([
                'contact' => $request->e_contact,
                'company' => $request->e_company,
                'dob' => $request->e_dob,
                'description' => $request->e_details,
                'image' => $filename,
                // 'status' => $request->e_status,
            ]);
        } else {
            $getEmployee = Employee::where('employee_id', $request->code)->first();
            $result = User::where('id', $getEmployee->user_id)->update([
                'name' => $request->e_name,
                'email' => $request->e_email,
                'password' => Hash::make($request->e_password),
            ]);
            $result = Employee::where('employee_id', $request->code)->update([
                'contact' => $request->e_contact,
                'company' => $request->e_company,
                'dob' => $request->e_dob,
                'description' => $request->e_details,
                // 'status' => $request->e_status,
            ]);
        }

        if ($result) {
            return response()->json(['status' => 'true', 'msg' => 'Employee Updated Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Employee Could not Updated Successfully']);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $result = Employee::where('employee_id', '=', $id)->first();
        if ($result) {
            $data = $result->user_id;
            if (!is_null($result->image)) {
                $desitination = 'public/project_images/employee/' . $result->image;
                if (File::exists($desitination)) {
                    File::delete($desitination);
                }
            }
            User::where('id', '=', $data)->delete();
            Employee::where('employee_id', '=', $id)->delete();
            return response()->json(['status' => 'true', 'msg' => 'Employee Deleted Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Employee could not Deleted']);
        }
    }

    public function find(Request $request)
    {
        $id = $request->id;
        return Employee::where('employee_id', $id)->first();
    }

    public function update_status(Request $request)
    {
        $result = Employee::where('employee_id', $request->code)->update([
            'status' => $request->status
        ]);

        if ($result) {
            return response()->json(['status' => 'true', 'msg' => 'Status Updated Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Status could not Updated Successfully']);
        }
    }

    public function update_password(Request $request)
    {
        if ($request->new_password != $request->confirm_password) {
            return response()->json(['status' => 'false', 'msg' => 'Confirm Password not Matched']);
        } else {
            if ($request->has('old_password')) {
                $data = User::where('id', $request->id)->first();
                if (!Hash::check($request['old_password'], $data->password)) {
                    return response()->json(['status' => 'false', 'msg' => 'Old Password Not Matched']);
                } else {
                    $result = User::where('id', $request->id)->update([
                        'password' => Hash::make($request->new_password),
                    ]);
                }
            } else {
                $result = User::where('id', $request->id)->update([
                    'password' => Hash::make($request->new_password),
                ]);
            }
            if (!$result) {
                return response()->json(['status' => 'false', 'msg' => 'Passowrd Could not change']);
            } else {
                return response()->json(['status' => 'true', 'msg' => 'Passowrd has changed']);
            }
        }
    }
}
