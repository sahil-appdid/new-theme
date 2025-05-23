<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {
        return view('content.tables.projects');
    }

    public function store(Request $request)
    {

        $data             = new Project();
        $data->title      = $request->title;
        $data->start_date = $request->start_date;
        $data->end_date   = $request->end_date;
        $data->save();
        return back();
    }

    public function edit($id)
    {

        $data = Project::findOrFail($id);
        return response($data);

    }

    public function update(Request $request)
    {

        $data             = Project::findOrFail($request->id);
        $data->title      = $request->title;
        $data->start_date = $request->start_date;
        $data->end_date   = $request->end_date;
        $data->save();
        return back();

        return response([
            'header'  => 'Updated!',
            'message' => 'project updated successfully',
            'table'   => 'projects-table',
        ]);

    }

    public function destroy($id)
    {

        Project::findOrFail($id)->delete();
        return response([
            'header'  => 'Deleted!',
            'message' => 'project deleted successfully',
            'table'   => 'projects-table',
        ]);
    }

}
