<?php

namespace App\Http\Controllers;

use App\Core\Enum\GameStatuses;
use App\Core\GameGenerator;
use App\Game;
use App\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    /**
     * Gets the number of the next game tour
     *
     * @return int
     */
    public static function getGameTour()
    {
        $last_id = Game::latest()->first();

        if (empty($last_id)) {
            $last_id = 0;
        }

        return $last_id + 1;
    }

    /**
     * Starts the game
     *
     * @throws \Exception
     */
    public function startGame()
    {
        $game = Game::where('status', GameStatuses::GAME_IN_PROGRESS)
            ->latest()
            ->first();

        if (empty($game)) {
            $game = new Game;
            $game->create();
        }

        $game_generator = new GameGenerator($game);

        if (empty($game->bank)) {
            $game->bank = $game_generator->getGameBank();
            $game->save();
        }

        $number = Number::create([
            'number'  => $game_generator->getNumber(),
            'game_id' => $game->id,
        ]);

        $is_game_ended = $game_generator->isGameEnded();
        $number_of_wins = $game_generator->checkTickets($number->number);

        if ($is_game_ended) {
            $game->status = GameStatuses::GAME_END;
            $game->save();
        }

        $data = [
            'game_tour'       => $game->id,
            'number'          => $number->number,
            'numbers_in_game' => $game_generator->getNumbersInGame(),
            'is_game_ended'   => $game_generator->isGameEnded(),
            'bank'            => $game->bank,
        ];

        return view('game', $data);
    }
}
