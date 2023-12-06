<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function create()
    {
        if (session()->get('admin_id')) {
            $role = RolePermission::all();
            return view('admin.company.create', ['role' => $role]);
        } else {
            return redirect("/");
        }
    }

    public function list()
    {
        if (session()->get('admin_id')) {
            $role = RolePermission::all();
            $companies = Company::orderByDesc('company_id')->get();
            return view('admin.company.list', ['companies' => $companies, 'role' => $role]);
        } else {
            return redirect("/");
        }
    }

    public function find(Request $request)
    {
        $id = $request->id;
        $result = Company::where('company_id', $id)->first();
        if ($result) {
            return $result;
        } else {
            return response()->json(['status' => 'False', 'msg' => 'Something is wrong']);
        }
    }

    public function update_status(Request $request)
    {
        $result = Company::where('company_id', $request->code)->update([
            'status' => $request->status
        ]);

        if ($result) {
            return response()->json(['status' => 'true', 'msg' => 'Status Updated Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Status could not Updated Successfully']);
        }
    }

    public function store(Request $request)
    {
        $company = Company::where('email', '=', $request->c_email)->get();
        if (count($company) > 0) {
            return response()->json(['status' => 'false', 'msg' => 'Company Email already Exists']);
        } else {
            $result = Company::create([
                'name' => $request->c_name,
                'contact' => $request->c_contact,
                'email' => $request->c_email,
                'address' => $request->c_address,
                'status' => 1,
            ]);
            if ($result) {
                return response()->json(['status' => 'true', 'msg' => 'Company Added Successfully']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Company Could not Added Successfully']);
            }
        }
    }

    public function edit($code)
    {
        $company = Company::where('company_id', '=', $code)->first();
        $role = RolePermission::all();
        return view('admin.company.edit', ['company' => $company, 'role' => $role]);
    }

    public function view($code)
    {
        $company = Company::where('company_id', '=', $code)->first();
        $role = RolePermission::all();
        return view('admin.company.view', ['company' => $company, 'role' => $role]);
    }

    public function update(Request $request)
    {
        $result = Company::where('company_id', $request->code)->update([
            'name' => $request->c_name,
            'contact' => $request->c_contact,
            'email' => $request->c_email,
            'address' => $request->c_address,
            // 'status' => $request->c_status,
        ]);
        if ($result) {
            return response()->json(['status' => 'true', 'msg' => 'Company Updated Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Company Could not Update']);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $result = Company::where('company_id', '=', $id)->first();
        if ($result) {
            Company::where('company_id', '=', $id)->delete();
            return response()->json(['status' => 'true', 'msg' => 'Company Deleted Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Company Could not Deleted']);
        }
    }
}
