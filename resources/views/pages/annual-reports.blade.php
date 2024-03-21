@extends('layouts/template', ['title' => $title ?? "", "description" => $description ?? ""])

@section('content')

    <x-breadcrumb :name="$title"></x-breadcrumb>

    <section class="p-md-5 p-3 py-md-3" style="min-height: 60vh">
        <h6 class="text-black fs-6 mb-4">La liste des rapports annuels des secteurs</h6>

        <div class="row g-4">
            @foreach ($annual_reports as $annual_report)
                <div class="col-xl-3 col-md-4 col-sm-6">
                    <div class="bg-white shadow-sm">
                        <h6 class="p-3 py-2 shadow-sm bg-primary-" style="height: 78px; font-family: sans-serif">
                            <div class="row h-100">
                                <div class="my-auto fw-400 lh-lg text-6 text-5 text-white">
                                    {{ $annual_report->name }}
                                </div>
                            </div>
                        </h6>
                        <div class="p-3">
                            <p class="text-black- text-6">Secteur : {{ $annual_report->entity->name }}</p>
                            <p class="text-black- mb-0 text-6">Année : {{ $annual_report->year }}</p>
                        </div>
                        <hr class="bg-red- my-0">
                        <div class="py-2 text-center">
                            <a href="{{ asset($annual_report->file) }}" download="{{ $annual_report->name }}" target="_blank" class="bg-white text-6 fw-600 text-center border-0 text-red-">
                                <i class="uil uil-download-alt text-red- fs-6 me-3"></i>
                                Télécharger
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mt-4 mb-2 text-center">
                {{ $annual_reports->links() }}
            </div>

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
