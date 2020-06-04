<?php


namespace Models;


use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public $fillable = [
        'name',
        'user_id',
    ];

    public function user()
    {
        return $this->hasOne('User');
    }

    public function custom($params)
    {
        return $this->where('name', 'LIKE', "%$params[0]%")->get();
    }
}