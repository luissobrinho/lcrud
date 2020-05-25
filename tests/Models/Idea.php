<?php


namespace Models;


use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    public $fillable = [
        'name',
    ];

    public function user()
    {
        return $this->hasOne('User');
    }
}