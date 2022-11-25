<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Discordle\Model\DiscordUser;
use Discordle\Model\LoLRank;
use Discordle\Model\Region;
use Discordle\Model\Gender;
use Discordle\Model\NameColor;


require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) {
    echo "<pre>";

    $user = new DiscordUser(
        1, "name", LoLRank::IRON, 1, Region::NA, 33, NameColor::BLUE
    );

    var_dump($user);
    $response->getBody()->write("</pre>");
    $response->getBody()->write("<br/>Hello");
    return $response;
});

$app->run();