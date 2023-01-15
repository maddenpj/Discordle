<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;
use DI\Container;
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

$container = new Container([
    'config' => [
        'sql.connection' => 'pgsql:host=localhost;port=5455;dbname=patrick;user=patrick;password=mysecretpassword'
    ],
    \PDO::class => function (Container $c) {
        return new \PDO($c->get('config')['sql.connection'], null, null, array(
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ));
    },
    'users' => function (Container $c) {
        return new PDODiscordUserService($c->get(\PDO::class));
    },
    'games' => function (Container $c) {
        return new GameService($c->get(\PDO::class), $c->get('users'));
    },
    'view' => function (Container $c) {
        $view = new PhpRenderer('templates');
        $view->setLayout('layout.php');
        return $view;
    }
]);


AppFactory::setContainer($container);
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


    return $this->get('view')->render($response, "results.php", ["title" => "Discordle", "comparison" => $comparison]);
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
    $users = $this->get('users');
    $games = $this->get('games');

    echo "<pre>";
    
    $qs = $request->getQueryParams();
    $gameNumber = (isset($qs['g'])) ? (int)$qs['g'] : 2;
    
    $game = $games->fetchById(1);
    // TODO ->guess should update the counts?
    $comparison = $game->guess($users->fetch($gameNumber));
    
    // print_r($comparison);
    // echo '<br/><br/>Game';
    
    // print_r($game);
    echo "</pre>";

    return $this->get('view')->render($response, "results.php", ["title" => "Discordle", "comparison" => $comparison]);
});

$app->group('/user', function ($group) {
    $group->get("/create", function (Request $request, Response $response, $args) {
        return $this->get('view')->render($response, "create.php", ["title" => "Discordle"]);
    });

    $group->post("/submit", function (Request $request, Response $response, $args) {
        $users = $this->get('users');

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