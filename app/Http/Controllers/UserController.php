<?php

namespace App\Http\Controllers;

use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function create()
    {
        if (session()->get('admin_id')) {
            $role = RolePermission::all();
            return view('admin.user.create', ['role' => $role]);
        } else {
            return redirect("/");
        }
    }

    public function list(): View|Factory|Redirector|RedirectResponse|Application
    {
        if (session()->get('admin_id')) {
            $role = RolePermission::all();
            return view('admin.user.list', ['role' => $role]);
        } else {
            return redirect("/");
        }
    }

    public function store(Request $request): JsonResponse
    {
        $result = User::create([
            'name' => Str::lower($request->name),
            'email' => $request->email,
            'password' => $request->password,
            'country' => $request->country,
            'contact' => $request->contact,
            'description' => $request->description,
            'date' => date('Y-m-d'),
            'status' => 1,
        ]);
        if ($result) {
            return response()->json(['status' => 'true', 'msg' => 'User Added Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'User Could not Added Successfully']);
        }
    }
}
