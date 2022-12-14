<?php

namespace Discordle\Model;

class Game {
    private DiscordUser $correctUser;
    private $gameDate;
    private int $correctGuesses;
    private int $totalGuesses;
    private bool $enabled;

    public function __construct(DiscordUser $user, $date, int $correct, int $total, $enabled) {
        $this->correctUser = $user;
        $this->gameDate = $date;
        $this->correctGuesses = $correct;
        $this->totalGuesses = $total;
        $this->enabled = $enabled;
    }

    public function guess(DiscordUser $guess) {
        $comparison = new Comparison($this->correctUser, $guess);
        $this->totalGuesses++;
        if ($comparison->isCorrect()) {
            $this->correctGuesses++;
        }
        return $comparison;
    }

}