<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\SavePlanRequest;
use App\Models\Plan;
use App\Models\Project;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function show(Project $project)
    {
        $paginated = Plan::withTrashed()->where('project_id', $project->id)->paginate(25);

        return view('admin.plans.index', compact('paginated', 'project'));
    }

    public function save(SavePlanRequest $request)
    {
        $plan = Plan::getOrNew($request->plan_id);

        $plan->fill($request->validated());
        $plan->save();

        return redirect()->route('projects.plans', $plan->project_id)
            ->with('success', "Muvaffaqiytali saqlandi");
    }

    public function delete($planId)
    {
        $plan = Plan::withTrashed()->findOrFail($planId);

        if (!$plan->deleted_at) {
            $plan->delete();
            $msg = "Tarif muvafaqqiyatli o'chirildi";
        } else {
            $plan->restore();
            $msg = "Tarif qayta tiklandi";
        }

        return redirect()->back()->with('success', $msg);
    }

    protected function getValidatedData(Request $request): array
    {
        return $request->input();
    }
}
