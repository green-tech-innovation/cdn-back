<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\CommonResource;
use App\Mail\MailSender;
use App\Models\Entity;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Support\Facades\Mail;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();
        return CommonResource::collection($events);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->where('type', "CDN")->first();

        $event = Event::create(array_merge($request->all(), ["entity_id" => $entity_->id]));
        return new CommonResource($event);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $event = Event::where('id', $event->id);
        return new CommonResource($event->with(["participants"])->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, Event $event)
    {
        $event->update($request->all());
        $event = Event::where('id', $event->id)->first();
        return new CommonResource($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json([
            "message" => "Evènement supprimer avec succès",
        ], 204);
    }


    public function send_reminder($id) {
        $entities = Entity::whereIn('id', Participant::where('event_id', $id)->select('entity_id'))->get();

        $event = Event::where('id', $id)->first();

        $emails = [];

        $title = "Invitation à l'évènement ".$event->name;
        $message = "Vous venez d'être invité à participer à l'évènement ".$event->name." par CDN";

        foreach ($entities as $entity) {
            array_push($emails, $entity->email);
            save_notification($entity->id, $title, $message);
        }

        $details = [
            "subject" => "Invitation à l'évènement ".$event->name,
            "type" => "event",
            "title" =>  "Invitation à l'évènement ".$event->name,
            "event" => $event
        ];

        Mail::to($emails[0])->cc($emails)->queue(new MailSender($details));

        return response()->json([
            "status" => true,
            "emails" => $emails
        ]);
    }







}
