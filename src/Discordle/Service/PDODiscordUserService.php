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

}