<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormularParticipantRequest;
use App\Http\Resources\CommonResource;
use App\Models\FormularParticipant;
use Illuminate\Http\Request;

class FormularParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $participants = FormularParticipant::all();
        return CommonResource::collection($participants);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormularParticipantRequest $request)
    {
        $entities = json_decode(($request->input("entity_id")));
        for ($i=0; $i < count($entities) ; $i++) {
            FormularParticipant::create([
                "formular_id" => $request->input("formular_id"),
                "entity_id" => $entities[$i]
            ]);
        }
        $participants = FormularParticipant::where("formular_id", $request->input("formular_id"))->get();
        return CommonResource::collection($participants);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FormularParticipant  $participant
     * @return \Illuminate\Http\Response
     */
    public function show(FormularParticipant $participant)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FormularParticipant  $participant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormularParticipant $participant)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FormularParticipant  $participant
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormularParticipant $formularParticipant)
    {
        $formularParticipant->delete();

        return response()->json([
            "message" => "Participant supprimé avec succès".$formularParticipant->id,
        ], 204);
    }
}
