<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\createProjectRequest;
use App\Models\OfficeExpense;
use App\Models\Project;
use App\Models\ProjectTeamMember;
use Exception;
use Illuminate\Http\Request;


class ProjectController extends Controller
{

    public function getAllProjects()
    {
        try {
            $projects = Project::with(['teamMembers.staffUser'])->get();

            return ResponseHelper::success('Project fetched successfully', $projects);
        } catch (Exception $ex) {
            return ResponseHelper::error('Request failed. Please try again', $ex->getMessage());
        }
    }


    public function store(createProjectRequest $request)
    {
        $validated = $request->validated();

        try {
            $project = Project::create($validated);

            foreach ($validated['selected_team_members'] as $memberId) {
                ProjectTeamMember::create([
                    'project_id' => $project->id,
                    'member_user_id' => $memberId,
                ]);
            }

            return ResponseHelper::success('Project created successfully',$project);
        } catch (Exception $ex) {
            return ResponseHelper::error('Request failed. Please try again', $ex->getMessage());
        }
    }


    public function getProjectCost($id, Request $request)
    {
        $yearMonth = $request->input('year_month', date('Y-m'));
        $check_project = Project::where('id', $id)->exists();
        if ($check_project) {
            $costData = $this->projectCostCalculation($id, $yearMonth);
        } else {
            return ResponseHelper::error('Sorry, Project not found');
        }


        return ResponseHelper::success('Project cost details successfully', $costData);
    }


    public function projectCostCalculation($projectId, $month_year)
    {

        try {
            $project = Project::find($projectId);
            $project_hours = $project->assumed_hours;
            $projectStaffCost = 0;

            $staff_list = ProjectTeamMember::with('staffUser')->where('project_id', $projectId)->get();
            foreach ($staff_list as $staff) {
                $staffhourlyCost = $staff->staffUser->monthly_salary / 180;
                $projectStaffCost += $staffhourlyCost * $project_hours;
            }
            $monthlyOfficeCost = OfficeExpense::where('ex_year_month', $month_year)->sum('monthly_cost');
            $officeExpHoulry = $monthlyOfficeCost / 180;

            $totalCost = $projectStaffCost + ($officeExpHoulry * $project_hours);
            $costPerHours = $totalCost / $project_hours;

            return [
                "project" => $project->name,
                'hours' => $project_hours,
                'staff_cost' => round($projectStaffCost, 2),
                'office_cost' => round($officeExpHoulry, 2),
                'total_cost' => round($totalCost, 2),
                'cost_per_hour' => round($costPerHours, 2)
            ];
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }
}
