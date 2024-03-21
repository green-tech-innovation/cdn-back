<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\AnnualReport;
use App\Models\Entity;
use App\Models\Gallery;

class MainController extends Controller
{
    public function index() {
        $title = "";
        $description = "";
        $patners = Entity::where('type', "PATNER")->get();
        $gallerys = Gallery::where('is_public', 1)->take(4)->get();
        $number_reports = Activity::where('approved', 1)->where('report_public', 1)->count();
        return view("pages.index", compact("title", "description", "gallerys", "patners", "number_reports"));
    }

    public function about() {
        $title = "À propos de nous";
        $description = "";
        return view("pages.about", compact("title", "description"));
    }

    public function gallerys() {
        $title = "Galérie";
        $description = "";
        $gallerys = Gallery::where('is_public', 1)->paginate(12);
        return view("pages.gallerys", compact("title", "description", "gallerys"));
    }

    public function gallery($id) {
        $gallery = Gallery::where('is_public', 1)->where('id', $id)->first();
        if ($gallery) {
            $title = "Album ".$gallery->name;
            $description = "";
            return view("pages.gallery", compact("title", "description", "gallery"));
        }
    }

    public function annual_reports() {
        $title = "Rapports annuels";
        $description = "";
        $annual_reports = AnnualReport::paginate(12);
        return view("pages.annual-reports", compact("title", "description", "annual_reports"));
    }

    public function reports() {
        $title = "Rapports des activités";
        $description = "";
        $activities = Activity::where('approved', 1)->where('report_public', 1)->paginate(12);
        return view("pages.reports", compact("title", "description", "activities"));
    }


}
