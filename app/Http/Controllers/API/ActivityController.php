<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityReportRequest;
use App\Http\Requests\ActivityRequest;
use App\Http\Resources\CommonResource;
use App\Models\Activity;
use App\Models\Project;
use App\Models\SubActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Activity::whereIn("project_id", Project::where('activity_is_add', 1)->select("id")->get())->with(['project'])->get();
        return CommonResource::collection($activities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivityRequest $request)
    {

        $project_id = intval($request->input("project_id"));

        $project = Project::where('id', $project_id)->first();

        $remain = $project->cost - Activity::where('project_id', $project_id)->sum("amount");

        if($remain >= $request->input("amount")) {

            if($request->file("file") != null) {
                $file = "storage/".$request->file("file")->store('activityFiles', "public");
                $data = array_merge($request->all(), ["file" => $file, "slug" => slug($request->input("name"))]);
            } else {
                $data = array_merge($request->all(), ["slug" => slug($request->input("name"))]);
            }

            if($project->activity_is_add == 0) {
                $activity = Activity::create($data);

                return new CommonResource(Activity::where('id', $activity->id)->first());
            }
        } else {
            return response()->json([

                'success'   => false,

                'message'   => 'Validation errors',

                'data'      => [
                    "amount" => ["Le montant alloué à l'activité ne doit pas être supérieur à ". $remain ." F CFA"]
                ]

            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        $activity = Activity::where('id',$activity->id)->first();
        $activity['sub_activities'] = $activity->sub_activity_is_add == 1 ? SubActivity::where('activity_id', $activity->id)->get() : [];
        return new CommonResource($activity);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityRequest $request, Activity $activity)
    {
        $project_id = intval($request->input("project_id"));

        $project = Project::where('id', $project_id)->first();

        $remain = $project->cost - Activity::where('project_id', $project_id)->where('id', "!=", $activity->id)->sum("amount");

        if($remain >= $request->input("amount")) {
            if($request->file("file") != null) {
                $file = "storage/".$request->file("file")->store('activityFiles', "public");
                $data = array_merge($request->all(), ["file" => $file, "slug" => slug($request->input("name"))]);
            } else {
                $data = array_merge($request->all(), ["slug" => slug($request->input("name"))]);
            }

            if($project->activity_is_add == 0) {
                $activity->update($data);

                return new CommonResource(Activity::where('id', $activity->id)->first());
            }
        } else {
            return response()->json([

                'success'   => false,

                'message'   => 'Validation errors',

                'data'      => [
                    "amount" => ["Le montant alloué à l'activité ne doit pas être supérieur à ". $remain]
                ]

            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        $project = Project::where('id', $activity->project_id)->first();

        if($project->activity_is_add == 0) {
            $activity->delete();
            return response(null, 204);
        }
    }


    /***************  CDN  **************/

    public function status(Request $request, $id) {
        $activity = Activity::where('id', $id)->first();

        if ($activity->progress == 90 && $activity->approved == 0) {
            $data = [
                "approved" => $request->input("approved"),
                "message" => $request->input("message"),
                "date_approved" => Carbon::now()
            ];

            if ($request->input("approved") == 1) {
                $data["progress"] = 100;
            }

            $activity->update($data);

            $activities = Activity::where('project_id', $activity->project_id)->get();

            $project_percent = 0;

            for($i = 0; $i < count($activities); $i++) {
                $act = $activities[$i];
                $project_percent += ($act->weight * 0.01 * $act->progress);
            }

            $project = Project::where('id', $activity->project_id)->first();

            $project->update([
                "progress" => $project_percent
            ]);
        }

        $activity = Activity::where('id', $activity->id)->first();
        return new CommonResource($activity);
    }




    /***************  SECTOR *************** */


    public function sector_show($id)
    {
        $activity = Activity::where('id', $id)->first();
        $activity['sub_activities'] = SubActivity::where('activity_id', $activity->id)->get();
        return new CommonResource($activity);
    }

    public function sector_publish($id) {

        $amount_sum = SubActivity::where('activity_id', $id)->sum("amount");
        $weight_sum = SubActivity::where('activity_id', $id)->sum("weight");

        $activity = Activity::where('id', $id)->first();
        $activity['sub_activities'] = SubActivity::where('activity_id', $activity->id)->get();

        $message = [];

        if($activity->amount != $amount_sum) {
            array_push($message, "Le total des montants des sous-activités est ".$amount_sum.", ça devrait être égale à ".$activity->amount);
        }

        if($weight_sum != 100) {
            array_push($message, "Le cumul de poids des sous-activités doit être égale à 100, actuellement ".$weight_sum);
        }

        if(count($message) == 0) {
            Activity::where('id', $id)->update(["sub_activity_is_add" => true]);
            return new CommonResource(Activity::where('id', $id)->first());
        } else {
            return response()->json([
                "status" => false,
                "message" => $message
            ]);
        }
    }


    public function sector_report_publish($id) {
        $activity = Activity::where('id', $id)->first();

        Activity::where('id', $id)->update(["report_public" => $activity->report_public ? false : true]);

        return new CommonResource(Activity::where('id', $id)->first());
    }



    public function sector_report(ActivityReportRequest $request) {

        $activity_id = intval($request->input("activity_id"));

        $activity = Activity::where('id', $activity_id)->first();

        $report = "storage/".$request->file("report")->store('activityReportFiles', "public");

        $activity->update(["report" => $report, "approved" => 0, "date_report" => Carbon::now()]);



        return new CommonResource(Activity::where('id', $activity->id)->first());
    }
}
