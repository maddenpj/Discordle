<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;
use Discordle\Model\DiscordUser;
use Discordle\Model\Comparison;
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
    $correctUser = $users->users[1];
    $guessUser = $users->users[2];

    // print_r($users->users[1]);
    // print_r($guessUser);

    
    $response->getBody()->write("</pre>");
    $response->getBody()->write("<br/>Hidden answer is " . $correctUser->username);
    $response->getBody()->write("<br/>Your guess was " . $guessUser->username);
    $response->getBody()->write("<pre>");

    //$rankStatement = ($correctUser->rank->value > $guessUser->rank->value) ? $correctUser->username : $guessUser->username;
    $rankStatement = print_r(new Comparison($correctUser, $guessUser));

    $response->getBody()->write(" </pre>");

    return $response;
});

$app->get("/view", function (Request $request, Response $response, $args) {
    $users = new DiscordUserService();
    $correctUser = $users->users[1];
    $guessUser = $users->users[2];
    $comparison = new Comparison($correctUser, $guessUser);


    $view = new PhpRenderer('templates');
    $view->setLayout('layout.php');
    return $view->render($response, "results.php", ["title" => "Discordle", "comparison" => $comparison]);
});

$app->run();