<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormularQuiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public $with = ["formular_responses"];

    public function formular_responses() {
        return $this->hasMany(FormularResponse::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
    ];
}
