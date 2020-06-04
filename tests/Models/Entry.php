<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{
    use SoftDeletes;

    public $fillable = [
        'name',
        'details',
    ];

    public function getMetaAttribute()
    {
        return (object) [
            'user' => (object) [
                'id' => 1,
            ],
            'created_at' => \Carbon\Carbon::create(1999, 1, 1, 6, 15, 0),
            'updated_at' => \Carbon\Carbon::create(1999, 1, 1, 6, 15, 0),
            'deleted_at' => null
        ];
    }
}