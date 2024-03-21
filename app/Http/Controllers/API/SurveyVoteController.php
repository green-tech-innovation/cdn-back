<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SurveyVoteRequest;
use App\Http\Resources\CommonResource;
use App\Models\Entity;
use App\Models\Survey;
use App\Models\SurveyItem;
use App\Models\SurveyVote;
use Illuminate\Http\Request;

class SurveyVoteController extends Controller
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
    public function store(SurveyVoteRequest $request)
    {
        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->where('type', '!=', "CDN")->first();

        $survey_item = SurveyItem::where('id', $request->input("survey_item_id"))->first();

        $surveyVote = SurveyVote::create(array_merge($request->all(), ['entity_id' => $entity_->id]));

        $survey_vote = SurveyVote::where('id', $surveyVote->id)->first();

        $survey = Survey::where('id', $survey_item->survey_id)->first();

        return new CommonResource(["survey" => $survey, "survey_vote" => $survey_vote]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SurveyVote  $surveyVote
     * @return \Illuminate\Http\Response
     */
    public function show(SurveyVote $surveyVote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SurveyVote  $surveyVote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SurveyVote $surveyVote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SurveyVote  $surveyVote
     * @return \Illuminate\Http\Response
     */
    public function destroy(SurveyVote $surveyVote)
    {
        //
    }
}
