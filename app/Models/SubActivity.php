<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubActivity extends Model
{
    use HasFactory, SoftDeletes;


    protected $guarded = [];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

}
