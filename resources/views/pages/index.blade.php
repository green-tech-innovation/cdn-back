@extends('layouts/template', ['title' => $title ?? "", "description" => $description ?? ""])

@section('content')

    <header class="header border-0" style="background-image: url({{ asset('assets/images/header.png') }})">
        <div class="row" style="height: 100vh !important">
            <div class="col-lg-6 col-md-8 col-sm-10 col-11 mx-auto my-auto">
                <h1 class="text-center fw-1000 text-primary-" style="margin-top: 150px">
                    Tous ensemble, luttons contre le réchauffement climatique
                </h1>
                <p class="text-center text-black lh-lg fs-6 mt-4">
                    CDN du Bénin 2021-2030: Réduire de 20,15% les émissions cumulées des GES soit 48,75 Mt E CO2
                </p>
            </div>
        </div>
    </header>

    <!-- PATNER -->
    <section class="containe py-5 bg-white">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach ($patners as $patner)
                    <div class="swiper-slide">
                        <a href="" title="{{ $patner->name }}">
                            <img class="p-2" src="{{ asset('assets/images/patner_one.png') }}" alt="">
                        </a>
                    </div>
                @endforeach
                <div class="swiper-slide">
                    <a href="" title="">
                        <img class="p-2" src="{{ asset('assets/images/gdiz.png') }}" alt="">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="" title="">
                        <img class="p-3" src="{{ asset('assets/images/pnud.png') }}" alt="">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="" title="">
                        <img class="p-2" src="{{ asset('assets/images/enabel.png') }}" alt="">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="" title="">
                        <img class="p-2" src="{{ asset('assets/images/banque-mondiale.png') }}" alt="">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="" title="">
                        <img class="p-2" src="{{ asset('assets/images/gdiz.png') }}" alt="">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="" title="">
                        <img class="p-3" src="{{ asset('assets/images/pnud.png') }}" alt="">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="" title="">
                        <img class="p-2" src="{{ asset('assets/images/enabel.png') }}" alt="">
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="" title="">
                        <img class="p-2" src="{{ asset('assets/images/banque-mondiale.png') }}" alt="">
                    </a>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    {{-- ADVANTAGE --}}
    <section class="bg-dark- py-4">
        <div class="containe">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-10 mx-auto">
                    <div class="card_best" style="background-image: url({{ asset('assets/images/creative-circle.png') }})">
                        <div class="hstack rounded shadow-sm bg-primary- p-3">
                            <img src="{{ asset('assets/images/partenaires.png') }}" class="card_best_image" alt="">
                            <h6 class="text-white text-6 text-uppercase lh-lg">
                                les partenaires qui investissent pour l'évolution
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-10 mx-auto">
                    <div class="card_best" style="background-image: url({{ asset('assets/images/creative-circle.png') }})">
                        <div class="hstack rounded shadow-sm bg-yellow-light- p-3">
                            <img src="{{ asset('assets/images/gouv.png') }}" class="card_best_image" alt="">
                            <h6 class="text-white text-6 text-uppercase lh-lg">
                                le gouvernement qui investit dans les différents secteurs d'intervention
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-10 mx-auto">
                    <div class="card_best" style="background-image: url({{ asset('assets/images/creative-circle.png') }})">
                        <div class="hstack rounded shadow-sm bg-red- p-3">
                            <img src="{{ asset('assets/images/report.png') }}" class="card_best_image p-1" alt="">
                            <h6 class="text-white text-6 text-uppercase lh-lg">
                                logiciel de planning et de suivi des activités des projets
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="py-5 bg-light-">
        <div class="containe">
            <x-about></x-about>
        </div>
    </section>


    <section class="py-5 bg-white">
        <div class="containe">
            <div class="row">
                <div class="col-md-6 box-shadow- py-4 px-4">
                    <h4 class="text-black text-center text-4 lh-lg ">
                        DIRECTION GENERALE DE L’ENVIRONNEMENT ET DU CLIMAT
                        CONTRIBUTION DETERMINEE AU NIVEAU NATIONAL
                    </h4>
                    <p class="text-5 lh-lg">
                        L'urgence climatique est une course que nous sommes en train de perdre, mais c'est une course que nous pouvons gagner. Nous sommes la cause de la crise climatique et les solutions doivent venir de nous. Nous avons les outils nécessaires : la technologie est de notre côté.
                    </p>
                    <div class="text-center">
                        <a href="{{ route('reports') }}" class="button">voir tous les rapports</a>
                    </div>
                </div>
                <div class="col-md-6 p-3 py-4" style="background-image: url({{ asset('assets/images/rapport.png') }}); background-size: cover">
                    <h1 class="text-center text-white fw-1000 mt-3">+ {{ $number_reports }} <br> Rapports Disponibles</h1>
                    <hr class="bg-white-">
                    <p class="text-white text-center mt-3">
                        Des informations disponibles à la portée de tout le monde. Vous y trouverez plus de détails.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="bg-primary- py-5">
            <h1 class="text-white- text-uppercase fw-1000 text-center">
                Notre galerie
            </h1>
            <p class="text-white- mb-4 text-center">
                L'historique de nos actions sur le terrain
            </p>
        </div>
        <div class="col-11 mx-auto" style="margin-top: -50px">
            <div class="row g-2">
                @foreach ($gallerys as $gallery)
                    <div class="col-lg-3 col-md-6 col-sm-6">
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
            <div class="text-center mt-2 mb-4">
                <a href="{{ route('gallerys') }}" class="button bg-yellow-">
                    <i class="uil uil-image text-white me-2 fs-5"></i>
                    Découvrez notre galerie
                </a>
            </div>
        </div>
    </section>

@endsection
