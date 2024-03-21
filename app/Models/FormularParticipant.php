<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormularParticipant extends Model
{
    use HasFactory, SoftDeletes;

    public $guarded = [];

    public $with = ['entity'];

    public function entity() {
        return $this->belongsTo(Entity::class);
    }
}
