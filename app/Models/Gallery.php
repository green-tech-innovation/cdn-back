<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    public $with = ['gallery_files', 'entity'];

    protected $guarded = [];

    public function gallery_files()
    {
        return $this->hasMany(GalleryFile::class);
    }

    public function entity()
    {
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
