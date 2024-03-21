<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormularQuizRequest;
use App\Http\Resources\CommonResource;
use App\Models\FormularQuiz;
use Illuminate\Http\Request;

class FormularQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formular_quizs = FormularQuiz::all();
        return CommonResource::collection($formular_quizs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormularQuizRequest $request)
    {
        $formular_quiz = FormularQuiz::create(array_merge($request->all()));
        return new CommonResource(FormularQuiz::where('id', $formular_quiz->id)->first());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FormularQuiz  $formularQuiz
     * @return \Illuminate\Http\Response
     */
    public function show(FormularQuiz $formularQuiz)
    {
        return new CommonResource($formularQuiz);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FormularQuiz  $formularQuiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormularQuiz $formularQuiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FormularQuiz  $formularQuiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormularQuiz $formularQuiz)
    {
        //
    }
}
