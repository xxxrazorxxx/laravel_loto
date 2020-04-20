<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bank'
    ];

    /**
     * Get the numbers for this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function numbers()
    {
        return $this->hasMany('App\Number', 'game_id', 'id');
    }

    /**
     * Get the tickets for this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany('App\Client', 'game_id', 'id');
    }
}
