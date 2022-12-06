<?php

namespace Discordle\Service;

use Discordle\Model\DiscordUser;
use Discordle\Model\LoLRank;
use Discordle\Model\Region;
use Discordle\Model\Gender;
use Discordle\Model\NameColor;

class PDODiscordUserService {

    private $connect = "pgsql:host=localhost;port=5455;dbname=patrick;user=patrick;password=mysecretpassword";
    public $pdo;

    public function __construct() {
        $this->pdo = new \PDO($this->connect, null, null, array(
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ));
    }

}