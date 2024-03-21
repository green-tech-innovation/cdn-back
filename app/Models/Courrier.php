<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courrier extends Model
{
    use HasFactory, SoftDeletes;

    public $with = ['courrier_responses', 'entity'];

    protected $guarded = [];

    public function courrier_responses()
    {
        return $this->hasMany(CourrierResponse::class);
    }

    public function entity() {
        return $this->belongsTo(Entity::class);
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
