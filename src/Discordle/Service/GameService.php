<?php

namespace Discordle\Service;

use Discordle\Model\DiscordUser;
use Discordle\Model\Game;

class GameService {

    private string $table = 'games';

    private $pdo;
    private PDODiscordUserService $users;

    public function __construct($pdo, $users) {
        $this->pdo = $pdo;
        $this->users = $users;
    }

    public function fetchAll(): array {
        return $this->pdo->query('SELECT * FROM ' . $this->table)->fetchAll();
    }

    public function fetchById(int $id): Game {
        $query = $this->pdo->query('SELECT * FROM '. $this->table .' WHERE id = ' . $id);
        $res = $query->fetchAll()[0];
        $correct = $this->users->fetch($res['correct_user_id']);
        return new Game(
            $correct,
            $res['game_date'],
            $res['correct_guesses'],
            $res['total_guesses'],
            $res['enabled']
        );
    }

}