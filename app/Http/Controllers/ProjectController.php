<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\SaveProjectRequest;
use App\Models\Plan;
use App\Models\Project;

class ProjectController extends Controller
{
     public function index()
     {
         $paginated = Project::withTrashed()->withCount('plans')->paginate(15);

         return view('admin.projects.index', compact('paginated'));
     }

     public function save(SaveProjectRequest $request)
     {
         $project = Project::getOrNew($request->project_id);

         $project->fill($request->validated());
         $project->save();

         return redirect()->back()->with('success', "Successfully saved");
     }

     public function delete($projectId)
     {
         $project = Project::withTrashed()->findOrFail($projectId);

         if (!$project->deleted_at) {
             Plan::withTrashed()->where('project_id', $project->id)->delete();
             $project->delete();
             $msg = "Proekt va uning barcha tariflari muvafaqqiyatli o'chirildi";
         } else {
             Plan::withTrashed()->where('project_id', $project->id)->restore();
             $project->restore();
             $msg = "Proekt va uning barcha tariflari qayta tiklandi";
         }

         return redirect()->back()->with('success', $msg);
     }
}
