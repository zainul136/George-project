<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'password', 'type', 'status', 'code'];
    public function adminUpdatePassword($id, $new_password, $confirm_password)
    {
        $user = User::find($id);
        if ($new_password != $confirm_password) {
            // The new password and confirm password do not match
            return ['success' => false, 'message' =>  "The new password and confirm password do not match."];
        }
        $user->password = Hash::make($new_password);
        $user->save();
        return ['success' => true, 'message' => "Password updated successfully."];
    }
}
