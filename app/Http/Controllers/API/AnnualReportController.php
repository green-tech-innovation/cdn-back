<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnnualReportRequest;
use App\Http\Resources\CommonResource;
use App\Models\AnnualReport;
use App\Models\Entity;

class AnnualReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $annual_reports = AnnualReport::all();
        return CommonResource::collection($annual_reports);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnnualReportRequest $request)
    {
        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->first();

        if(AnnualReport::where("year", $request->input("year"))->where("entity_id", $entity_->id)->count() == 0) {

            $data = [];

            if($request->file("file") != null) {
                $file = "storage/".$request->file("file")->store('annualReportFiles', "public");
                $data = array_merge($request->all(), ["entity_id" => $entity_->id, "file" => $file]);
            } else {
                $data = array_merge($request->all(), ["entity_id" => $entity_->id]);
            }

            $annualReport = AnnualReport::create($data);

            return new CommonResource(AnnualReport::where('id', $annualReport->id)->first());
        } else {
            return response()->json([
                "message" => "Vous avez déjà envoyé le rapport de cette année"
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnnualReport  $annualReport
     * @return \Illuminate\Http\Response
     */
    public function show(AnnualReport $annualReport)
    {
        $annualReport = AnnualReport::where('id',$annualReport->id)->first();
        return new CommonResource($annualReport);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AnnualReport  $annualReport
     * @return \Illuminate\Http\Response
     */
    public function update(AnnualReportRequest $request, AnnualReport $annualReport)
    {
        $data = [];

        if($request->file("file") != null) {
            $file = "storage/".$request->file("file")->store('courrierFiles', "public");
            $data = array_merge($request->all(), ["file" => $file]);
        } else {
            $data = $request->all();
        }

        $annualReport->update($data);
        return new CommonResource(AnnualReport::where('id', $annualReport->id)->first());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnnualReport  $annualReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnnualReport $annualReport)
    {
        $annualReport->delete();
        return response(null, 204);
    }





    public function sector_index() {

        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->where('type', '!=', "CDN")->first();

        return new CommonResource(AnnualReport::where("entity_id", $entity_->id)->get());

    }
}
