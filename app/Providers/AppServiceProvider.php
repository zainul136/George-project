<?php

namespace App\Providers;

use App\Models\Employee;
use App\Models\Invitation;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $id = session()->get('admin_id');
        $userType = session()->get('type');
        $groupedData = [];
        if ($userType == "contractor") {
            $projectTypesWithCounts = $this->getContractorProjectTypesWithCounts($id);
        } elseif ($userType == "employee") {
            $projectTypesWithCounts = $this->getEmployeeProjectTypesWithCounts($id);
        } else {
            $projectTypesWithCounts = $this->getDefaultProjectTypesWithCounts();
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
        // $combinedData = $projectIdsCollection->merge($groupedData);
        // view()->share('combinedData', $combinedData);

        // return view('admin.layouts.sidebar', compact('combinedData'));
    }

    private function getContractorProjectTypesWithCounts($contractorId): Collection|array
    {
        return Project::query()->select('type', 'project_date', 'name', 'project_id')
            ->selectRaw('COUNT(*) as count')
            ->selectRaw('YEAR(project_date) as year, COUNT(*) as countYear')
            ->where('status', '!=', 'completed')
            ->where('contractor_id', $contractorId)
            ->groupBy('type', 'project_date', 'name', 'project_id')
            ->get();
    }

    private function getEmployeeProjectTypesWithCounts($employeeId): Collection|array
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

    private function getDefaultProjectTypesWithCounts(): Collection|array
    {
        return Project::query()->select('type', 'project_date', 'name', 'project_id')
            ->selectRaw('COUNT(*) as count')
            ->selectRaw('YEAR(project_date) as year, COUNT(*) as countYear')
            ->where('status', '!=', 'completed')
            ->groupBy('type', 'project_date', 'name', 'project_id')
            ->get();
    }
}
