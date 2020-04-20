<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'game_numbers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'game_id'
    ];
}
