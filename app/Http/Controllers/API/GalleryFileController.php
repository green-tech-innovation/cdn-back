<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryFileRequest;
use App\Http\Resources\CommonResource;
use App\Models\Entity;
use App\Models\GalleryFile;
use Illuminate\Http\Request;

class GalleryFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GalleryFileRequest $request)
    {
        $type = str_contains($request->file("file")->extension(), 'mp4') || str_contains($request->file("file")->extension(), 'avi') ? "video" : "image";

        $file = "storage/".$request->file("file")->store('galleryFileFiles', "public");

        $gallery = GalleryFile::create(array_merge($request->all(), ["type" => $type, "file" => $file]));

        return new CommonResource(GalleryFile::where('id', $gallery->id)->first());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GalleryFile  $galleryFile
     * @return \Illuminate\Http\Response
     */
    public function show(GalleryFile $galleryFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GalleryFile  $galleryFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GalleryFile $galleryFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GalleryFile  $galleryFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(GalleryFile $galleryFile)
    {
        $galleryFile->delete();
        return response()->json([
            "message" => "Fichier supprimer avec succès",
        ], 204);
    }
}
