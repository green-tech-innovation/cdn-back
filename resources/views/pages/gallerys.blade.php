@extends('layouts/template', ['title' => $title ?? "", "description" => $description ?? ""])

@section('content')

    <x-breadcrumb :name="$title"></x-breadcrumb>


    <section class="p-md-5 p-3 py-md-3" style="min-height: 60vh">
        <h6 class="text-black fs-6 mb-4">Quelques abums des photos prises</h6>

        <div class="row g-4">
            @foreach ($gallerys as $gallery)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="bg-white box-shadow-">
                        <img src="{{ asset($gallery->file) }}" alt="">
                        <h5 class="text-center text-black- text-4 my-3">
                            {{ $gallery->name }}
                        </h5>
                        <p class="pb-3 text-center">
                            <a href="{{ route('gallery', ['id' => $gallery->id, "slug" => slug($gallery->name)]) }}" class="button-outline">
                                <i class="uil uil-eye text-primary- me-2"></i>
                                Voir l'album
                            </a>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

    </section>

    <style>
        svg {
            height: 20px;
        }
        p.text-sm, div.flex {
            display: none
        }
    </style>

@endsection
