@extends('layouts/template', ['title' => $title ?? "", "description" => $description ?? ""])

@section('content')

    <x-breadcrumb :name="$title"></x-breadcrumb>

    <section class="bg-light- py-md-5 py-3">
        <div class="containe">
            <x-about></x-about>

            <div class="row mt-4 g-3">
                <div class="col-md-6">
                    <div class="bg-white- h-100 box-shadow- py-4 px-4">
                        <h4 class="text-black text-center text-4 lh-lg ">
                            Agriculture
                        </h4>
                        <p class="text-5 lh-lg">
                            <span class="text-red- me-2">o</span> Adoption des techniques culturales améliorées dans le cadre de la production végétale. <br>
                            <span class="text-red- me-2">o</span> Gestion de la fertilité des sols dans le cadre de la production végétale. <br>
                            <span class="text-red- me-2">o</span> Aménagements hydro-agricoles.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-white- h-100 box-shadow- py-4 px-4">
                        <h4 class="text-black text-center text-4 lh-lg ">
                            Energie
                        </h4>
                        <p class="text-5 lh-lg">
                            <span class="text-red- me-2">o</span> Extension de l’accès à l’éclairage électrique dans le secteur résiduel <br>
                            <span class="text-red- me-2">o</span> Consommations efficaces d’électricité dans le secteur résidentiel <br>
                            <span class="text-red- me-2">o</span> Gestion durable de bois-énergie <br>
                            <span class="text-red- me-2">o</span> Efficacité énergétique dans le secteur des services <br>
                            <span class="text-red- me-2">o</span> Efficacité énergétique dans le secteur des transports <br>
                            <span class="text-red- me-2">o</span> Production d’électricité au gaz naturel et aux énergies renouvelables <br>
                            <span class="text-red- me-2">o</span> Réduction des pertes en transport et distribution d’électricité <br>
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-white- h-100 box-shadow- py-4 px-4">
                        <h4 class="text-black text-center text-4 lh-lg ">
                            Déchets
                        </h4>
                        <p class="text-5 lh-lg">
                            <span class="text-red- me-2">o</span> Mise en place d'une installation pour la valorisation énergetique de la decharge des ordures ménagères.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-white- h-100 box-shadow- py-4 px-4">
                        <h4 class="text-black text-center text-4 lh-lg ">
                            Utilisation des Terres, Changement d’Affectation des Terres et Foresterie
                        </h4>
                        <p class="text-5 lh-lg">
                            <span class="text-red- me-2">o</span> Réduction de la déforestation <br>
                            <span class="text-red- me-2">o</span> Développement de l’agroforesterie
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-8 d-none col-sm-10 mt-4 mx-auto py-3">
                <h5 class="text-black mb-3 fw-700 text-center">
                    C'est quoi un réchauffement climatique ?
                </h5>
                <p class="text-justify lh-lg text-5">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sollicitudin consectetur netus dui, ultrices or lectus ac egestas. Vivamus tellus vestibulum aliquet arcu a duis. Sollicitudin consectetur netus du ultric. is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
                </p>
            </div>

            <div class="col-md-8 d-none col-sm-10 pt-3">
                <h4 class="text-black mb-3 fw-700">
                    Quelles sont ses causes ?
                </h4>
                <p class="text-justify mb-0 lh-lg text-5">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sollicitudin consectetur netus dui, ultrices or lectus ac egestas. Vivamus tellus vestibulum aliquet arcu a duis. Sollicitudin consectetur netus du ultric. is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum
                </p>
            </div>

        </div>
    </section>

@endsection
