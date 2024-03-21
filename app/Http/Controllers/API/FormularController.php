<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormularRequest;
use App\Http\Resources\CommonResource;
use App\Models\Entity;
use App\Models\Formular;
use App\Models\FormularParticipant;
use App\Models\FormularQuiz;
use App\Models\FormularResponse;
use Carbon\Carbon;

class FormularController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Formular::where("date", "<=", Carbon::now())->update([
            "can_submit" => 0
        ]);

        $formulars = Formular::all();
        return CommonResource::collection($formulars);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormularRequest $request)
    {
        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->first();

        $formular = Formular::create(array_merge($request->all(), ["entity_id" => $entity_->id, "slug" => slug($request->input("name"))]));

        $formular = Formular::where('id', $formular->id)->first();
        return new CommonResource($formular);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Formular  $formular
     * @return \Illuminate\Http\Response
     */
    public function show(Formular $formular)
    {
        $formular = Formular::where('id', $formular->id)->first();
        return new CommonResource($formular);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Formular  $formular
     * @return \Illuminate\Http\Response
     */
    public function update(FormularRequest $request, Formular $formular)
    {
        $formular->update(array_merge($request->all(), ["slug" => slug($request->input("name"))]));
        $formular = Formular::where('id', $formular->id)->first();
        return new CommonResource($formular);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Formular  $formular
     * @return \Illuminate\Http\Response
     */
    public function destroy(Formular $formular)
    {
        $formular->delete();
        return response()->json([
            "message" => "Formulaire supprimer avec succès",
        ], 204);
    }

    public function publish($id) {
        Formular::where('id', $id)->update(["is_published" => true]);

        $entities = Entity::whereIn('id', FormularParticipant::where('formular_id', $id)->select('entity_id'))->get();

        $formular = Formular::where('id', $id)->first();

        $title = "Nouveau Formulaire";
        $message = "Vous venez d'être ajouter le formulaire ".$formular->name." par CDN";

        foreach ($entities as $entity) {
            save_notification($entity->id, $title, $message);
        }

        return new CommonResource($formular);
    }





    /****************** SECTOR ********************/
    public function sector_index() {
        Formular::where("date", "<=", Carbon::now())->update([
            "can_submit" => 0
        ]);

        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->first();

        $formulars = Formular::where("is_published", 1)->whereIn('id', FormularParticipant::where('entity_id', $entity_->id)->select('formular_id'))->get();

        return CommonResource::collection($formulars);
    }


    public function sector_show($id) {

        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->where('type', '!=', "CDN")->first();

        $formular = Formular::where("is_published", 1)->where('id', $id)->whereIn('id', FormularParticipant::where('entity_id', $entity_->id)->select('formular_id'))->first();

        $formular_responses = FormularResponse::where("entity_id", $entity_->id)->whereIn('formular_quiz_id', FormularQuiz::where('formular_id', $id)->select('id'))->with(["formular_quiz"])->get();

        return CommonResource::collection(["formular"=>$formular, "formular_responses" => $formular_responses]);
    }
}
