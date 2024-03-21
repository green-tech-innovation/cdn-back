<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EntityRequest;
use App\Http\Resources\CommonResource;
use App\Mail\MailSender;
use App\Models\Entity;
use App\Models\Personal;
use App\Models\ProjectPartner;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EntityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->type != null) {
            $entities = Entity::where('type', $request->type)->with(['category', 'user'])->get();
        } else {
            $entities = Entity::where("type", "!=", "CDN")->with(['category', 'user'])->get();
        }
        return CommonResource::collection($entities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EntityRequest $request)
    {
        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->where('type', "CDN")->first();

        $file = "";

        if ($request->file("file")) {
            $file = "storage/".$request->file("file")->store('logoFiles', "public");
        }

        $data = $request->except(['file']);

        $entity = Entity::create(array_merge($data, ["logo" => $file, "slug" => slug($request->input("name")), "creator_id" => $entity_->id]));

        Personal::create([
            "date_start" => Carbon::now(),
            'user_id' => $entity->user_id,
            'entity_id' =>  $entity->id
        ]);

        $user = User::find($entity->user_id);

        $password = generateRandomString();

        User::where('id', $entity->user_id)->update([
            "password" => Hash::make($password)
        ]);

        $details = [
            "subject" => "Responsable secteur",
            "type" => "entity_personnal",
            "title" => "Responsable secteur",
            "user" => $user,
            "entity" => $entity,
            "password" => $password
        ];

        Mail::to($user->email)->queue(new MailSender($details));

        return new CommonResource(Entity::where('id', $entity->id)->with(['category', 'user'])->first());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Entity  $entity
     * @return \Illuminate\Http\Response
     */
    public function show(Entity $entity)
    {
        if($entity->type == "SECTOR") {
            $entity = Entity::where('id', $entity->id)->with(['projects', 'personals', 'annual_reports', 'category', 'user'])->first();
        } else {
            $entity = Entity::where('id', $entity->id)->with(['personals', 'category', 'user'])->first();
            $entity['project_patners'] = ProjectPartner::where('entity_id', $entity->id)->with(['project'])->get();
        }
        return new CommonResource($entity);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entity  $entity
     * @return \Illuminate\Http\Response
     */
    public function update(EntityRequest $request, Entity $entity)
    {
        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->where('type', "CDN")->first();

        if($entity->user_id != $request->input('user_id')) {
            Personal::where('user_id', $entity->user_id)->where('entity_id', $entity->id)->whereNull('date_end')->update([
                "date_end" => Carbon::now()
            ]);

            Personal::create([
                "date_start" => Carbon::now(),
                'user_id' => $request->input('user_id'),
                'entity_id' =>  $entity->id
            ]);


            $user = User::find($entity->user_id);

            $password = generateRandomString();

            User::where('id', $entity->user_id)->update([
                "password" => Hash::make($password)
            ]);

            $details = [
                "subject" => "Responsable secteur",
                "type" => "entity_personnal",
                "title" => "Responsable secteur",
                "user" => $user,
                "entity" => $entity,
                "password" => $password
            ];

            Mail::to($user->email)->queue(new MailSender($details));
        }


        $data = $request->except(['file']);

        if ($request->file("file")) {
            $file = "storage/".$request->file("file")->store('logoFiles', "public");
            $entity->update($data, ["logo" => $file, "slug" => slug($request->input("name")), "editor_id" => $entity_->id]);
        } else {
            $entity->update($data, ["slug" => slug($request->input("name")), "editor_id" => $entity_->id]);
        }

        return new CommonResource(Entity::where('id', $entity->id)->with(['category', 'user'])->first());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entity  $entity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entity $entity)
    {
        $entity->delete();
        return response(null, 204);
    }
}
