<?php

namespace App\Http\Controllers;

use App\Models\Christening;
use App\Models\Client;
use App\Models\Company;
use App\Models\Contractors;
use App\Models\ContructorPaymentLog;
use App\Models\Employee;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\Project;
use App\Models\ProjectPayment;
use App\Models\RolePermission;
use App\Models\WeddingEngagement;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    const ACCEPTED = 2;

    public function create()
    {
        if (session()->get('admin_id')) {
            $role = RolePermission::all();
            $companies = Company::where('status', '=', 1)->get();
            $employees = $employees = Employee::join('users', 'users.id', '=', 'employees.user_id')->where(['users.type' => 'employee', 'status' => 1])->orderBy('employees.employee_id', 'DESC')->get();
            $contractors = Contractors::join('users', 'users.id', '=', 'contractors.user_id')->where(['users.type' => 'contractor', 'status' => 1])->orderBy('contractors.contractor_id', 'DESC')->get();
            $clients = Client::join('users', 'users.id', '=', 'clients.user_id')->where(['users.type' => 'client', 'status' => 1])->orderBy('clients.client_id', 'DESC')->get();
            return view('admin.project.create', ['employees' => $employees, 'contractors' => $contractors, 'clients' => $clients, 'role' => $role, 'companies' => $companies]);
        } else {
            return redirect("/");
        }
    }

    public function fetch_available_contractors(Request $request)
    {
        $project_id = $request->project_id;

        // Fetch the project's invitation contractors
        $projectInvitations = Invitation::where('project_id', $project_id)
            ->pluck('contractor_id') // Get the contractor_ids from the invitations
            ->toArray();

        // Fetch available contractors that are not in the projectInvitations
        $contractors = Contractors::join('users', 'users.id', '=', 'contractors.user_id')
            ->where(['users.type' => 'contractor', 'status' => 1])
            ->whereNotIn('contractors.user_id', $projectInvitations) // Exclude invited contractors
            ->orderBy('contractors.contractor_id', 'DESC')
            ->get();

        $availableContractors = [];
        foreach ($contractors as $contractor) {
            $availableContractors[] = [
                'contractor_id' => $contractor->contractor_id,
                'name' => $contractor->name,
                'user_id' => $contractor->user_id,
            ];
        }

        return response()->json([
            'status' => 'true',
            'contractors' => $availableContractors,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'p_name' => 'required',
            'p_cost' => 'required',
            'p_date' => 'required',
            'p_company' => 'required',
            'employees' => 'required',

            //           'payment_type' => 'required',
            'p_type' => 'required',

        ]);
        $result = Project::create([
            'name' => $request->p_name,
            'cost' => $request->p_cost,
            'project_date' => $request->p_date,
            'employees' => implode(",", $request->employees),
            // 'contractors' => implode(",", $request->contractors),
            'type' => $request->p_type,
            'client' => $request->p_client,
            'company' => $request->p_company,
            'project_details' => $request->p_details,
            'status' => 'pending',
            // 'payment_type' => $request->payment_type
        ]);
        $id = $result->id;
        $project_id = $result->id;
        // evenets(insert)
        $action_name = $request->action_name;
        $action_date = $request->action_date;

        if (is_array($action_name) && !empty($action_name)) {
            $events = [];
            foreach ($action_name as $action_key => $act_name) {
                $events[] = [
                    'project_id' => $id,
                    'action' => $act_name,
                    'action_date' => $action_date[$action_key]
                ];
            }

            if (!empty($events)) {

                Event::insert($events);
            }
        }

        if ($request->p_type == "Wedding and Engagement") {
            $result = WeddingEngagement::create([
                'we_project_id' => $id,
                'we_date' => $request->we_date,
                'we_location' => $request->we_location,
                'we_church' => $request->we_church,
                'we_church_time' => $request->we_church_time,
                'we_xetetisi' => $request->we_xetetisi,
                'we_xetetisi_time' => $request->we_xetetisi_time,
                'we_reception' => $request->we_reception,
                'we_reception_time' => $request->we_reception_time,
                'we_groom_name' => $request->we_groom_name,
                'we_groom_phone' => $request->we_groom_phone,
                'we_bride_name' => $request->we_bride_name,
                'we_bride_phone' => $request->we_bride_phone,
                'we_email' => $request->we_email,
                'we_zomato_groom' => $request->we_zomato_groom,
                'we_zomato_groom_time' => $request->we_zomato_groom_time,
                'we_zomato_groom_home' => $request->we_zomato_groom_home,
                'we_zomato_groom_info' => $request->we_zomato_groom_info,
                'we_zomato_bride' => $request->we_zomato_bride,
                'we_zomato_bride_time' => $request->we_zomato_bride_time,
                'we_zomato_bride_home' => $request->we_zomato_bride_home,
                'we_zomato_bride_info' => $request->we_zomato_bride_info,
                'we_details' => $request->we_details,
            ]);
        }
        if ($request->p_type == "Christening") {
            Christening::create([
                'c_project_id' => $id,
                'c_date' => $request->c_date,
                'c_location' => $request->c_location,
                'c_church' => $request->c_church,
                'c_church_time' => $request->c_church_time,
                'c_reception' => $request->c_reception,
                'c_reception_time' => $request->c_reception_time,
                'c_baby_name' => $request->c_baby_name,
                'c_baby_dob' => $request->c_baby_dob,
                'c_mother_name' => $request->c_mother_name,
                'c_mother_phone' => $request->c_mother_phone,
                'c_father_name' => $request->c_father_name,
                'c_father_phone' => $request->c_father_phone,
                'c_email' => $request->c_email,
                'c_zomato_baby' => $request->c_zomato_baby,
                'c_zomato_baby_time' => $request->c_zomato_baby_time,
                'c_details' => $request->c_details,
            ]);
        }
        if ($result) {
            return response()->json(['status' => 'true', 'msg' => 'Project Added Successfully', 'project_id' => $project_id]);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Project Could not Added Successfully']);
        }
    }

    public function list()
    {
        if (session()->get('admin_id')) {
            $role = RolePermission::all();
            $contractors = Contractors::join('users', 'users.id', '=', 'contractors.user_id')->get();
            $id = session()->get('admin_id');
            $projects = [];
            if (session()->get('type') == "contractor") {
                $project_id = Invitation::where("contractor_id", $id)->select('project_id')->where('status', '=', 2)->get();
                $projects = Project::whereIn('project_id', $project_id)->orderBy('project_id', 'desc')->get();
            } elseif (session()->get('type') == "employee") {
                $company_id = Employee::where('user_id', $id)->select('company')->get();
                $projects = Project::whereIn('company', $company_id)->orderBy('project_id', 'desc')->get();
            } else {
                $projects = DB::table('projects')->orderBy('project_id', 'desc')->get();
            }
            foreach ($projects as $project) {
                if (session()->get('type') == "contractor") {
                    $project->invitation_price = Invitation::where(['project_id' => $project->project_id, 'contractor_id' => $id])->value('price');
                    $contractor_remaining_amount = ContructorPaymentLog::where(['project_id' => $project->project_id, 'contractor_id' => $id])->sum('payment');
                    $project->contractor_remaining_amount = $project->invitation_price - ($contractor_remaining_amount ?? 0) > 0 ? $project->invitation_price - ($contractor_remaining_amount ?? 0) : 0;
                }
                $remaining_amount = ProjectPayment::where('project_id', $project->project_id)->sum('price');
                $project->remaining_amount = $project->cost - ($remaining_amount ?? 0) > 0 ? $project->cost - ($remaining_amount ?? 0) : 0;
            }
            return view('admin.project.list', ['projects' => $projects, 'role' => $role, 'contractors' => $contractors]);
        } else {
            return redirect("/");
        }
    }

    public function view($code)
    {
        if (session()->get('admin_id')) {
            $role = RolePermission::all();
            $payments = ProjectPayment::where('project_id', $code)->orderBy('project_payment_id', 'desc')->get();
            $project = Project::join('companies', 'companies.company_id', '=', 'projects.company')->where('projects.project_id', '=', $code)->select('projects.*', 'companies.name as company_name')->first();
            $client = Client::where('client_id', $project->client)->join('users', 'users.id', '=', 'clients.user_id')->where(['users.type' => 'client'])->first();
            $contractorIds = explode(',', $project->contractors);
            $employeesIds = explode(',', $project->employees);
            $invitation = Invitation::join('users', 'users.id', '=', 'invitations.contractor_id')
                ->select('users.name as contractor_name', 'invitations.price', 'invitations.status', 'invitations.invitation_id as invitation_id')->where('invitations.project_id', '=', $code)->get();
            $contractors = Contractors::whereIn('users.id', $contractorIds)
                ->join('users', 'users.id', '=', 'contractors.user_id')
                ->where('users.type', '=', 'contractor')
                ->orderBy('contractors.contractor_id', 'DESC')
                ->get();
            $employees = $employees = Employee::whereIn('users.id', $employeesIds)->join('users', 'users.id', '=', 'employees.user_id')->where('users.type', '=', 'employee')->orderBy('employees.employee_id', 'DESC')->get();
            $events = Event::where('project_id', $code)->orderBy('action_date', 'desc')->get();
            $remaining_amount = ProjectPayment::where('project_id', $code)->sum('price');
            if ($project->type == "Wedding and Engagement") {
                $data = DB::table('projects')
                    ->join('wedding_engagements', 'projects.project_id', '=', 'wedding_engagements.we_project_id')
                    ->where('projects.project_id', '=', $project->project_id)->select('projects.*', 'wedding_engagements.*')->first();
            } else if ($project->type == "Christening") {
                $data = DB::table('projects')
                    ->join('christenings', 'projects.project_id', '=', 'christenings.c_project_id')
                    ->where('projects.project_id', '=', $project->project_id)->select('projects.*', 'christenings.*')->first();
            } else {
                $data = Project::where('project_id', '=', $code)->first();
            }
            $logs = [];
            if (session()->get('type') == "contractor") {
                $id = session()->get('admin_id');
                $logs = ContructorPaymentLog::where(['project_id' => $data->project_id, 'contractor_id' => $id])->orderBy('id', 'desc')
                    ->get();
            }
            $arr = [
                'project' => $project,
                'employees' => $employees,
                'contractors' => $contractors,
                'role' => $role,
                'events' => $events,
                'data' => $data,
                'client' => $client,
                'invitation' => $invitation,
                'payments' => $payments,
                'remaining_amount' => $remaining_amount,
                'contractor_payment_logs' => $logs
            ];
            return view('admin.project.view', $arr);
        } else {
            return redirect("/");
        }
    }

    public function add_event(Request $request)
    {
        $result = Event::create([
            'project_id' => $request->project_id,
            'action' => $request->act_name,
            'action_date' => $request->act_date,
            'status' => $request->status
        ]);
        if ($result) {
            return response()->json(['status' => 'true', 'msg' => 'Event Added Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Event Could not Added Successfully']);
        }
    }
    public function edit_event(Request $request)
    {
        $event = Event::find($request->event_id);
        $result = Event::where('id', $request->event_id)->update([
            'project_id' => $request->project_id,
            'action' => $request->act_name,
            'action_date' => $request->act_date,
            'old_date' => ($request->old_date && !empty($request->old_date) ? $request->old_date : Null),
            'status' => ($request->status && !empty($request->status) ? $request->status : $event->status)
        ]);
        if ($result) {
            return response()->json(['status' => 'true', 'msg' => 'Event Updated Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Event Could not Updated Successfully']);
        }
    }

    public function to_do_list()
    {
        $id = session()->get('admin_id');
        $role = RolePermission::all();

        if (session()->get('type') == "contractor") {
            $project_ids = Invitation::where("contractor_id", $id)
                ->where('status', '=', 2)
                ->pluck('project_id')
                ->toArray();

            $events = Event::with('project')
                ->whereIn('project_id', $project_ids)
                ->orderBy('action_date')
                ->get();
        } elseif (session()->get('type') == "employee") {
            $company_ids = Employee::where('user_id', $id)->pluck('company')
                ->toArray();
            $project_ids = Project::where('company', $company_ids)->pluck('project_id')
                ->toArray();
            $events = Event::with('project')
                ->whereIn('project_id', $project_ids)
                ->orderBy('action_date')
                ->get();
        } else {

            $events = Event::with('project')->orderBy('action_date')->get();
        }

        return view('admin.project.to_do_list', compact('events', 'role'));
    }

    public function delete_event(Request $request)
    {
        $result = Event::where('id', $request->id)->first();
        if ($result) {
            Event::where('id', $request->id)->delete();
            return response()->json(['status' => 'true', 'msg' => 'Event Deleted Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Event Could not Deleted Successfully']);
        }
    }

    public function delete_invitation(Request $request)
    {
        $result = Invitation::where('invitation_id', $request->id)->first();
        if ($result) {
            Invitation::where('invitation_id', $request->id)->delete();
            return response()->json(['status' => 'true', 'msg' => 'Invitation Deleted Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Invitation Could not Deleted Successfully']);
        }
    }

    public function delete_payment(Request $request)
    {
        $result = ProjectPayment::where('project_payment_id', $request->id)->first();
        if ($result) {
            ProjectPayment::where('project_payment_id', $request->id)->delete();
            return response()->json(['status' => 'true', 'msg' => 'Payment Deleted Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Payment Could not Deleted Successfully']);
        }
    }

    public function add_payment(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'price' => 'required',
            'payment_type' => 'required',
        ]);

        $project = Project::where('project_id', $request->project_id)->first();
        $price = $project->cost;
        $remainingPrice = $price - $request->price;

        // Check if a ProjectPayment record already exists for the project
        $existingPayment = ProjectPayment::where('project_id', $request->project_id)->first();

        if ($existingPayment) {
            // ProjectPayment already exists, use remaining_price for calculation
            $remainingPrice = $existingPayment->remaining_price - $request->price;

            if ($remainingPrice < 0) {
                // Payment amount exceeds the remaining payment
                return response()->json(['status' => false, 'msg' => 'Payment exceeds! Remaining Payment is $' . $existingPayment->remaining_price]);
            }

            ProjectPayment::create([
                'project_id' => $request->project_id,
                'price' => number_format($request->price),
                'remaining_price' => $remainingPrice,
                'payment_type' => $request->payment_type,
                'message' => $request->message,
                'date' => $request->date
            ]);
        } else {
            // ProjectPayment does not exist, create a new entry
            if ($remainingPrice < 0) {
                // Payment amount exceeds the total project cost
                return response()->json(['status' => false, 'msg' => 'Payment exceeds! Remaining Payment is $' . $price]);
            }
            ProjectPayment::create([
                'project_id' => $request->project_id,
                'price' => number_format($request->price),
                'remaining_price' => $remainingPrice,
                'payment_type' => $request->payment_type,
                'message' => $request->message,
                'date' => $request->date
            ]);
        }

        // Optionally, you can add further validation or actions here.

        // Return a response indicating the success of the operation.
        return response()->json(['status' => true, 'msg' => 'Payment Added Successfully']);
    }

    public function edit($code)
    {
        if (!session()->get('admin_id')) {
            return redirect("/");
        }
        $role = RolePermission::all();
        $companies = Company::where('status', '=', 1)->get();
        $data = Project::where('project_id', '=', $code)->first();
        $employees = $employees = Employee::join('users', 'users.id', '=', 'employees.user_id')->where('users.type', '=', 'employee')->orderBy('employees.employee_id', 'DESC')->get();
        $contractors = Contractors::join('users', 'users.id', '=', 'contractors.user_id')->where('users.type', '=', 'contractor')->orderBy('contractors.contractor_id', 'DESC')->get();
        $clients = Client::join('users', 'users.id', '=', 'clients.user_id')->where('users.type', '=', 'client')->orderBy('clients.client_id', 'DESC')->get();
        if ($data->type == "Wedding and Engagement") {
            $project = Project::join('wedding_engagements', 'projects.project_id', '=', 'wedding_engagements.we_project_id')
                ->where('projects.project_id', '=', $data->project_id)->select('projects.*', 'wedding_engagements.*')->first();
        } else if ($data->type == "Christening") {
            $project = DB::table('projects')
                ->join('christenings', 'projects.project_id', '=', 'christenings.c_project_id')
                ->where('projects.project_id', '=', $data->project_id)->select('projects.*', 'christenings.*')->first();
        } else {
            $project = Project::where('project_id', '=', $code)->first();
        }

        $events = Event::where('project_id', $code)->get();
        $arr = [

            'project' => $project,
            'employees' => $employees,
            'contractors' => $contractors,
            'clients' => $clients,
            'role' => $role,
            'events' => $events,
            'data' => $data,
            'companies' => $companies
        ];

        return view('admin.project.edit', $arr);
    }

    public function update(Request $request)
    {
        $request->validate([
            'p_name' => 'required',
            'p_cost' => 'required',
            'p_date' => 'required',
            // 'employees' => 'required',
            // 'payment_type' => 'required',
            'p_type' => 'required',
            'p_company' => 'required',
            // 'p_details' => 'required',
        ]);
        $result = Project::where('project_id', $request->code)->update([
            'name' => $request->p_name,
            'cost' => $request->p_cost,
            'project_date' => $request->p_date,
            // 'employees' => implode(",", $request->employees),
            // 'contractors' => implode(",", $request->contractors),
            'company' => $request->p_company,
            'type' => $request->p_type,
            'client' => $request->p_client,
            'project_details' => $request->p_details,
            // 'payment_type' => $request->payment_type,
        ]);

        // delete events
        Event::where('project_id', $request->code)->delete();

        // events(insert)
        $action_name = $request->action_name;
        $action_date = $request->action_date;

        if (is_array($action_name) && !empty($action_name)) {
            $events = [];
            foreach ($action_name as $action_key => $act_name) {

                $events[] = [
                    'project_id' => $request->code,
                    'action' => $act_name,
                    'action_date' => $action_date[$action_key]
                ];
            }

            if (!empty($events)) {

                Event::insert($events);
            }
        }

        if (!($request->p_type == "Wedding and Engagement" || $request->p_type == "Christening")) {
            WeddingEngagement::where('we_project_id', '=', $request->code)->delete();
            Christening::where('c_project_id', '=', $request->code)->delete();
        }

        if ($request->p_type == "Wedding and Engagement") {
            $count = WeddingEngagement::where('we_project_id', '=', $request->code)->count();
            $data = [
                'we_date' => $request->we_date,
                'we_location' => $request->we_location,
                'we_church' => $request->we_church,
                'we_church_time' => $request->we_church_time,
                'we_xetetisi' => $request->we_xetetisi,
                'we_xetetisi_time' => $request->we_xetetisi_time,
                'we_reception' => $request->we_reception,
                'we_reception_time' => $request->we_reception_time,
                'we_groom_name' => $request->we_groom_name,
                'we_groom_phone' => $request->we_groom_phone,
                'we_bride_name' => $request->we_bride_name,
                'we_bride_phone' => $request->we_bride_phone,
                'we_email' => $request->we_email,
                'we_zomato_groom' => $request->we_zomato_groom,
                'we_zomato_groom_time' => $request->we_zomato_groom_time,
                'we_zomato_groom_home' => $request->we_zomato_groom_home,
                'we_zomato_groom_info' => $request->we_zomato_groom_info,
                'we_zomato_bride' => $request->we_zomato_bride,
                'we_zomato_bride_time' => $request->we_zomato_bride_time,
                'we_zomato_bride_home' => $request->we_zomato_bride_home,
                'we_zomato_bride_info' => $request->we_zomato_bride_info,
                'we_details' => $request->we_details,
            ];
            if ($count) {
                $result = WeddingEngagement::where('we_project_id', $request->code)->update($data);
            } else {
                Christening::where('c_project_id', '=', $request->code)->delete();
                $result = WeddingEngagement::create($data);
            }
        }
        if ($request->p_type == "Christening") {
            $count = Christening::where('c_project_id', '=', $request->code)->get();
            if (count($count)) {
                Christening::where('c_project_id', $request->code)->update([
                    'c_date' => $request->c_date,
                    'c_location' => $request->c_location,
                    'c_church' => $request->c_church,
                    'c_church_time' => $request->c_church_time,
                    'c_reception' => $request->c_reception,
                    'c_reception_time' => $request->c_reception_time,
                    'c_baby_name' => $request->c_baby_name,
                    'c_baby_dob' => $request->c_baby_dob,
                    'c_mother_name' => $request->c_mother_name,
                    'c_mother_phone' => $request->c_mother_phone,
                    'c_father_name' => $request->c_father_name,
                    'c_father_phone' => $request->c_father_phone,
                    'c_email' => $request->c_email,
                    'c_zomato_baby' => $request->c_zomato_baby,
                    'c_zomato_baby_time' => $request->c_zomato_baby_time,
                    'c_details' => $request->c_details,
                ]);
            } else {
                WeddingEngagement::where('we_project_id', '=', $request->code)->delete();
                Christening::create([
                    'c_project_id' => $request->code,
                    'c_date' => $request->c_date,
                    'c_location' => $request->c_location,
                    'c_church' => $request->c_church,
                    'c_church_time' => $request->c_church_time,
                    'c_reception' => $request->c_reception,
                    'c_reception_time' => $request->c_reception_time,
                    'c_baby_name' => $request->c_baby_name,
                    'c_baby_dob' => $request->c_baby_dob,
                    'c_mother_name' => $request->c_mother_name,
                    'c_mother_phone' => $request->c_mother_phone,
                    'c_father_name' => $request->c_father_name,
                    'c_father_phone' => $request->c_father_phone,
                    'c_email' => $request->c_email,
                    'c_zomato_baby' => $request->c_zomato_baby,
                    'c_zomato_baby_time' => $request->c_zomato_baby_time,
                    'c_details' => $request->c_details,
                ]);
            }
        }
        if ($result) {
            return response()->json(['status' => 'true', 'msg' => 'Project Updated Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Project Could not Updated Successfully']);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $project = Project::where('project_id', $id)->first();
        if ($project->type == "Wedding and Engagement") {
            Project::where('project_id', $id)->delete();
            WeddingEngagement::where('we_project_id', '=', $project->project_id)->delete();
        } elseif ($project->type == "Christening") {
            Project::where('project_id', $id)->delete();
            Christening::where('c_project_id', '=', $project->project_id)->delete();
        } else {
            Project::where('project_id', $id)->delete();
        }

        // delete event
        Event::where('project_id', $id)->delete();

        return response()->json(['status' => 'true', 'msg' => 'Project Deleted Successfully']);
    }

    public function find(Request $request)
    {
        $id = $request->id;
        return Project::where('project_id', $id)->first();
    }

    public function update_status(Request $request)
    {
        $result = Project::where('project_id', $request->code)->update([
            'status' => $request->status
        ]);

        if ($result) {
            return response()->json(['status' => 'true', 'msg' => 'Status Updated Successfully']);
        } else {
            return response()->json(['status' => 'false', 'msg' => 'Status could not Updated Successfully']);
        }
    }

    public function eventDetails($id)
    {
        $role = RolePermission::all();
        $project = Project::where('project_id', $id)->first();
        $events = Event::query()->where('project_id', '=', $project->project_id)->orderBy('action_date')->get();
        return view('admin.project.event', compact('events', 'project', 'role'));
    }


    public function updateEventDates(Request $request)
    {
        try {

            $draggedRowDate = $request->input('dragged_row_date');
            $droppedRowDate = $request->input('dropped_row_date');

            // Retrieve the event based on the dragged row ID
            $event = Event::query()->find($request->dragged_row_id);

            if ($event) {
                $event->old_date = $event->action_date;
                $event->action_date = $request->dropped_row_date;
                $event->save();
                return response()->json(['message' => 'Event date updated successfully']);
            } else {
                return response()->json(['message' => 'Event not found'], 404);
            }
        } catch (QueryException $e) {
            // Handle database query exceptions
            return response()->json(['message' => 'Database error occurred'], 500);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }

    public function updateEventStatus(Request $request)
    {
        $event_id = $request->input('event_id');
        $status = $request->input('status');

        // Update the status of the event with the given event_id
        $event = Event::find($event_id);

        if ($event) {
            $event->status = $status;
            $event->save();

            return response()->json(['message' => 'Status updated successfully']);
        } else {
            return response()->json(['message' => 'Event not found'], 404);
        }
    }

    public function eventFind(Request $request)
    {
        $id = $request->id;
        $event = Event::find($id);
        return response()->json($event);
    }
}
