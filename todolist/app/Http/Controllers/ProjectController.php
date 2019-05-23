<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Requests as FormRequest;
use App;
use Auth;

class ProjectController extends Controller
{
    public function create() {
        return view('project.create');
    }

    public function store(FormRequest\CreateProject $request) {
        $request->validated();

        $project = new App\Project;
        $project->title = $request->input('title');
        $project->description = $request->input('desc');
        $project->owner = Auth::id();
        $project->type = $request->input('type');
        $project->save();

        $user_project = new App\user_project;
        $user_project->fk_user = Auth::id();
        $user_project->fk_project = Self::getProjectId()->id_project;
        $user_project->save();

       return redirect()->route('profile');
    }

    public function show($id) {
       if (!App\Project::find($id)) return redirect()->route('profile');;

       return view('project.show', [
           'project' => $id, 
           'columns' => Self::getColumns($id),
           'projectData' => Self::getProjectData($id)
       ]);
    }

    public function column(Request $request) {
        $column = new App\Column;
        $column->name = $request->input('name');
        $column->fk_project = $request->input('project');
        $column->save();

        return back();
    }

    private function getProjectData($id) {
        return App\Project::select('title', 'description')
            ->where('id_project', $id)
            ->first();
    }

    private function getColumns($id) {
        return App\Column::select('name', 'id_column')
            ->where('fk_project', $id)
            ->get();
    }

    private function getProjectId() {
        return App\Project::select('id_project')
            ->where('owner', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
