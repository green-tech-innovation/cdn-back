<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    public $with = ["participants"];

    protected $guarded = [];

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
}
