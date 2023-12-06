<?php

namespace App\Http\Controllers;

use App\Models\Contractors;
use App\Models\ContructorPaymentLog;
use App\Models\Employee;
use App\Models\Invitation;
use App\Models\Project;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;


class ContractorsController extends Controller
{
    const ACCEPTED = 2;
    public function create()
    {
        if (session()->get('admin_id')) {
            $role = RolePermission::all();
            $projects = Project::all();
            return view('admin.contractors.create', ['role' => $role, 'projects' => $projects]);
        } else {
            return redirect("/");
        }
    }

    public function list()
    {
        if (session()->get('admin_id')) {
            $role = RolePermission::all();
            $projects = Project::all();
            $contractors = Contractors::join('users', 'users.id', '=', 'contractors.user_id')->where('users.type', '=', 'contractor')->orderBy('contractors.contractor_id', 'DESC')->get();
            return view('admin.contractors.list', ['contractors' => $contractors, 'role' => $role, 'projects' => $projects]);
        } else {
            return redirect("/");
        }
    }

    public function store(Request $request)
    {
        $contractor = User::where('email', '=', $request->email)->get();
        if (count($contractor) > 0) {
            return response()->json(['status' => 'false', 'msg' => 'This Email already Exists']);
        } else {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extention = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extention;
                $file->move('public/project_images/contractor/', $filename);

                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'type' => 'contractor'
                ]);
                $UserId = DB::getPdo()->lastInsertId();
                if (!is_null($request->projects)) {
                    $result = Contractors::create([
                        'user_id' => $UserId,
                        'contact' => $request->contact,
                        'project' => implode(",", $request->projects),
                        'dob' => $request->dob,
                        'address' => $request->address,
                        'image' => $filename,
                        'status' => 1,
                    ]);
                } else {
                    $result = Contractors::create([
                        'user_id' => $UserId,
                        'contact' => $request->contact,
                        'dob' => $request->dob,
                        'address' => $request->address,
                        'image' => $filename,
                        'status' => 1,
                    ]);
                }
            } else {
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'type' => 'contractor'
                ]);
                $UserId = DB::getPdo()->lastInsertId();
                if (!is_null($request->projects)) {
                    $result = Contractors::create([
                        'user_id' => $UserId,
                        'contact' => $request->contact,
                        'project' => implode(",", $request->projects),
                        'dob' => $request->dob,
                        'address' => $request->address,
                        'status' => 1,
                    ]);
                } else {
                    $result = Contractors::create([
                        'user_id' => $UserId,
                        'contact' => $request->contact,
                        'dob' => $request->dob,
                        'address' => $request->address,
                        'status' => 1,
                    ]);
                }
            }
            if ($result) {
                return response()->json(['status' => 'true', 'msg' => 'Contractor Added Successfully']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Contractor Could not Added Successfully']);
            }
        }
    }



    public function view($code)
    {
        $role = RolePermission::all();
        $projects = Project::all();

        $contractor = Contractors::join('users', 'users.id', '=', 'contractors.user_id')
            ->where('users.type', '=', 'contractor')
            ->where('contractor_id', '=', $code)
            ->first();

        $contractorLogs = [];

        if ($contractor) {
            // First check if the contractor exists

            $invitationContractors = Invitation::where(['contractor_id' => $contractor->user_id, 'status' => self::ACCEPTED])
                ->pluck('project_id'); // Fetch project_ids based on matching contractor_id
            $projects = Project::whereIn('projects.project_id', $invitationContractors)->where('invitations.contractor_id', $contractor->user_id)
                ->join('invitations', 'projects.project_id', '=', 'invitations.project_id')
                ->select('projects.*', 'invitations.price as contractor_payment')
                ->distinct()
                ->get();
            // Fetch contractor logs for each project
            foreach ($projects as $project) {
                $invite =  Invitation::where(['contractor_id' => $contractor->user_id, 'project_id' => $project->project_id, 'status' => self::ACCEPTED])->first();
                $remaining_amount = ContructorPaymentLog::where('project_id', $project->project_id)->sum('payment');
                $project->remaining_amount = $invite->price - ($remaining_amount ?? 0) > 0 ? $invite->price - ($remaining_amount ?? 0) : 0;

                $logs = ContructorPaymentLog::where(['project_id' => $project->project_id, 'contractor_id' => $contractor->user_id])
                    ->orderBy('id', 'desc')
                    ->get();

                $contractorLogs[$project->project_id] = $logs;
            }
        } else {
            // Contractor not found, handle the case accordingly
            $projects = collect(); // Empty collection
        }
        return view('admin.contractors.view', ['contractor' => $contractor, 'role' => $role, 'projects' => $projects, 'contractorLogs' => $contractorLogs]);
    }

    public function add_payment(Request $request)
    {
        $project_id = $request->project_id;
        $contractor_id = $request->contractor_id;
        $payment = $request->payment;

        // Check if the contractor and project IDs match in the Invitation model
        $invitation = Invitation::where('contractor_id', $contractor_id)
            ->where('project_id', $project_id)
            ->first();

        if ($invitation) {
            // If the Invitation is found, get the price from it
            $price = $invitation->price;

            // Check if the contractor's payment data already exists
            $contractorPaymentLog = ContructorPaymentLog::where(['project_id' => $project_id, 'contractor_id' => $contractor_id])->latest('created_at')->first();

            if ($contractorPaymentLog) {
                // If data exists, update the remaining_payment column
                $remainingPayment = $contractorPaymentLog->remaining_payment - $payment;

                // Check if payment exceeds the remaining payment
                if ($payment > $contractorPaymentLog->remaining_payment) {
                    return response()->json(['status' => false, 'message' => 'Payment exceeds! Remaining Payment is $' . $contractorPaymentLog->remaining_payment]);
                }

                ContructorPaymentLog::create([
                    'project_id' => $project_id,
                    'contractor_id' => $contractor_id,
                    'payment' => $payment,
                    'date' => $request->date,
                    'remaining_payment' => $remainingPayment,
                    'payment_type' => $request->payment_type,
                    'message' => $request->message
                ]);
            } else {
                // If data does not exist, calculate the remaining payment
                $remainingPayment = $price - $payment;

                // Check if payment exceeds the total price
                if ($payment > $price) {
                    return response()->json(['status' => false, 'message' => 'Payment exceeds! Remaining Payment is $' . $price]);
                }

                ContructorPaymentLog::create([
                    'project_id' => $project_id,
                    'contractor_id' => $contractor_id,
                    'payment' => $payment,
                    'date' => $request->date,
                    'remaining_payment' => $remainingPayment,
                    'payment_type' => $request->payment_type,
                    'message' => $request->message
                ]);
            }

            // Perform any other actions or validations if needed

            // Return a success response if everything is successful
            return response()->json(['status' => true, 'message' => 'Payment added successfully']);
        } else {
            // Return an error response if the Invitation is not found
            return response()->json(['status' => false, 'message' => 'Invitation Does not found!']);
        }
    }


    public function edit($code)
    {
        if (session()->get('admin_id')) {
            $role = RolePermission::all();
            $projects = Project::all();
            $contractor = Contractors::join('users', 'users.id', '=', 'contractors.user_id')
                ->where('users.type', '=', 'contractor')->where('contractor_id', '=', $code)->first();
            return view('admin.contractors.edit', ['contractor' => $contractor, 'role' => $role, 'projects' => $projects]);
        } else {
            return redirect("/");
        }
    }

    public function update(Request $request)
    {
        if ($request->hasFile('image')) {
            $data = Contractors::where('contractor_id', $request->code)->first();
            if (!is_null($data->image)) {
                $desitination = 'public/project_images/contractor/' . $data->image;
                if (File::exists($desitination)) {
                    File::delete($desitination);
                }
            }
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('public/project_images/contractor/', $filename);

            // $image = $request->file('image');
            // $filename = $input['imagename'] = time() . '.' . $image->extension();
            // $thumbnailDirectory = public_path('public/project_images/contractor/');
            // if (!file_exists($thumbnailDirectory)) {
            //     mkdir($thumbnailDirectory, 0755, true);
            // }
            // $img = Image::make($image->path());
            // $img->resize(100, 100, function ($constraint) {
            //     $constraint->aspectRatio();
            // })->save($thumbnailDirectory . '/' . $input['imagename']);

            $getContractor = Contractors::where('contractor_id', $request->code)->first();
            if (!is_null($request->projects)) {
                $result = User::where('id', $getContractor->user_id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                $result = Contractors::where('contractor_id', $request->code)->update([
                    'contact' => $request->contact,
                    'project' => implode(",", $request->projects),
                    'dob' => $request->dob,
                    'address' => $request->address,
                    'image' => $filename,
                    // 'status' => $request->status,
                ]);
            } else {
                $result = User::where('id', $getContractor->user_id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                $result = Contractors::where('contractor_id', $request->code)->update([
                    'contact' => $request->contact,
                    'dob' => $request->dob,
                    'address' => $request->address,
                    'image' => $filename,
                    // 'status' => $request->status,
                ]);
            }
        } else {
            $getContractor = Contractors::where('contractor_id', $request->code)->first();
            if (!is_null($request->projects)) {
                $result = User::where('id', $getContractor->user_id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                $result = Contractors::where('contractor_id', $request->code)->update([
                    'contact' => $request->contact,
                    'project' => implode(",", $request->projects),
                    'dob' => $request->dob,
                    'address' => $request->address,
                    // 'status' => $request->status,
                ]);
            } else {
                $result = User::where('id', $getContractor->user_id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                $result = Contractors::where('contractor_id', $request->code)->update([
                    'contact' => $request->contact,
                    'dob' => $request->dob,
                    'address' => $request->address,
                    // 'status' => $request->status,
                ]);
            }
        }

        if ($result) {
            return response()->json(['status' => 'true', 'msg' => 'Contractor Updated Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Contractor Could not Updated Successfully']);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $result = Contractors::where('contractor_id', '=', $id)->first();
        if ($result) {
            $data = $result->user_id;
            if (!is_null($result->image)) {
                $desitination = 'public/project_images/contractor/' . $result->image;
                if (File::exists($desitination)) {
                    File::delete($desitination);
                }
            }
            User::where('id', '=', $data)->delete();
            Contractors::where('contractor_id', '=', $id)->delete();
            return response()->json(['status' => 'true', 'msg' => 'Contractor Deleted Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Contractor could not Deleted']);
        }
    }

    public function find(Request $request)
    {
        $id = $request->id;
        return Contractors::where('contractor_id', $id)->first();
    }

    public function update_status(Request $request)
    {
        $result = Contractors::where('contractor_id', $request->code)->update([
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
