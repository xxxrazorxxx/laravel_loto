<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ticket_data', 'prize', 'ticket_hash', 'name', 'surname'
    ];

    /**
     * Gets decoded ticket data
     *
     * @return array
     */
    public function getTicketData()
    {
        return json_decode($this->ticket_data);
    }
}
