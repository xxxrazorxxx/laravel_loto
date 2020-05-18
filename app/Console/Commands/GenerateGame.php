<?php

namespace App\Console\Commands;

use App\Client;
use App\Core\Enum\GameStatuses;
use App\Core\GameGenerator;
use App\Game;
use Illuminate\Console\Command;

class GenerateGame extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulate a LOTO game';

    /** @var int */
    private $min_number_of_tickets = 10;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $is_game_ended = false;
        $number_of_wins = 0;

        $last_game = Game::where('status', GameStatuses::GAME_END)
            ->latest()
            ->first();

        $next_game_number = !empty($last_game) ? $last_game->game_number + 1 : 1;

        $tickets_count = Client::where('game_number', $next_game_number)->count();

        if (empty($game) && $tickets_count < $this->min_number_of_tickets) {
            $this->info('You cannot start game, because number tickets lower than ' . $this->min_number_of_tickets);
            return;
        }

        $game = new Game;
        $game->game_number = GameGenerator::getGameNumber();
        $game->numbers = '';
        $game->save();

        $game_generator = new GameGenerator($game);

        $game->bank = $game->bank_left = $game_generator->getGameBank();
        $game->tour = 1;

        while (!$is_game_ended) {
            $number = $game_generator->getNumber();

            array_push($game->number_list, $number);

            $number_of_wins = $game_generator->checkTickets($number);

            if (!empty($number_of_wins)) {
                $game->tour = $game->tour + 1;
            }

            $is_game_ended = $game_generator->isGameEnded();
        }

        $game->numbers = implode(',', $game->number_list);
        $game->status = GameStatuses::GAME_END;
        $game->save();

        $top_winners = Client::where('game_number', $game->game_number)
            ->orderByDesc('prize')
            ->limit(10)
            ->get();


        $this->info('Game number ' . $game->game_number);
        $this->info('-----------------------');
        $this->info('Top winners');
        $this->info('-----------------------');
        foreach ($top_winners as $winner) {
            $this->info($winner->name . ' ' . $winner->surname . ' ' . $winner->prize);
        }

        return null;
    }
}
