<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryRequest;
use App\Http\Resources\CommonResource;
use App\Models\Entity;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gallerys = Gallery::all();
        return CommonResource::collection($gallerys);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GalleryRequest $request)
    {
        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->first();

        //$type = str_contains($request->file("file")->extension(), 'mp4') ? "video" : "image";

        $file = "storage/".$request->file("file")->store('galleryFiles', "public");

        $gallery = Gallery::create(array_merge($request->all(), ["entity_id" => $entity_->id, "file" => $file, "slug" => slug($request->input("name"))]));

        return new CommonResource(Gallery::where('id', $gallery->id)->first());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        return new CommonResource(Gallery::where('id', $gallery->id)->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(GalleryRequest $request, Gallery $gallery)
    {
        $data = [];

        if($request->file("file") != null) {
            $file = "storage/".$request->file("file")->store('galleryFiles', "public");
            $data = array_merge($request->all(), ["file" => $file, "slug" => slug($request->input("name"))]);
        } else {
            $data = array_merge($request->all(), ["slug" => slug($request->input("name"))]);
        }

        $gallery->update($data);

        return new CommonResource(Gallery::where('id', $gallery->id)->first());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return response()->json([
            "message" => "Album supprimer avec succès",
        ], 204);
    }



    public function sector_index() {
        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->where('type', '!=', "CDN")->first();

        $gallerys = Gallery::where("entity_id", $entity_->id)->get();

        return CommonResource::collection($gallerys);
    }



    public function sector_show($id) {
        $user = auth()->guard('api')->user();

        $entity_ = Entity::where('user_id', $user->id)->where('type', '!=', "CDN")->first();

        return new CommonResource(Gallery::where('id', $id)->where("entity_id", $entity_->id)->first());
    }
}
