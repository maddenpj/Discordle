<?php

namespace Discordle\Service;

use Discordle\Model\DiscordUser;
use Discordle\Model\LoLRank;
use Discordle\Model\Region;
use Discordle\Model\Gender;
use Discordle\Model\NameColor;

class DiscordUserService {

    public array $users;

    public function __construct() {
        $this->users = [
            1 => new DiscordUser(1, "Frezzyisfuzzy", LoLRank::PLATINUM, 81, Region::NA, 31, Gender::MALE, NameColor::RANDOM),
            2 => new DiscordUser(2, "Scarledt", LoLRank::MASTER, 76, Region::EU, 27, Gender::FEMALE, NameColor::YELLOW),
            3 => new DiscordUser(3, "PsychoticOwl", LoLRank::PLATINUM, 102, Region::NA, 25, Gender::MALE, NameColor::GRAY),
            4 => new DiscordUser(4, "Baycon", LoLRank::DIAMOND, 96, Region::NA, 23, Gender::MALE, NameColor::BLUE)
        ];
    }

}