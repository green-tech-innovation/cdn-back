<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Http\Resources\CommonResource;
use App\Models\Entity;
use App\Models\Message;
use App\Models\Notifiction;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::all();
        return CommonResource::collection($messages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageRequest $request)
    {
        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->first();

        $data = [];

        if($request->file("file") != null) {
            $file = "storage/".$request->file("file")->store('messageFiles', "public");
            $data = array_merge($request->all(), ["entity_id" => $entity_->id, "file" => $file]);
        } else {
            $data = array_merge($request->all(), ["entity_id" => $entity_->id]);
        }

        $courrier = Message::create($data);

        return new CommonResource(Message::where('id', $courrier->id)->first());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $courrier
     * @return \Illuminate\Http\Response
     */
    public function show(Message $courrier)
    {
        $courrier = Message::where('id', $courrier->id)->first();
        return new CommonResource($courrier);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $courrier
     * @return \Illuminate\Http\Response
     */
    public function update(MessageRequest $request, Message $courrier)
    {
        $data = [];

        if($request->file("file") != null) {
            $file = "storage/".$request->file("file")->store('messageFiles', "public");
            $data = array_merge($request->all(), ["file" => $file]);
        } else {
            $data = $request->all();
        }

        $courrier->update($data);
        return new CommonResource(Message::where('id', $courrier->id)->first());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $courrier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $courrier)
    {
        $courrier->delete();
        return response(null, 204);
    }



    public function notifications() {
        $user = auth()->guard('api')->user();

        $entity = Entity::where('user_id', $user->id)->first();

        $notifications = Notifiction::where('entity_id', $entity->id)->orderBy('id', 'desc')->get();
        return CommonResource::collection($notifications);
    }
}
