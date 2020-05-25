<?php


namespace Models;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $fillable = [
        'name',
        'email',
        'password',
    ];

    public function jobs()
    {
        return $this->hasOne('Job');
    }

    public function ideas()
    {
        return $this->belongsToMany('Idea');
    }
}
