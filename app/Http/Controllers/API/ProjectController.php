<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\CommonResource;
use App\Mail\MailSender;
use App\Models\Activity;
use App\Models\Entity;
use App\Models\Project;
use App\Models\ProjectPartner;
use Illuminate\Support\Facades\Mail;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return CommonResource::collection($projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $file = "storage/".$request->file("file")->store('projectFiles', "public");

        $project = Project::create(array_merge($request->all(), ["file" => $file, "slug" => slug($request->input("name"))]));

        $entity = Entity::where('id', $request->input('entity_id'))->with(["user"])->first();
        
        $details = [
            "subject" => "Nouveau projet",
            "type" => "entity_personnal",
            "title" => "Nouveau projet",
            "user" => $entity->user,
            "entity" => $entity
        ];

        Mail::to($entity->user->email)->queue(new MailSender($details));

        return new CommonResource(Project::where('id', $project->id)->with(['activities'])->first());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $project = Project::where('id', $project->id)->with(["entity", "organe"])->first();
        $project['activities'] = $project->activity_is_add == 1 ? Activity::where('project_id', $project->id)->get() : [];
        return new CommonResource($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $data = [];

        if($request->file("file") != null) {
            $file = "storage/".$request->file("file")->store('projectFiles', "public");
            $data = array_merge($request->all(), ["file" => $file, "slug" => slug($request->input("name"))]);
        } else {
            $data = array_merge($request->all(), ["slug" => slug($request->input("name"))]);
        }

        $project->update($data);
        return new CommonResource(Project::where('id', $project->id)->first());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return response(null, 204);
    }






    /*************** SECTOR  ************/

    public function sector_index() {
        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->first();

        $projects = Project::where("entity_id", $entity_->id)->get();

        return CommonResource::collection($projects);
    }

    public function sector_show($id) {
        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->first();

        $project = Project::where('id', $id)->where('entity_id', $entity_->id)->with(["entity", "activities"])->first();

        return new CommonResource($project);
    }

    public function sector_publish($id) {
        $amount_sum = Activity::where('project_id', $id)->sum("amount");
        $weight_sum = Activity::where('project_id', $id)->sum("weight");

        $project = Project::where('id', $id)->first();

        $message = [];

        if($project->cost != $amount_sum) {
            array_push($message, "Le total des montants des activités est ".$amount_sum.", ça devrait être égale à ".$project->cost);
        }

        if($weight_sum != 100) {
            array_push($message, "Le cumul de poids des activités doit être égale à 100, actuellement ".$weight_sum);
        }

        if(count($message) == 0) {
            Project::where('id', $id)->update(["activity_is_add" => true]);
            return new CommonResource(Project::where('id', $id)->first());
        } else {
            return response()->json([
                "status" => false,
                "message" => $message
            ]);
        }
    }














    /*************** PATNER  ************/

    public function patner_index() {
        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->first();

        $projects = Project::whereIn("id", ProjectPartner::where("entity_id", $entity_->id)->select('project_id'))->get();

        return CommonResource::collection($projects);
    }

    public function patner_show($id) {
        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->first();

        $project = Project::where('id', $id)->whereIn("id", ProjectPartner::where("entity_id", $entity_->id)->select('project_id'))->with(["entity"])->first();

        $project['activities'] = $project->activity_is_add == 1 ? Activity::where('project_id', $project->id)->get() : [];

        return new CommonResource($project);
    }

}
