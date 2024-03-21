<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use HasFactory, SoftDeletes;

    public $with = ["entity"];

    protected $guarded = [];

    // public function event()
    // {
    //     return $this->belongsTo(Event::class);
    // }

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }
}
