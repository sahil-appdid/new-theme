<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assign;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Http\Request;

class AssignController extends Controller
{
    public function index()
    {
        $employeeData = Employee::get();
        $projectsData = Project::get();
        $assignedData = Assign::with(['employee', 'project'])
            ->whereNotNull('employee_id')
            ->whereNotNull('project_id')
            ->get();
        return view('content.tables.assigns', compact('employeeData', 'projectsData', 'assignedData'));
    }

    public function store(Request $request)
    {

        $employeeIds = $request->employees;
        $projectId   = $request->projects;

        foreach ($employeeIds as $employeeId) {

            $exists = Assign::where('employee_id', $employeeId)
                ->where('project_id', $projectId)
                ->exists();

            if ($exists) {

                return back();
                    // ->withErrors(['duplicate-new-assign' => 'cannot assign same project to same employee.']);

            } else {
             
                $data = new Assign();
                $data->employee_id = $employeeId;
                $data->project_id = $projectId;
                $data->save();
                return back();

            }
        }
    }

    public function edit($id)
    {

        $data = Assign::findOrFail($id);
        return response($data);

    }

    public function update(Request $request)
    {

        $data             = Assign::findOrFail($request->id);
        $data->title      = $request->title;
        $data->start_date = $request->start_date;
        $data->end_date   = $request->end_date;
        $data->save();
        return back();

        return response([
            'header'  => 'Updated!',
            'message' => 'Assign updated successfully',
            'table'   => 'Assigns-table',
        ]);

    }

    public function destroy($id)
    {

        Assign::findOrFail($id)->delete();
        return response([
            'header'  => 'Deleted!',
            'message' => 'Assign deleted successfully',
            'table'   => 'Assigns-table',
        ]);
    }
}
