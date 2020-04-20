<?php

namespace App\Http\Controllers;

use App\Client;
use App\Core\TicketGenerator\TicketGenerator;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Registrates new client
     */
    public function registrate()
    {
        $game_tour = GameController::getGameTour();
        $ticket_data = $this->generateTicketData();

        $client = new Client;
        $client->game_id = $game_tour;

        $client->ticket_data = json_encode($ticket_data);
        $client->save();

        $data = [
            'client_number' => $client->id,
            'game_id'       => $client->game_id,
            'ticket_data'   => $ticket_data,
        ];

        return view('client', $data);
    }

    /**
     * Checks result of the game
     *
     * @param int $client_number
     */
    public function checkResult($client_number)
    {
        echo $client_number;
    }

    /**
     * Generates ticket numbers
     *
     * @return array
     */
    private function generateTicketData()
    {
        $ticket_generator = new TicketGenerator();
        return $ticket_generator->generateTicket();
    }
}
