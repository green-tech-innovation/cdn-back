<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    // public $with = ["sub_activities"];

    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function sub_activities()
    {
        return $this->hasMany(SubActivity::class);
    }


    protected $casts = [
        'date_approved' => 'date:Y-m-d',
    ];
}
