<?php

namespace Discordle\Model;

class Comparison {
    private DiscordUser $correctUser;
    private DiscordUser $guessUser;

    public string $guessedName;
    public NumberComparison $rank;
    public NumberComparison $subbedMonths;
    public bool $region;
    public NumberComparison $age;
    public bool $gender;
    public bool $color;

    public function __construct(DiscordUser $correct, DiscordUser $guess) {
        $this->correctUser = $correct;
        $this->guessUser = $guess;

        $this->guessedName = $guess->username;
        $this->rank = NumberComparison::make($correct->rank->value, $guess->rank->value);
        $this->subbedMonths = NumberComparison::make($correct->subbedMonths, $guess->subbedMonths);
        $this->region = $correct->region === $guess->region;
        $this->age = NumberComparison::make($correct->age, $guess->age);
        $this->gender = $correct->gender === $guess->gender;
        $this->color = $correct->color === $guess->color;

    }

    public function isCorrect(): bool {
        return $this->correctUser->id == $this->guessUser->id;
    }

}