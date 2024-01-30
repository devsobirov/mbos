<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $paginated = Log::query()
            ->byType($request->type)->byGroup($request->group)->byUser($request->user_id)
            ->fromDate($request->fromDate)->toDate($request->toDate)
            ->orderBy('id', 'desc')
            ->paginate(25);

        return view('admin.logs.index', compact('paginated'));
    }
}
