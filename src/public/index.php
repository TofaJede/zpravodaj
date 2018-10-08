<?php
/**
 * Created by PhpStorm.
 * User: krystofkosut
 * Date: 02.08.18
 * Time: 3:35
 */

// I am using Slim Framework v3
// https://www.slimframework.com/docs/
use Psr\Http\Message\ServerRequestInterface as Request; // What it really is?
use Psr\Http\Message\ResponseInterface as Response; // What it really is?
// Load Slim v3 stuff
require '../vendor/autoload.php';

// after adding stuff - own classes; run composer update

// TODO: Error loger, visit: https://akrabat.com/logging-errors-in-slim-3/
// Or use monolog as recommended?

// TODO: Setup configs (database, logs, showing errors, ...)
// https://www.slimframework.com/docs/v3/tutorial/first-app.html

// TODO: This is API, right? Visit: https://www.phpflow.com/php/create-simple-rest-api-using-slim-flamework/

// TODO: How to keep Database updated?
// TODO: How to add external libs? -- vendor autoloader

// Lets make a database connection
// This needs to stay without arguments!
/**
 * PDO DATABASE CONNECTION
 * @return PDO
 */
function getConnection(){
    $config = getConfig();
    $mode   = $config['mode']();
    $info   = $config['database'][$mode];
    // Bad encoding from DB? Change it below!
    $dsn = "mysql:host={$info['host']};dbname={$info['database']};charset=utf8mb4";
    $db = new PDO($dsn, $info['user'], $info['password']);
    // What this actually means?
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
    // TODO: Is there any better option than PDO?
}
// Configuration file, can be used on many thinks, watch it out!
function getConfig(){
    return require 'config.php';
}
// To determinate which namespace am I using, you will see later in this code...
/**
 * @param bool $admin Do I neeed admin as arg? (if yes make it false)
 * @return mixed
 */
function getController($admin = false){
    $config = getConfig();
    $mode   = $config['mode']();
    $url = \App\core::requestURL($config['dir'][$mode]);
    if ($admin){
        $n = 1;
    } else {
        $n = 0;
    }
    return $url[$n];
}

// Show errors?
// Here is problem, I need to have right permissions on "log" folder - 755 Doesnt work, but 777 does - I dont want to use 777...
// TODO: Do I really need 777 permissions on "log" folder?
$config = getConfig();
$mode   = $config['mode']();
if($mode != 'production'){
    $configuration['displayErrorDetails'] = true;
} else {
    $configuration['displayErrorDetails'] = false;
}

// Start the app with configuration Ive set
$app = new \Slim\App(
 ['settings' => $configuration]
);
// If add dependency
// Example:
// $container = $app->getContainer();
// $container['Logger'] ..

// Error Handler, customized.

$c = $app->getContainer();
$c['errorHandler'] = function () { // removed $c
    return new \App\CustomHandler();
};



// Get Controller from URL project.org/CONTROLER/
$controller = getController();

// TODO: DEFAULTs
if($controller == 'admin'){
    // TODO: CODE!!!
} else {

    if($controller == ''){
        // TODO: DEFAULT
    }
    // IF REQUEST = GET or POST, I can handle both here...
    if ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){
        // https://www.slimframework.com/docs/v3/objects/router.html
        // Custom Route
        $app->map(['GET', 'POST'],"/{$controller}[/{params:.*}]", function (Request $request, Response $response, array $args) {
            $controller = getController();
            @$arguments = explode('/',$args['params']);
            $method = $arguments[0];

            $class = "\App\Controller\\$controller";

            $page = new $class();

            if(isset($arguments[1])){
                return $response->withJson($page->$method($arguments[1]), 200, JSON_UNESCAPED_UNICODE)->withHeader('Access-Control-Allow-Origin', '*');
            } else {
            // This is designed to be API, just result the JSON...
            return $response->withJson($page->$method(), 200, JSON_UNESCAPED_UNICODE)->withHeader('Access-Control-Allow-Origin', '*');
            //echo json_encode($page->$method(), JSON_UNESCAPED_UNICODE);
            }
        });
    }
}
    $app->run();
// */
/*
// TODO: Learn options/patterns for this patterin in get function... And make a docs to it
$app->get('/hello/{name}', function (Response $response, array $args){

    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});

$app->get('/', function(Request $request){
    $test = new \test();
    echo $test->getHi();
   // $response->getBody()->write("Hello World!");
   // return $response;
    echo "<pre hidden>".print_r($request, true)."</pre>";
    // This also works!
    //echo 'Hello Worlds!';
});

$app->get('/test/database', function(){
    $test = new \App\Controller\test();
    $test->testDatabase();
    // Array to string convection, this kinda sucks
    // echo "How did it go?"; // Well!
});

$app->run(); // Unhandled Exceptions??
// */