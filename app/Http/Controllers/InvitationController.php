<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Contractors;
use App\Models\Invitation;
use App\Models\Project;
use App\Models\RolePermission;
use App\Mail\InvitationMail;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class InvitationController extends Controller
{

    public function list()
    {
        if (session()->get('admin_id')) {
            $role = DB::table('role_permissions')->get();
            if (session()->get('type') == 'admin') {
                $invitations = Invitation::with(['contractor', 'invitedBy', 'project'])->orderBy('invitation_id','desc')->get();
            } elseif (session()->get('type') == 'contractor') {
                $user =  User::find(session()->get('admin_id'));
                $invitations = Invitation::where('contractor_id', $user->id)->with(['contractor', 'invitedBy', 'project'])->orderBy('invitation_id','desc')->get();
            } elseif (session()->get('type') == 'employee') {
                $employee_id = session()->get('admin_id');
                $invitations = Invitation::with(['contractor', 'invitedBy'])->join('projects', 'projects.project_id', '=', 'invitations.project_id', 'left')->join('employees', 'employees.company', '=', 'projects.company')->where('employees.user_id', $employee_id)->select('invitations.*')->orderBy('invitations.invitation_id','desc')->get();
            }
            return view('admin.invitations.list', ['invitation' => $invitations, 'role' => $role]);
        }
    }

    public function store(Request $request)
    {
        $result = Invitation::where(['project_id' => $request->project_id, 'contractor_id' => $request->contractor_id])->first();
        if ($result) {
            return response()->json(['status' => 'false', 'msg' => 'Invitation has already been sent!']);
        }
        $request->validate([
            'project_id' => 'required',
            'contractor_id' => 'required',
        ]);
        $user_id = Session()->get('admin_id');
        $result = Invitation::create([
            'project_id' => $request->project_id,
            'contractor_id' => $request->contractor_id,
            'invited_by' => $user_id,
            'price' => $request->price,
            'message' => $request->message,
            'status' => 0
        ]);
        $data = User::where('id', $request->contractor_id)->first();
        $project = Project::where('project_id', $request->project_id)->first();
        if ($result) {
            // echo $data->email;
            // print_r($request->all());
            $record = [
                'name' => $data->name,
                'designation' => $data->designation,
                'email' => $data->email,
                'project_name' => $project->name ?? '',
                'email' => encrypt($data->email),
                'password' => $data->password,
                'invitation_id' => $result->id
            ];

            Mail::to($data->email)->send(new InvitationMail($record));
            return response()->json(['status' => 'true', 'msg' => 'Invitation has been sent']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Invitation has not been sent']);
        }
    }

    public function edit($code)
    {
        $invite = Invitation::where('invitation_id', '=', $code)->first();
        return view('admin.invitations.edit', ['invite' => $invite]);
    }

    public function view($id)
    {
        $role = RolePermission::all();
        if (session()->get('type') == 'admin') {
            $invitation = Invitation::with(['contractor', 'invitedBy', 'project'])->first();
        } elseif (session()->get('type') == 'contractor') {
            $user =  User::find(session()->get('admin_id'));
            $invitation = Invitation::where('contractor_id', $user->id)->with(['contractor', 'invitedBy', 'project'])->first();
        }
        return view('admin.invitations.view', ['invitation' => $invitation, 'role' => $role]);
    }

    public function update(Request $request)
    {
        $result = Invitation::where('invitation_id', $request->code)->update([
            'status' => $request->status,
        ]);
        if ($request->status == 2) {
            $data = Invitation::where('invitation_id', $request->code)->first();
            $project = Project::where('project_id', '=', $data->project_id)->first();
            if (!is_null($project->contractors)) {
                $value = $data->contractor . "," . $project->contractors;
                $val1 = explode(",", $value);
                $val2 = implode(",", $val1);
                $result = Project::where('project_id', $data->project_id)->update([
                    'contractors' => $val2,
                ]);
            } else {
                $val1 = explode(" ", $data->contractor);
                $val2 = implode(" ", $val1);
                $result = Project::where('project_id', $data->project_id)->update([
                    'contractors' => $val2,
                ]);
            }
        }
        if ($result) {
            return response()->json(['status' => 'true', 'msg' => 'Status Updated Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Status could not Updated Successfully']);
        }
    }

    public function find(Request $request)
    {
        $id = $request->id;
        return Invitation::where('invitation_id', $id)->first();
    }

    public function update_status(Request $request)
    {
        $result = Invitation::where('Invitation_id', $request->code)->update([
            'status' => $request->status
        ]);

        if ($request->status == 2) {
            $data = Invitation::where('invitation_id', $request->code)->first();
            $project = Project::where('project_id', '=', $data->project_id)->first();
            if (!is_null($project->contractors)) {
                $value = $data->contractor_id . "," . $project->contractors;
                $val1 = explode(",", $value);
                $val2 = implode(",", $val1);
                $result = Project::where('project_id', $data->project_id)->update([
                    'contractors' => $val2,
                ]);
            } else {
                $val1 = explode(" ", $data->contractor_id);
                $val2 = implode(" ", $val1);
                $result = Project::where('project_id', $data->project_id)->update([
                    'contractors' => $val2,
                ]);
            }
        }

        if ($result) {
            return response()->json(['status' => 'true', 'msg' => 'Status Updated Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Status could not Updated Successfully']);
        }
    }
}
