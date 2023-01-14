<?php

namespace Discordle\Service;

use Discordle\Model\DiscordUser;
use Discordle\Model\LoLRank;
use Discordle\Model\Region;
use Discordle\Model\Gender;
use Discordle\Model\NameColor;

class PDODiscordUserService {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function fetchAll(): array {
        return $this->pdo->query('SELECT * FROM discord_users')->fetchAll();
    }

    public function fetch(int $id): DiscordUser {
        // echo 'SELECT * FROM discord_users WHERE id = ' . $id;
        $query = $this->pdo->query('SELECT * FROM discord_users WHERE id = ' . $id);
        return DiscordUser::fromArray($query->fetchAll()[0]);
    }

    public function insert(DiscordUser $user) {
        $sql = <<<SQL
        INSERT INTO discord_users (username, rank, subbed_months, region, age, gender, name_color)
        VALUES (:username, :rank, :subbedMonths, :region, :age, :gender, :nameColor)
        RETURNING id
SQL;
        $st = $this->pdo->prepare($sql);
        $st->bindValue(':username', $user->username);
        $st->bindValue(':rank', $user->rank->value);
        $st->bindValue(':subbedMonths', $user->subbedMonths);
        $st->bindValue(':region', $user->region->value);
        $st->bindValue(':age', $user->age);
        $st->bindValue(':gender', $user->gender->value);
        $st->bindValue(':nameColor', $user->color->value);

        if ($st->execute()) {
            return $this->pdo->lastInsertId();
        }
    }

}