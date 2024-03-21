<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormularResponseRequest;
use App\Http\Resources\CommonResource;
use App\Models\Entity;
use App\Models\Formular;
use App\Models\FormularQuiz;
use App\Models\FormularResponse;
use Illuminate\Http\Request;

class FormularResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formular_responses = FormularResponse::all();
        return CommonResource::collection($formular_responses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormularResponseRequest $request)
    {
        $formular_id = $request->input("formular_id");

        $formular_quizzes = FormularQuiz::where('formular_id', $formular_id)->get();

        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->where('type', '!=', "CDN")->first();

        $responses = (array) json_decode($request->input("responses"));
        $message = [];

        for($i = 0; $i < count($formular_quizzes); $i++) {
            $formular_quiz = $formular_quizzes[$i];

            FormularResponse::create([
                "entity_id" => $entity_->id,
                "formular_quiz_id" => $formular_quiz->id,
                "response" => $responses["quiz".$formular_quiz->id]
            ]);
        }

        $formular = Formular::where("is_published", 1)->where('id', $formular_id)->first();

        $formular_responses = FormularResponse::where("entity_id", $entity_->id)->whereIn('formular_quiz_id', FormularQuiz::where('formular_id', $formular_id)->select('id'))->with(["formular_quiz"])->get();

        return CommonResource::collection(["formular"=>$formular, "formular_responses" => $formular_responses]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FormularResponse  $formularResponse
     * @return \Illuminate\Http\Response
     */
    public function show(FormularResponse $formularResponse)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FormularResponse  $formularResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormularResponse $formularResponse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FormularResponse  $formularResponse
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormularResponse $formularResponse)
    {
        //
    }
}
