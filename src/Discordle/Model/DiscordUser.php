<?php

namespace Discordle\Model;


class DiscordUser {
    public ?int $id;
    public string $username;
    public LoLRank $rank;
    public int $subbedMonths;
    public Region $region;
    public int $age;
    public Gender $gender;
    public NameColor $color;

    public function __construct(int $id, string $username, LoLRank $rank, int $subbedMonths, Region $region, int $age, Gender $gender, NameColor $color) {
        $this->id = $id;
        $this->username = $username;
        $this->rank = $rank;
        $this->subbedMonths = $subbedMonths;
        $this->region = $region;
        $this->age = $age;
        $this->gender = $gender;
        $this->color = $color;
    }

    public function compareTo(DiscordUser $other) {
        return $this->rank->compareTo($other->rank);
    }

    public static function fromArray(array $row): DiscordUser {
        return new DiscordUser(
            $row['id'],
            $row['username'],
            LoLRank::from($row['rank']),
            $row['subbed_months'],
            Region::from($row['region']),
            $row['age'],
            Gender::from($row['gender']),
            NameColor::from($row['name_color'])
        );
    }

}