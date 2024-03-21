<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ f_page_title($title ?? null) }}</title>

        <meta name="description" content="{{ f_page_description($description ?? null) }}">

        <!--==================== UNICONS ====================-->
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

        <!--==================== ALPINEJS ====================-->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!--=============== BOOTSTRAP ===============-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

        @vite('resources/css/app.css')
    </head>
    <body>

        <nav>
            <div class="d-none d-md-block">
                <div class="col-lg-11 col-md-12 mx-auto">
                    <div class="hstack py-1">
                        <a href="{{ route('index') }}">
                            <img src="{{ asset('assets/images/logo_cadrevie.png') }}" class="logo" alt="">
                        </a>
                        <div class="ms-auto hstack">
                            <a href="{{ route('index') }}" class="nav-link-desktop text-5">Accueil</a>
                            <a href="{{ route('annual_reports') }}" class="nav-link-desktop text-5">Rapport annuel</a>
                            <a href="{{ route('reports') }}" class="nav-link-desktop text-5">Rapport</a>
                            <a href="{{ route('gallerys') }}" class="nav-link-desktop text-5">Galerie</a>
                            <a href="{{ route('about') }}" class="nav-link-desktop text-5">À propos</a>
                        </div>
                        <div class="ms-auto hstack">
                            <a href="https://ndcpartnership.org/" target="_blank">
                                <img src="{{ asset('assets/images/ndc.png') }}"  class="logondc" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-md-none d-block">
                <div class="hstack px-2">
                    <img src="{{ asset('assets/images/logo_mesrs.png') }}" class="logo" alt="">

                    <i class="uil uil-bars ms-auto p-1 fs-2 text-primary-" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"></i>
                </div>
            </div>

            <div class="offcanvas offcanvas-end bg-primary-" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="hstack p-3">
                    <i class="uil uil-times-circle ms-auto me-2 text-white fs-2" data-bs-dismiss="offcanvas" type="button" aria-label="Close"></i>
                </div>
                <div class="offcanvas-body">
                    <h5 class="text-center lh-lg fw-1000 text-white text-5">
                        {{ env("APP_NAME") }}
                    </h5>
                    <hr class="mb-0 bg-yellow-">
                    <div class="vstack">
                        <a href="{{ route('index') }}" class="nav-link-mobile text-5">Accueil</a>
                        <a href="{{ route('annual_reports') }}" class="nav-link-mobile text-5">Rapport annuel</a>
                        <a href="{{ route('reports') }}" class="nav-link-mobile text-5">Rapport</a>
                        <a href="{{ route('gallerys') }}" class="nav-link-mobile text-5">Galerie</a>
                        <a href="{{ route('about') }}" class="nav-link-mobile text-5 pb-3">À propos</a>
                    </div>
                    <hr class="mb-0 bg-yellow-">
                    <div>
                        <div class="hstacktext-center">
                            <dl>
                                <dt class="text-5 text-center text-white pt-4"><i class="uil uil-phone text-center text-white fs-5 me-2"></i></dt>
                                <dd class="text-6 text-center text-white">+229 60 00 00 00</dd>
                            </dl>
                        </div>
                        <div class="hstacktext-center">
                            <dl>
                                <dt class="text-5 text-center text-white"><i class="uil uil-envelope text-center text-white fs-5 me-2"></i></dt>
                                <dd class="text-6 text-center text-white">cdn@gmail.com</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>


        </nav>



        @yield("content")

        <footer class="py-4 text-5 bg-second- text-uppercase text-center">
             <div class="containe">
                <div class="row">
                    <div class="col-sm-6 text-white-">
                       Copyright ©  {{ date('Y') }} {{ env("APP_NAME") }}
                    </div>
                    <div class="col-sm-6 text-md-end mt-4 mt-sm-0 hstack">
                        <a href="tel:+229 60 00 00 00" target="_blank" rel="noopener noreferrer">
                            <dd class="text-6 text-white"><i class="uil uil-phone text-white fs-5 me-2"></i> +229 60 00 00 00</dd>
                        </a>
                        <a href="mailto:cdn@gmail.com" class="ms-5" target="_blank" rel="noopener noreferrer">
                            <dd class="text-6 text-white"><i class="uil uil-envelope text-white fs-5 me-2"></i> cdn@gmail.com</dd>
                        </a>
                    </div>
                </div>
             </div>
        </footer>


        @vite('resources/js/app.js')

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

        <script src="{{ asset('assets/js/script.js') }}"></script>
    </body>
</html>

