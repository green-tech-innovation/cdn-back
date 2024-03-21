<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectPartnerRequest;
use App\Http\Resources\CommonResource;
use App\Models\ProjectPartner;
use Illuminate\Http\Request;

class ProjectPartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projectPartners = ProjectPartner::all();
        return CommonResource::collection($projectPartners);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectPartnerRequest $request)
    {
        $data = $request->all();
        if($request->file("file")) {
            $file = "storage/".$request->file("file")->store('projectPartnerFiles', "public");
            $data = array_merge($request->all(), ["file" => $file]);
        }

        $projectPartner = ProjectPartner::create($data);

        return new CommonResource(ProjectPartner::where("id", $projectPartner->id)->first());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectPartner  $projectPartner
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectPartner $projectPartner)
    {
        //$projectPartner = ProjectPartner::where('id', $projectPartner->id)->first();
        return new CommonResource($projectPartner);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectPartner  $projectPartner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectPartner $projectPartner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectPartner  $projectPartner
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectPartner $projectPartner)
    {
        $projectPartner->delete();

        return response()->json([
            "message" => "Partenaire supprimé avec succès",
        ], 204);
    }
}
