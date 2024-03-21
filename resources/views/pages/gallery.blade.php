@extends('layouts/template', ['title' => $title ?? "", "description" => $description ?? ""])

@section('content')

    <x-breadcrumb :name="$title"></x-breadcrumb>


    <section class="p-md-5 p-3 py-md-3">
        <h6 class="text-black fs-6 mb-4">{{ $title }} du secteur {{ $gallery->entity->name }}</h6>

        <div class="row g-0">
            @foreach ($gallery->gallery_files as $gallery_file)
                <div class="col-xl-3 col-md-4 col-sm-6">
                    <a href="{{ asset($gallery_file->file) }}" target="_blank">
                        <img src="{{ asset($gallery_file->file) }}" alt="" class="gallery_single_img w-100">
                    </a>
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
