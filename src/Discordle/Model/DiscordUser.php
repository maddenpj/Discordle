<?php

namespace Discordle\Model;


class DiscordUser {
    public ?int $id;
    public string $username;
    public LoLRank $rank;
    public int $subbedMonths;
    public Region $region;
    public int $age;
    public NameColor $color;

    public function __construct(int $id, string $username, LoLRank $rank, int $subbedMonths, Region $region, int $age, NameColor $color) {
        $this->id = $id;
        $this->username = $username;
        $this->rank = $rank;
        $this->subbedMonths = $subbedMonths;
        $this->region = $region;
        $this->age = $age;
        $this->color = $color;
    }


}