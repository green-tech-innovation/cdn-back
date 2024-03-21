<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourrierRequest;
use App\Http\Resources\CommonResource;
use App\Models\Courrier;
use App\Models\Entity;

class CourrierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courriers = Courrier::all();
        return CommonResource::collection($courriers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourrierRequest $request)
    {
        $user = auth()->guard('api')->user();

        $entity = Entity::where('user_id', $user->id)->first();

        $to_id = "";

        if ($request->input("to_id") != "") {
            $to_id = $request->input("to_id");
        } else {
            $entity_ = Entity::where('type', "CDN")->first();
            $to_id = $entity_->id;
        }

        $data = [];

        if($request->file("file") != null) {
            $file = "storage/".$request->file("file")->store('courrierFiles', "public");
            $data = array_merge($request->all(), ["entity_id" => $entity->id, "to_id" => $to_id, "file" => $file, "slug" => slug($request->input("name"))]);
        } else {
            $data = array_merge($request->all(), ["entity_id" => $entity->id, "to_id" => $to_id, "slug" => slug($request->input("name"))]);
        }

        $courrier = Courrier::create($data);

        return new CommonResource(Courrier::where('id', $courrier->id)->first());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Courrier  $courrier
     * @return \Illuminate\Http\Response
     */
    public function show(Courrier $courrier)
    {
       $courrier = Courrier::where('id', $courrier->id)->first();
        return new CommonResource($courrier);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Courrier  $courrier
     * @return \Illuminate\Http\Response
     */
    public function update(CourrierRequest $request, Courrier $courrier)
    {
        $data = [];

        if($request->file("file") != null) {
            $file = "storage/".$request->file("file")->store('courrierFiles', "public");
            $data = array_merge($request->all(), ["file" => $file, "slug" => slug($request->input("name"))]);
        } else {
            $data = array_merge($request->all(), ["slug" => slug($request->input("name"))]);
        }

        $courrier->update($data);
        return new CommonResource(Courrier::where('id', $courrier->id)->first());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Courrier  $courrier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Courrier $courrier)
    {
        $courrier->delete();
        return response(null, 204);
    }




    /*********** GENERAL ***********/
    public function general_index() {
        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->where('type', '!=', "CDN")->first();

        $courriers = Courrier::where('entity_id', $entity_->id)->orWhere('to_id', $entity_->id)->get();

        return CommonResource::collection($courriers);
    }


    public function general_show($id) {
        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->first();

        $courrier = Courrier::where('id', $id)->where(function($query) use ($entity_) {
            $query->where('entity_id', $entity_->id)->orWhere('to_id', $entity_->id);
        })->first();

        //$courrier = Courrier::where('id', $courrier->id)->first();

        return new CommonResource($courrier);
    }
}
