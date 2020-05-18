<?php


namespace App\Core;


use App\Client;
use App\Game;
use Facade\Ignition\Support\Packagist\Package;

/**
 * Class GameGenerator
 *
 * @package App\Core
 */
class GameGenerator
{
    /** @var int $min_number - minimal number */
    private $min_number = 1;

    /** @var int $max_number - maximal number */
    private $max_number = 90;

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
     * Gets the number of the next game tour
     *
     * @return int
     */
    public static function getGameNumber()
    {
        $last_game = Game::latest()->first();

        $last_tour = empty($last_game)
            ? 0
            : $last_game->game_number;

        return $last_tour + 1;
    }

    /**
     * Gets next number in the game
     *
     * @return int
     */
    public function getNumber()
    {
        $numbers_in_game = $this->game->getNumbers();

        $number = null;

        while (!$number) {
            $int = rand($this->min_number, $this->max_number);
            if (in_array($int, $numbers_in_game)) {
                continue;
            }
            $number = $int;
        }

        return $number;
    }

    /**
     * Checks if the game was ended
     *
     * @return bool
     */
    public function isGameEnded()
    {
        return count($this->game->number_list) == $this->max_number;
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
        $winner_tickets = null;
        $prize = floor($this->game->bank_left / 2);

        $ticket_checker = new TicketChecker($this->game, $number);

        if ($this->game->tour === 1) {
            $winner_tickets = $ticket_checker->checkRows();
        } elseif ($this->game->tour === 2) {
            $winner_tickets = $ticket_checker->checkFields();
        } else {
            $winner_tickets = $ticket_checker->checkTickets();
        }

        if (empty($winner_tickets)) {
            return 0;
        }

        /** @var Client $ticket $ticket */
        foreach ($winner_tickets as $ticket) {
            $ticket->prize = floor($prize / count($winner_tickets));
            $ticket->save();
            $this->game->bank_left = $this->game->bank_left - $ticket->prize;
        }

        $this->game->save();

        return count($winner_tickets);
    }

    /**
     * Gets game bank
     *
     * @return int
     */
    public function getGameBank()
    {
        $tickets = Client::where('game_number', $this->game->game_number)
            ->get();

        return $this->coins_per_ticket * count($tickets);
    }
}
