<?php

use App\Models\Employee;
use App\Models\Project;

if (!function_exists('changeDateFormatToUS')) {
    function changeDateFormatToUS($date)
    {
        return date('d-m-Y', strtotime($date));
    }
}
if (!function_exists('getSessionData')) {
    function getSessionData()
    {
        return session()->get('admin_id');
    }
}

if (!function_exists('getProjectsDropdown')) {
    function getProjectsDropdown()
    {
        $id = session()->get('admin_id');
        $userType = session()->get('type');
        $groupedData = [];
        if ($userType == "contractor") {
            $projectTypesWithCounts = getContractorProjectTypesWithCounts($id);
        } elseif ($userType == "employee") {
            $projectTypesWithCounts = getEmployeeProjectTypesWithCounts($id);
        } else {
            $projectTypesWithCounts = getDefaultProjectTypesWithCounts();
        }

        foreach ($projectTypesWithCounts as $projectType) {
            $type = $projectType->type;

            if (!isset($groupedData[$type])) {
                $groupedData[$type] = [
                    'type' => $type,
                    'countYear' => 0,
                    'years' => [],
                ];
            }

            $groupedData[$type]['countYear'] += $projectType->countYear;

            $yearData = [
                'year' => $projectType->year,
                'count' => $projectType->count,
                'names' => [],
            ];

            $groupedData[$type]['years'][] = $yearData;

            $nameData = [
                'name' => $projectType->name,
                'countName' => $projectType->countName,
                'project_id' => $projectType->project_id,
                'status' => $projectType->status,
            ];

            $groupedData[$type]['years'][count($groupedData[$type]['years']) - 1]['names'][] = $nameData;
        }

        // Combine $projectIds and $groupedData
        $projectIds = Project::query()->select('project_id')->get();
        $projectIdsCollection = collect($projectIds);
        return $combinedData = $projectIdsCollection->merge($groupedData);
    }
}

function getContractorProjectTypesWithCounts($contractorId)
{
    return Project::query()->select('type', 'project_date', 'name', 'project_id')
        ->selectRaw('COUNT(*) as count')
        ->selectRaw('YEAR(project_date) as year, COUNT(*) as countYear')
        ->where('status', '!=', 'completed')
        ->where('contractor_id', $contractorId)
        ->groupBy('type', 'project_date', 'name', 'project_id')
        ->get();
}

function getEmployeeProjectTypesWithCounts($employeeId)
{
    $company_id = Employee::query()->where('user_id', $employeeId)->select('company')->get();
    return Project::query()->select('type', 'project_date', 'name', 'project_id')
        ->selectRaw('COUNT(*) as count')
        ->selectRaw('YEAR(project_date) as year, COUNT(*) as countYear')
        ->where('status', '!=', 'completed')
        ->whereIn('company', $company_id)
        ->groupBy('type', 'project_date', 'name', 'project_id')
        ->get();
}

function getDefaultProjectTypesWithCounts()
{
    return Project::query()->select('type', 'project_date', 'name', 'project_id')
        ->selectRaw('COUNT(*) as count')
        ->selectRaw('YEAR(project_date) as year, COUNT(*) as countYear')
        ->where('status', '!=', 'completed')
        ->groupBy('type', 'project_date', 'name', 'project_id')
        ->get();
}
