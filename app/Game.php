<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    /** @var array */
    public $number_list = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bank', 'bank_left', 'game_number', 'tour', 'numbers'
    ];

    /**
     * Get the tickets for this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany('App\Client', 'game_number', 'game_number');
    }

    /**
     * Gets array of numbers if the game
     *
     * @return array
     */
    public function getNumbers()
    {
        return empty($this->numbers) ? [] : explode(',', $this->numbers);
    }
}
