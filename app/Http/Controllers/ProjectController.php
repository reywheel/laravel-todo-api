<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\ShowProjectRequest;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::where('user_id', \Auth::user()->id)->get();
        return response($projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        $user_id = User::findOrFail($validated['user_id'])->id;

        $project = new Project();
        $project->fill($request->all());
        $project->user_id = $user_id;
        $project->save();

        return response($project);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(ShowProjectRequest $request, Project $project)
    {
        return response(Project::findOrFail($request->project->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validated();

        $project->fill($validated);
        $project->save();

        return response($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Project $project)
    {
        $status = $project->delete();

        return response()->json([
            'status' => $status,
            'message' => 'Project was deleted'
        ]);
    }
}
