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
use Discordle\Service\GameService;
use Discordle\Service\PDODiscordUserService;
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

$app->get("/enum", function (Request $request, Response $response, $args) {
    $users = new DiscordUserService();
    $correctUser = $users->users[1];

    $region1 = Region::NA;

    return $response;
});


/**
 * Steps
 *  1. Fetch current game
 *  2. accept current guess ?
 *  3. generate comparison object
 *  4. update game state (in db too)
 *  5. render compairson object
 */

$app->get("/data", function (Request $request, Response $response, $args) {
    $connect = "pgsql:host=localhost;port=5455;dbname=patrick;user=patrick;password=mysecretpassword";
    $pdo = new \PDO($connect, null, null, array(
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
    ));
    $users = new PDODiscordUserService($pdo);
    $games = new GameService($pdo, $users);


    echo "<pre>";
    // foreach($service->pdo->query('SELECT * from discord_users') as $row) {
    //     print_r($row);
    // }

    $game = $games->fetchById(1);
    $comparison = $game->guess($users->fetch(2));
    print_r($comparison);
    echo '<br/><br/>Game';
    
    print_r($game);
    echo "</pre>";
    
    $view = new PhpRenderer('templates');
    $view->setLayout('layout.php');
    return $view->render($response, "results.php", ["title" => "Discordle", "comparison" => $comparison]);
});

$app->group('/user', function ($group) {
    $group->get("/create", function (Request $request, Response $response, $args) {
        $view = new PhpRenderer('templates');
        $view->setLayout('layout.php');
        return $view->render($response, "create.php", ["title" => "Discordle"]);
    });

    $group->post("/submit", function (Request $request, Response $response, $args) {
        // Fuck me, need a container
        $connect = "pgsql:host=localhost;port=5455;dbname=patrick;user=patrick;password=mysecretpassword";
        $pdo = new \PDO($connect, null, null, array(
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ));
        $users = new PDODiscordUserService($pdo);

        $data = $request->getParsedBody();
        $data['id'] = -1; // TODO: Very annoying and bad
        $user = DiscordUser::fromArray($data);
        echo '<pre>';
        print_r($user);
        $id = $users->insert($user);
        echo 'inserted ID: ';
        print_r($id); 
        echo '</pre>';
        return $response;
    });
});




$app->run();