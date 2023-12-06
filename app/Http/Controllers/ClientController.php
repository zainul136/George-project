<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function create()
    {
        if (session()->get('admin_id')) {
            $projects = Project::where('status', 1)->get();
            $role = RolePermission::all();
            return view('admin.clients.create', ['projects' => $projects, 'role' => $role]);
        } else {
            return redirect("/");
        }
    }

    public function list()
    {
        if (session()->get('admin_id')) {
            $role = RolePermission::all();
            $clients = Client::join('users', 'users.id', '=', 'clients.user_id')->where('users.type', '=', 'client')->orderBy('clients.client_id', 'DESC')->get();
            return view('admin.clients.list', ['clients' => $clients, 'role' => $role]);
        } else {
            return redirect("/");
        }
    }

    public function find(Request $request)
    {
        $id = $request->id;
        $result = Client::where('client_id', $id)->first();
        if ($result) {
            return $result;
        } else {
            return response()->json(['status' => 'False', 'msg' => 'Something is wrong']);
        }
    }

    public function store(Request $request)
    {
        $client = User::where('email', '=', $request->email)->get();
        if (count($client) > 0) {
            return response()->json(['status' => 'false', 'msg' => 'Client Email already Exists']);
        } else {
            $filename = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extention = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extention;
                $file->move('public/project_images/client/', $filename);

                // $image = $request->file('image');
                // $filename = $input['imagename'] = time() . '.' . $image->extension();
                // $thumbnailDirectory = public_path('public/project_images/client/');
                // if (!file_exists($thumbnailDirectory)) {
                //     mkdir($thumbnailDirectory, 0755, true);
                // }
                // $img = Image::make($image->path());
                // $img->resize(100, 100, function ($constraint) {
                //     $constraint->aspectRatio();
                // })->save($thumbnailDirectory . '/' . $input['imagename']);
            }
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'type' => 'client'
            ]);
            $UserId = DB::getPdo()->lastInsertId();
            $result = Client::create([
                'user_id' => $UserId,
                'contact' => $request->contact,
                'project' => $request->project,
                'dob' => $request->dob,
                'address' => $request->address,
                'image' => $filename,
                'status' => 1,
            ]);
            if ($result) {
                return response()->json(['status' => 'true', 'msg' => 'Client Added Successfully']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'Client Could not Added Successfully']);
            }
        }
    }

    public function view($code)
    {
        if (session()->get('admin_id')) {
            $projects = Project::all();
            $role = RolePermission::all();
            $client = Client::join('users', 'users.id', '=', 'clients.user_id')
                ->where('users.type', '=', 'client')->where('client_id', '=', $code)->first();
            return view('admin.clients.view', ['client' => $client, 'projects' => $projects, 'role' => $role]);
        } else {
            return redirect("/");
        }
    }

    public function edit($code)
    {
        if (session()->get('admin_id')) {
            $projects = Project::all();
            $role = RolePermission::all();
            $client = Client::join('users', 'users.id', '=', 'clients.user_id')
                ->where('users.type', '=', 'client')->where('client_id', '=', $code)->first();
            return view('admin.clients.edit', ['client' => $client, 'projects' => $projects, 'role' => $role]);
        } else {
            return redirect("/");
        }
    }
    public function update_status(Request $request)
    {
        $result = Client::where('client_id', $request->code)->update([
            'status' => $request->status
        ]);

        if ($result) {
            return response()->json(['status' => 'true', 'msg' => 'Status Updated Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Status could not Updated Successfully']);
        }
    }

    public function update(Request $request)
    {
        if ($request->hasFile('image')) {
            $data = Client::where('client_id', $request->code)->first();
            if (!is_null($data->image)) {
                $desitination = 'public/project_images/client/' . $data->image;
                if (File::exists($desitination)) {
                    File::delete($desitination);
                }
            }
            // $image = $request->file('image');
            // $filename = $input['imagename'] = time() . '.' . $image->extension();
            // $thumbnailDirectory = public_path('public/project_images/client/');
            // if (!file_exists($thumbnailDirectory)) {
            //     mkdir($thumbnailDirectory, 0755, true);
            // }
            // $img = Image::make($image->path());
            // $img->resize(100, 100, function ($constraint) {
            //     $constraint->aspectRatio();
            // })->save($thumbnailDirectory . '/' . $input['imagename']);
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('public/project_images/client/', $filename);


            $getClient = Client::where('client_id', $request->code)->first();
            User::where('id', $getClient->user_id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $result = Client::where('client_id', $request->code)->update([
                'contact' => $request->contact,
                'project' => $request->project,
                'dob' => $request->dob,
                'address' => $request->address,
                'image' => $filename,
                // 'status' => $request->status,
            ]);
        } else {
            $getClient = Client::where('client_id', $request->code)->first();
            User::where('id', $getClient->user_id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $result = Client::where('client_id', $request->code)->update([
                'contact' => $request->contact,
                'project' => $request->project,
                'dob' => $request->dob,
                'address' => $request->address,
                // 'status' => $request->status,
            ]);
        }

        if ($result) {
            return response()->json(['status' => 'true', 'msg' => 'Client Updated Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Client Could not Updated Successfully']);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $result = Client::where('client_id', '=', $id)->first();
        if ($result) {
            $data = $result->user_id;
            if (!is_null($result->image)) {
                $desitination = 'public/project_images/client/' . $result->image;
                if (File::exists($desitination)) {
                    File::delete($desitination);
                }
            }
            User::where('id', '=', $data)->delete();
            Client::where('client_id', '=', $id)->delete();
            return response()->json(['status' => 'true', 'msg' => 'Client Deleted Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Client could not Deleted']);
        }
    }
}
