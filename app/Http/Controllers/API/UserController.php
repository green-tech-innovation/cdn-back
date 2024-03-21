<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterVerifyRequest;
use App\Http\Resources\CommonResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->guard('api')->user();
        $users  = User::where('id', "!=", $user->id)->get();
        return new CommonResource($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterVerifyRequest $request) {
        User::where('email', $request->email)->delete();

        $user = User::create([
            "email" => $request->email,
            "password" => Hash::make("123456"),
            "lastname" => $request->lastname,
            "firstname" => $request->firstname,
            "phone" => $request->phone,
            "sex" => $request->sex,
            "email_verified_at" => Carbon::now()
        ]);

        return new CommonResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user = User::where('id', $user->id)->with(["personals", "personals.entity"])->first();
        return new CommonResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        $user = User::where('id', $user->id)->first();
        return new CommonResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
