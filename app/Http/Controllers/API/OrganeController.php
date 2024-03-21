<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganeRequest;
use App\Http\Resources\CommonResource;
use App\Models\Organe;

class OrganeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organes = Organe::all();
        return CommonResource::collection($organes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganeRequest $request)
    {
        $organe = Organe::create($request->all());
        return new CommonResource($organe);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Organe  $organe
     * @return \Illuminate\Http\Response
     */
    public function show(Organe $organe)
    {
        $organe = Organe::where('id', $organe->id);
        return new CommonResource($organe->with(["projects"])->first());
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organe  $organe
     * @return \Illuminate\Http\Response
     */
    public function update(OrganeRequest $request, Organe $organe)
    {
        $organe->update($request->all());
        $organe = Organe::where('id', $organe->id)->with(["projects"])->first();
        return new CommonResource($organe);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Organe  $organe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organe $organe)
    {
        $organe->delete();
        return response()->json([
            "message" => "Organe supprimer avec succès",
        ], 204);
    }
}
