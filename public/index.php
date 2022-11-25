<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Discordle\Model\DiscordUser;
use Discordle\Model\LoLRank;
use Discordle\Model\Region;
use Discordle\Model\Gender;
use Discordle\Model\NameColor;
use Discordle\Service\DiscordUserService;


require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) {
    echo "<pre>";

    $users = new DiscordUserService();
    var_dump($users->users[1]);
    $response->getBody()->write("</pre>");
    $response->getBody()->write("<br/>Hello");
    return $response;
});

$app->run();