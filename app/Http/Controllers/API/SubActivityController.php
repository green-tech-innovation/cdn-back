<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportRequest;
use App\Http\Requests\SubActivityRequest;
use App\Http\Resources\CommonResource;
use App\Models\Activity;
use App\Models\Entity;
use App\Models\Project;
use App\Models\SubActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubActivityRequest $request)
    {
        $activity_id = intval($request->input("activity_id"));

        $activity = Activity::where('id', $activity_id)->first();

        $remain = $activity->amount - SubActivity::where('activity_id', $activity_id)->sum("amount");

        if($remain >= $request->input("amount")) {

            if($request->file("file") != null) {
                $file = "storage/".$request->file("file")->store('subActivityFiles', "public");
                $data = array_merge($request->all(), ["file" => $file, "slug" => slug($request->input("name"))]);
            } else {
                $data = array_merge($request->all(), ["slug" => slug($request->input("name"))]);
            }

            if($activity->activity_is_add == 0) {
                $sub_activity = SubActivity::create($data);

                return new CommonResource(SubActivity::where('id', $sub_activity->id)->first());
            }
        } else {
            return response()->json([

                'success'   => false,

                'message'   => 'Validation errors',

                'data'      => [
                    "amount" => ["Le montant alloué au sous-activité ne doit pas être supérieur à ". $remain ." F CFA"]
                ]

            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubActivity  $subActivity
     * @return \Illuminate\Http\Response
     */
    public function show(SubActivity $subActivity)
    {
        $subActivity = SubActivity::where('id',$subActivity->id)->first();
        return new CommonResource($subActivity);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubActivity  $subActivity
     * @return \Illuminate\Http\Response
     */
    public function update(SubActivityRequest $request, SubActivity $subActivity)
    {
        $activity_id = intval($request->input("activity_id"));

        $activity = Activity::where('id', $activity_id)->first();

        $remain = $activity->amount - SubActivity::where('activity_id', $activity_id)->where('id', "!=", $subActivity->id)->sum("amount");

        if($remain >= $request->input("amount")) {
            if($request->file("file") != null) {
                $file = "storage/".$request->file("file")->store('subActivityFiles', "public");
                $data = array_merge($request->all(), ["file" => $file, "slug" => slug($request->input("name"))]);
            } else {
                $data = array_merge($request->all(), ["slug" => slug($request->input("name"))]);
            }

            if($activity->sub_activity_is_add == 0) {
                $subActivity->update($data);

                return new CommonResource(SubActivity::where('id', $subActivity->id)->first());
            }
        } else {
            return response()->json([

                'success'   => false,

                'message'   => 'Validation errors',

                'data'      => [
                    "amount" => ["Le montant alloué au sous-activité ne doit pas être supérieur à ". $remain]
                ]

            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubActivity  $subActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubActivity $subActivity)
    {
        $subActivity->delete();
        return response(null, 204);
    }



    public function status(Request $request, $id) {
        $sub_activity = SubActivity::where('id', $id)->first();

        if ($sub_activity->approved == 0) {
            $data = [
                "approved" => $request->input("approved"),
                "message" => $request->input("message"),
                "date_approved" => Carbon::now()
            ];

            if ($request->input("approved")) {
                $data["progress"] = 100;
            }

            $sub_activity->update($data);
        }

        $activity = Activity::where('id', $sub_activity->activity_id)->first();

        $project = Project::where('id', $activity->project_id)->first();

        $activity->update([
            "progress" => SubActivity::whereNotNull("report")->where('approved', 1)->where('activity_id', $activity->id)->sum("weight") * 0.9
        ]);

        $activities = Activity::where('project_id', $activity->project_id)->get();

        $project_percent = 0;

        for($i = 0; $i < count($activities); $i++) {
            $act = $activities[$i];
            $project_percent += ($act->weight * 0.01 * $act->progress);
        }

        $project->update([
            "progress" => $project_percent
        ]);

        $sub_activity = SubActivity::where('id', $sub_activity->id)->first();
        return new CommonResource($sub_activity);
    }



    /********** SECTOR **********/

    public function sector_index($activity_id) {
        $subActivities = SubActivity::where("activity_id", $activity_id)->get();
        return CommonResource::collection($subActivities);
    }

    public function sector_show($id) {
        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->first();

        $activity = Activity::where('id', $id)->where('entity_id', $entity_->id)->with(["entity"])->first();

        return new CommonResource($activity);
    }


    public function sector_report(ReportRequest $request) {

        $sub_activity_id = intval($request->input("sub_activity_id"));

        $sub_activity = SubActivity::where('id', $sub_activity_id)->first();

        $report = "storage/".$request->file("report")->store('reportFiles', "public");

        $sub_activity->update(["report" => $report, "progress" => 0, "approved" => 0, "date_report" => Carbon::now()]);

        return new CommonResource(SubActivity::where('id', $sub_activity->id)->first());
    }
}
