<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyItem extends Model
{
    use HasFactory, SoftDeletes;

    public $guarded = [];

    public $with = ['survey_votes'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function survey_votes()
    {
        return $this->hasMany(SurveyVote::class);
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
