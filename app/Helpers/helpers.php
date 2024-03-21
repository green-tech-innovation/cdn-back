<?php

use App\Models\Notifiction;
use Illuminate\Support\Str;

if(!function_exists('f_page_title')) {
    function f_page_title(?string $title = null) : string{
        return $title ? $title.' > '.config("app.name") : config("app.name");
    }
}

if(!function_exists('f_page_description')) {
    function f_page_description(?string $title = null) : string{
        $description = "Collectionnez vos sous rapidement et facilement";
        return $title ? $title : $description;
    }
}

function slug($name) {
    return Str::slug($name, '-');
}


function save_notification($entity_id, $title, $message) {
    Notifiction::create([
        "entity_id" => $entity_id,
        "title" => $title,
        "content" => $message
    ]);
    return true;
}


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function generateRandomNumber($length = 6) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function stringCutter($message, $length = 50) {
    return (strlen($message) > $length) ? substr($message, 0, $length)."..." : $message;
}

