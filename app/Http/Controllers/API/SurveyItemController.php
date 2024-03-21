<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SurveyItemRequest;
use App\Http\Resources\CommonResource;
use App\Models\SurveyItem;
use Illuminate\Http\Request;

class SurveyItemController extends Controller
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
    public function store(SurveyItemRequest $request)
    {
        $surveyItem = SurveyItem::create($request->all());
        return new CommonResource(SurveyItem::where('id', $surveyItem->id)->with('survey')->first());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SurveyItem  $surveyItem
     * @return \Illuminate\Http\Response
     */
    public function show(SurveyItem $surveyItem)
    {
        return new CommonResource($surveyItem);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SurveyItem  $surveyItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SurveyItem $surveyItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SurveyItem  $surveyItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(SurveyItem $surveyItem)
    {

        $surveyItem->delete();
        return response(null, 204);
    }
}
