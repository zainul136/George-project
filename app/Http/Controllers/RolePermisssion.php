<?php

namespace App\Http\Controllers;

use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RolePermisssion extends Controller
{
    public function create()
    {
        if (session()->get('admin_id')) {
            $role = RolePermission::all();
            return view('admin.roles_and_permissions.create', ['role' => $role]);
        } else {
            return redirect("/");
        }
    }

    public function list()
    {
        if (session()->get('admin_id')) {
            $role = RolePermission::all();
            $employees = RolePermission::where('type', '=', 'employees')->take(7)->get();
            $contractors = RolePermission::where('type', '=', 'contractors')->take(7)->get();
            return view('admin.roles_and_permissions.list', ['employees' => $employees, 'contractors' => $contractors, 'role' => $role]);
        } else {
            return redirect("/");
        }
    }

    public function store(Request $request)
    {
        $result = RolePermission::create([
            'role' => Str::lower($request->name),
            'description' => $request->description,
            'permission' => '1',
            'type' => $request->type
        ]);

        if ($result) {
            return response()->json(['status' => 'true', 'msg' => 'Role Added Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Role Could not Added Successfully']);
        }
    }

    public function update(Request $request)
    {
        $result = RolePermission::where('id', $request->code)->first();
        if ($result) {
            if ($request->type == "on") {
                $data = RolePermission::where('id', $result->id)->update([
                    'permission' => '1',
                ]);
            } else {
                $data = RolePermission::where('id', $result->id)->update([
                    'permission' => '0',
                ]);
            }
            if ($data) {
                return response()->json(['status' => 'true', 'msg' => 'Permission Enable Successfully']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Permission Disable Successfully']);
            }
        }
    }
}
