<?php


namespace App\Core;


use App\Client;
use App\Game;

class GameGenerator
{
    /** @var int $min_number - minimal number */
    private $min_number = 1;

    /** @var int $max_number - maximal number */
    private $max_number = 89;

    /** @var Game $game - Game instance */
    private $game;

    /** @var int $coins_per_ticket */
    private $coins_per_ticket = 100;

    /**
     * GameGenerator constructor.
     *
     * @param Game $game
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    /**
     * Gets next number in the game
     *
     * @return int
     * @throws \Exception
     */
    public function getNumber()
    {
        $numbers_in_game = $this->getNumbersInGame();

        $number = null;

        while (!$number) {
            $int = random_int($this->min_number, $this->max_number);
            if (in_array($int, $numbers_in_game)) {
                continue;
            }
            $number = $int;
        }

        return $number;
    }

    /**
     * Gets all numbers which are already in the game
     *
     * @return array
     */
    public function getNumbersInGame()
    {
        $numbers_in_game = [];
        $numbers_list = $this->game->numbers;

        foreach ($numbers_list as $number_data) {
            $numbers_in_game[] = $number_data->number;
        }

        return $numbers_in_game;
    }

    /**
     * Checks if the game was ended
     *
     * @return bool
     */
    public function isGameEnded()
    {
        return count($this->getNumbersInGame()) == $this->max_number;
    }

    /**
     * Checks the winner tickets
     *
     * @param int $number current number
     *
     * @return int
     */
    public function checkTickets($number)
    {
        $tickets = $this->game->tickets;

    }

    /**
     * Gets game bank
     *
     * @return int
     */
    public function getGameBank()
    {
        $tickets = Client::where('game_id', $this->game->id)
            ->get();

        return $this->coins_per_ticket * count($tickets);
    }
}
