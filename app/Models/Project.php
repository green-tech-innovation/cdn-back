<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    public $with = ["entity", "project_patners", "organe", "activities"];

    protected $guarded = [];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function organe()
    {
        return $this->belongsTo(Organe::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function project_patners()
    {
        return $this->hasMany(ProjectPartner::class);
    }
}
