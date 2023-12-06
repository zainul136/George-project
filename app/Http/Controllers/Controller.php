<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function view_invitation_email($invitation_id, $email, $password)
    {
        $decryt_email = decrypt($email);
        $data = User::where('email', '=', $decryt_email)->first();

        if (!$data) {
            return redirect()->route('admin:login')->with('error', 'Invitation Not Found!');;
        }

        $invitation = Invitation::where('invitation_id', $invitation_id)->first();

        if (!$invitation) {
            return redirect()->route('admin:login')->with('error', 'Invitation Not Found!');
        }

        // Check if the invitation link has expired (5 minutes = 300 seconds)
        $expirationTime = 300; // 5 minutes in seconds
        $now = now();
        $createdAt = $invitation->created_at;

        if ($now->diffInSeconds($createdAt) > $expirationTime) {
            // The link has expired, redirect with an error message
            return redirect()->route('admin:login')->with('error', 'Invitation link has expired.');
        }

        if ($password == $data->password) {
            Session::put('admin_id', $data->id);
            Session::put('name', $data->name);
            Session::put('email', $data->email);
            Session::put('type', $data->type);
            return redirect()->route('invite:list');
        } else {
            return redirect()->route('admin:login')->with('error', 'Something Went Wrong');
        }
    }
}
