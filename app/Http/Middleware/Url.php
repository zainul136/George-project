<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Url
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // dd($role);
        if (session()->get('type') == 'admin') {
            return $next($request);
        } elseif (session()->get('type') == 'employee') {
            $data = DB::table('role_permissions')->get();
            if ($role == "dashboard" && $data[0]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-create" && $data[1]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-store" && $data[1]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-list" && $data[1]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-edit" && $data[1]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-view" && $data[1]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-find" && $data[1]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-update" && $data[1]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-delete" && $data[1]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-employee-find" && $data[1]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-update-status" && $data[1]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-update-password" && $data[1]->permission == '1') {
                return $next($request);
            } elseif ($role == "company-create" && $data[2]->permission == '1') {
                return $next($request);
            } elseif ($role == "company-store" && $data[2]->permission == '1') {
                return $next($request);
            } elseif ($role == "company-list" && $data[2]->permission == '1') {
                return $next($request);
            } elseif ($role == "company-edit" && $data[2]->permission == '1') {
                return $next($request);
            } elseif ($role == "company-view" && $data[2]->permission == '1') {
                return $next($request);
            } elseif ($role == "company-update" && $data[2]->permission == '1') {
                return $next($request);
            } elseif ($role == "company-delete" && $data[2]->permission == '1') {
                return $next($request);
            } elseif ($role == "company-find" && $data[2]->permission == '1') {
                return $next($request);
            } elseif ($role == "company-update-status" && $data[2]->permission == '1') {
                return $next($request);
            } elseif ($role == "project-create" && $data[3]->permission == '1') {
                return $next($request);
            } elseif ($role == "project-store" && $data[3]->permission == '1') {
                return $next($request);
            } elseif ($role == "project-list" && $data[3]->permission == '1') {
                return $next($request);
            } elseif ($role == "project-edit" && $data[3]->permission == '1') {
                return $next($request);
            } elseif ($role == "project-view" && $data[3]->permission == '1') {
                return $next($request);
            } elseif ($role == "project-update" && $data[3]->permission == '1') {
                return $next($request);
            } elseif ($role == "project-delete" && $data[3]->permission == '1') {
                return $next($request);
            } elseif ($role == "project-find" && $data[3]->permission == '1') {
                return $next($request);
            } elseif ($role == "project-update-status" && $data[3]->permission == '1') {
                return $next($request);
            } elseif ($role == "client-create" && $data[4]->permission == '1') {
                return $next($request);
            } elseif ($role == "client-store" && $data[4]->permission == '1') {
                return $next($request);
            } elseif ($role == "client-list" && $data[4]->permission == '1') {
                return $next($request);
            } elseif ($role == "client-edit" && $data[4]->permission == '1') {
                return $next($request);
            } elseif ($role == "client-view" && $data[4]->permission == '1') {
                return $next($request);
            } elseif ($role == "client-update" && $data[4]->permission == '1') {
                return $next($request);
            } elseif ($role == "client-delete" && $data[4]->permission == '1') {
                return $next($request);
            } elseif ($role == "client-find" && $data[4]->permission == '1') {
                return $next($request);
            } elseif ($role == "client-update-status" && $data[4]->permission == '1') {
                return $next($request);
            } elseif ($role == "contractor-create" && $data[5]->permission == '1') {
                return $next($request);
            } elseif ($role == "contractor-store" && $data[5]->permission == '1') {
                return $next($request);
            } elseif ($role == "contractor-list" && $data[5]->permission == '1') {
                return $next($request);
            } elseif ($role == "contractor-edit" && $data[5]->permission == '1') {
                return $next($request);
            } elseif ($role == "contractor-view" && $data[5]->permission == '1') {
                return $next($request);
            } elseif ($role == "contractor-update" && $data[5]->permission == '1') {
                return $next($request);
            } elseif ($role == "contractor-delete" && $data[5]->permission == '1') {
                return $next($request);
            } elseif ($role == "contractor-find" && $data[5]->permission == '1') {
                return $next($request);
            } elseif ($role == "contractor-update-status" && $data[5]->permission == '1') {
                return $next($request);
            } elseif ($role == "contractor-update-password" && $data[5]->permission == '1') {
                return $next($request);
            } elseif ($role == "invite-create" && $data[6]->permission == '1') {
                return $next($request);
            } elseif ($role == "invite-store" && $data[6]->permission == '1') {
                return $next($request);
            } elseif ($role == "invite-list" && $data[6]->permission == '1') {
                return $next($request);
            } elseif ($role == "invite-edit" && $data[6]->permission == '1') {
                return $next($request);
            } elseif ($role == "invite-update" && $data[6]->permission == '1') {
                return $next($request);
            } elseif ($role == "invite-find" && $data[6]->permission == '1') {
                return $next($request);
            } elseif ($role == "invite-update-status" && $data[6]->permission == '1') {
                return $next($request);
            } elseif ($role == "admin-create") {
                abort('401');
            } elseif ($role == "admin-list") {
                abort('401');
            } elseif ($role == "admin-store") {
                abort('401');
            } elseif ($role == "admin-edit") {
                abort('401');
            } elseif ($role == "admin-update-password") {
                abort('401');
            } elseif ($role == "admin-view") {
                abort('401');
            } elseif ($role == "admin-update") {
                abort('401');
            } elseif ($role == "admin-delete") {
                abort('401');
            } elseif ($role == "admin-find") {
                abort('401');
            } elseif ($role == "admin-status") {
                abort('401');
            } elseif ($role == "role-create") {
                abort('401');
            } elseif ($role == "role-list") {
                abort('401');
            } elseif ($role == "role-store") {
                abort('401');
            } elseif ($role == "role-update") {
                abort('401');
            } else {
                abort('401');
            }
        } elseif (session()->get('type') == 'contractor') {
            $data = DB::table('role_permissions')->get();
            if ($role == "dashboard" && $data[7]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-create" && $data[8]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-store" && $data[8]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-list" && $data[8]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-edit" && $data[8]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-find" && $data[1]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-view" && $data[8]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-update" && $data[8]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-delete" && $data[8]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-employee-find" && $data[8]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-update-status" && $data[8]->permission == '1') {
                return $next($request);
            } elseif ($role == "employee-update-password" && $data[8]->permission == '1') {
                return $next($request);
            } elseif ($role == "company-create" && $data[9]->permission == '1') {
                return $next($request);
            } elseif ($role == "company-store" && $data[9]->permission == '1') {
                return $next($request);
            } elseif ($role == "company-list" && $data[9]->permission == '1') {
                return $next($request);
            } elseif ($role == "company-edit" && $data[9]->permission == '1') {
                return $next($request);
            } elseif ($role == "company-view" && $data[9]->permission == '1') {
                return $next($request);
            } elseif ($role == "company-update" && $data[9]->permission == '1') {
                return $next($request);
            } elseif ($role == "company-delete" && $data[9]->permission == '1') {
                return $next($request);
            } elseif ($role == "company-find" && $data[9]->permission == '1') {
                return $next($request);
            } elseif ($role == "company-update-status" && $data[9]->permission == '1') {
                return $next($request);
            } elseif ($role == "project-create" && $data[10]->permission == '1') {
                return $next($request);
            } elseif ($role == "project-store" && $data[10]->permission == '1') {
                return $next($request);
            } elseif ($role == "project-list" && $data[10]->permission == '1') {
                return $next($request);
            } elseif ($role == "fetch-available-contractors" && $data[10]->permission == '1') {
                return $next($request);
            } elseif ($role == "project-edit" && $data[10]->permission == '1') {
                abort('401');
            } elseif ($role == "project-view" && $data[10]->permission == '1') {
                return $next($request);
            } elseif ($role == "invite-view" && $data[10]->permission == '1') {
                return $next($request);
            } elseif ($role == "project-update" && $data[10]->permission == '1') {
                abort('401');
            } elseif ($role == "project-delete" && $data[10]->permission == '1') {
                abort('401');
            } elseif ($role == "project-find" && $data[10]->permission == '1') {
                return $next($request);
            } elseif ($role == "project-update-status" && $data[10]->permission == '1') {
                return $next($request);
            } elseif ($role == "client-create" && $data[11]->permission == '1') {
                return $next($request);
            } elseif ($role == "client-store" && $data[11]->permission == '1') {
                return $next($request);
            } elseif ($role == "client-list" && $data[11]->permission == '1') {
                return $next($request);
            } elseif ($role == "client-edit" && $data[11]->permission == '1') {
                return $next($request);
            } elseif ($role == "client-view" && $data[11]->permission == '1') {
                return $next($request);
            } elseif ($role == "client-update" && $data[11]->permission == '1') {
                return $next($request);
            } elseif ($role == "client-delete" && $data[11]->permission == '1') {
                return $next($request);
            } elseif ($role == "client-find" && $data[11]->permission == '1') {
                return $next($request);
            } elseif ($role == "client-update-status" && $data[11]->permission == '1') {
                return $next($request);
            } elseif ($role == "contractor-create" && $data[12]->permission == '1') {
                return $next($request);
            } elseif ($role == "contractor-store" && $data[12]->permission == '1') {
                return $next($request);
            } elseif ($role == "contractor-list" && $data[12]->permission == '1') {
                return $next($request);
            } elseif ($role == "contractor-edit" && $data[12]->permission == '1') {
                return $next($request);
            } elseif ($role == "contractor-view" && $data[12]->permission == '1') {
                return $next($request);
            } elseif ($role == "contractor-update" && $data[12]->permission == '1') {
                return $next($request);
            } elseif ($role == "contractor-delete" && $data[12]->permission == '1') {
                return $next($request);
            } elseif ($role == "contractor-find" && $data[12]->permission == '1') {
                return $next($request);
            } elseif ($role == "contractor-update-status" && $data[12]->permission == '1') {
                return $next($request);
            } elseif ($role == "contractor-update-password" && $data[12]->permission == '1') {
                return $next($request);
            } elseif ($role == "invite-create" && $data[13]->permission == '1') {
                return $next($request);
            } elseif ($role == "invite-store" && $data[13]->permission == '1') {
                return $next($request);
            } elseif ($role == "invite-list" && $data[13]->permission == '1') {
                return $next($request);
            } elseif ($role == "invite-edit" && $data[13]->permission == '1') {
                return $next($request);
            } elseif ($role == "invite-update" && $data[13]->permission == '1') {
                return $next($request);
            } elseif ($role == "invite-find" && $data[13]->permission == '1') {
                return $next($request);
            } elseif ($role == " invite-view" && $data[13]->permission == '1') {
                return $next($request);
            } elseif ($role == "invite-update-status" && $data[13]->permission == '1') {
                return $next($request);
            } elseif ($role == "admin-create") {
                abort('401');
            } elseif ($role == "admin-list") {
                abort('401');
            } elseif ($role == "admin-store") {
                abort('401');
            } elseif ($role == "admin-edit") {
                abort('401');
            } elseif ($role == "admin-update-password") {
                abort('401');
            } elseif ($role == "admin-view") {
                abort('401');
            } elseif ($role == "admin-update") {
                abort('401');
            } elseif ($role == "admin-delete") {
                abort('401');
            } elseif ($role == "admin-find") {
                abort('401');
            } elseif ($role == "admin-status") {
                abort('401');
            } elseif ($role == "role-create") {
                abort('401');
            } elseif ($role == "role-list") {
                abort('401');
            } elseif ($role == "role-store") {
                abort('401');
            } elseif ($role == "role-update") {
                abort('401');
            } else {
                abort('401');
            }
        } else {
            return redirect()->back();
        }
    }
}
