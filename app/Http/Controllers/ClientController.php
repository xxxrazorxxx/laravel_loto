<?php

namespace App\Http\Controllers;

use App\Client;
use App\Core\TicketGenerator\TicketGenerator;
use App\Core\Randomizer;

class ClientController extends Controller
{
    /**
     * Registrates new client
     */
    public function registrate()
    {
        $game_number = GameController::getGameNumber();

        $is_ticket_generated = false;
        $ticket_data = [];
        $ticket_hash = '';

        while(!$is_ticket_generated) {
            $ticket_data = $this->generateTicketData();
            $ticket_hash = md5(serialize($ticket_data));
            $same_ticket = Client::where('ticket_hash', $ticket_hash)
                ->where('game_number', $game_number)
                ->first();

            if (empty($same_ticket)) {
                $is_ticket_generated = true;
            }
        }

        $client = new Client;
        $client->game_number = $game_number;

        $client->ticket_data = json_encode($ticket_data);
        $client->ticket_hash = $ticket_hash;

        $randomizer = new Randomizer();
        $client->name = $randomizer->getRandomString();
        $client->surname = $randomizer->getRandomString();

        $client->save();

        $data = [
            'client_number' => $client->id,
            'game_number'   => $client->game_number,
            'ticket_data'   => $ticket_data,
            'name'          => $client->name,
            'surname'       => $client->surname
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
