<?php


namespace App\Core;


use App\Client;
use App\Game;

/**
 * Class TicketChecker
 *
 * @package App\Core
 */
class TicketChecker
{
    /** @var Game */
    private $game;

    /** @var array */
    private $tickets;

    /** @var int */
    private $number;

    /**
     * TicketChecker constructor.
     *
     * @param Game   $game    Game instance
     * @param int    $number  Number
     */
    public function __construct(Game $game, $number)
    {
        $this->game = $game;
        $this->number = $number;

        $this->tickets = Client::where('game_number', $game->game_number)
            ->where('prize', 0)
            ->get();
    }

    /**
     * Checks rows for win
     *
     * @return array<Client>
     */
    public function checkRows()
    {
        $winner_tickets_list = [];

        /** @var Client $ticket */
        foreach ($this->tickets as $ticket) {
            $check_win = false;
            $ticket_rows_numbers = [];
            $ticket_data = $ticket->getTicketData();

            foreach ($ticket_data->fields as $rows) {
                foreach ($rows as $row) {
                    foreach ($row as $number) {
                        $ticket_rows_numbers[] = $number;
                    }

                    if ($check_win = $this->checkWin($ticket_rows_numbers)) {
                        break;
                    }
                }

                if ($check_win) {
                    break;
                }
            }

            if ($check_win) {
                $winner_tickets_list[] = $ticket;
            }
        }

        return $winner_tickets_list;
    }

    /**
     * Checks fields for win
     *
     * @return array<Client>
     */
    public function checkFields()
    {
        $winner_tickets_list = [];
        foreach ($this->tickets as $ticket) {
            $check_win = false;
            $ticket_fields_numbers = [];
            $ticket_data = $ticket->getTicketData();

            foreach ($ticket_data->fields as $rows) {
                foreach ($rows as $row) {
                    foreach ($row as $number) {
                        $ticket_fields_numbers[] = $number;
                    }
                }

                if ($check_win = $this->checkWin($ticket_fields_numbers)) {
                    break;
                }
            }

            if ($check_win) {
                $winner_tickets_list[] = $ticket;
            }
        }

        return $winner_tickets_list;
    }

    /**
     * Checks tickets for win
     *
     * @return array<Client>
     */
    public function checkTickets()
    {
        $winner_tickets_list = [];
        foreach ($this->tickets as $ticket) {
            $ticket_numbers = [];
            $ticket_data = $ticket->getTicketData();

            foreach ($ticket_data->fields as $rows) {
                foreach ($rows as $row) {
                    foreach ($row as $number) {
                        $ticket_numbers[] = $number;
                    }
                }
            }

            if ($this->checkWin($ticket_numbers)) {
                $winner_tickets_list[] = $ticket;
            }
        }

        return $winner_tickets_list;
    }

    /**
     * Check if the combination is winner
     *
     * @param array $numbers Numbers of the ticket
     *
     * @return bool
     */
    private function checkWin($numbers)
    {
        $number_intersection = array_intersect($numbers, $this->game->number_list);
        return count($number_intersection) === count($numbers);
    }
}
