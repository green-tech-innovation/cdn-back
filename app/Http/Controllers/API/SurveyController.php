<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SurveyRequest;
use App\Http\Resources\CommonResource;
use App\Mail\MailSender;
use App\Models\Entity;
use App\Models\Survey;
use App\Models\SurveyItem;
use App\Models\SurveyVote;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Survey::where("date", "<=", Carbon::now())->update([
            "can_vote" => 0
        ]);

        $surveys = Survey::all();
        return CommonResource::collection($surveys);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SurveyRequest $request)
    {
        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->where('type', "CDN")->first();

        $survey = Survey::create(array_merge($request->all(), ["entity_id" => $entity_->id, "slug" => slug($request->input("name"))]));

        return new CommonResource(Survey::where('id', $survey->id)->first());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey)
    {
        $survey = Survey::where('id', $survey->id);
        return new CommonResource($survey->with(["survey_items"])->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(SurveyRequest $request, Survey $survey)
    {
        $survey->update(array_merge($request->all(), ["slug" => slug($request->input("name"))]));
        $survey = Survey::where('id', $survey->id)->with(["survey_items"])->first();
        return new CommonResource($survey);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey)
    {
        $survey->delete();
        return response()->json([
            "message" => "Sondage supprimer avec succès",
        ], 204);
    }

    public function publish($id) {
        Survey::where('id', $id)->update(["is_published" => true]);

        $survey = Survey::where('id', $id)->first();

        $emails = [];

        $entities = Entity::where('type', '!=', "CDN")->get();

        $title = "Invitation  au sondage ".$survey->name;
        $message = "Vous venez d'être invité à participer  au sondage ".$survey->name." par CDN";

        foreach ($entities as $entity) {
            array_push($emails, $entity->email);
            save_notification($entity->id, $title, $message);
        }

        $details = [
            "subject" => "Invitation au sondage ".$survey->name,
            "type" => "survey",
            "title" =>  "Invitation  au sondage ".$survey->name,
            "survey" => $survey
        ];

        Mail::to($emails[0])->cc($emails)->queue(new MailSender($details));

        return new CommonResource($survey);
    }








    /****************** SECTOR ********************/
    public function sector_index() {
        Survey::where("date", "<=", Carbon::now())->update([
            "can_vote" => 0
        ]);

        $surveys = Survey::where("is_published", 1)->get();

        return CommonResource::collection($surveys);
    }


    public function sector_show($id) {
        $survey = Survey::where("is_published", 1)->where('id', $id)->first();

        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->where('type', '!=', "CDN")->first();

        $survey_vote = SurveyVote::where("entity_id", $entity_->id)->whereIn('survey_item_id', SurveyItem::where('survey_id', $id)->select('id'))->first();

        return CommonResource::collection(["survey"=>$survey, "survey_vote" => $survey_vote]);
    }
}
