<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourrierResponseRequest;
use App\Http\Resources\CommonResource;
use App\Models\CourrierResponse;
use App\Models\Entity;
use Illuminate\Http\Request;

class CourrierResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courrier_responses = CourrierResponse::all();
        return CommonResource::collection($courrier_responses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourrierResponseRequest $request)
    {
        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->first();

        $data = [];

        if($request->file("file") != null) {
            $file = "storage/".$request->file("file")->store('courrierResponseFiles', "public");
            $data = array_merge($request->all(), ["entity_id" => $entity_->id, "file" => $file]);
        } else {
            $data = array_merge($request->all(), ["entity_id" => $entity_->id]);
        }

        $courrier_response = CourrierResponse::create($data);

        return new CommonResource(CourrierResponse::where('id', $courrier_response->id)->first());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourrierResponse  $courrierResponse
     * @return \Illuminate\Http\Response
     */
    public function show(CourrierResponse $courrierResponse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourrierResponse  $courrierResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourrierResponse $courrierResponse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourrierResponse  $courrierResponse
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourrierResponse $courrierResponse)
    {
        $courrierResponse->delete();
        return response(null, 204);
    }
}
