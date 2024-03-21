<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formular extends Model
{
    use HasFactory, SoftDeletes;

    public $guarded = [];

    public $with = ['formular_quizzes', 'formular_participants'];

    public function formular_quizzes()
    {
        return $this->hasMany(FormularQuiz::class);
    }

    public function formular_participants()
    {
        return $this->hasMany(FormularParticipant::class);
    }
}
