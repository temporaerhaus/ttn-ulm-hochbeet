<?php
require __DIR__ . '/vendor/autoload.php';
use TTNUlm\API;

$router = new AltoRouter();
$api = new API();

$router->map('GET', '/', function() use ($api) {
    echo 'root';
});

//**********
// Distance
//**********
$router->map('GET', '/data/[i:id]/?', function($id) use ($api) {
    $from = $_GET['from'];
    $to = $_GET['to'];
    $api->returnData($id, $from, $to);
});


// get matches
$match = $router->match();

// call closure or throw 404 status
if( is_array($match) && is_callable( $match['target'] ) ) {
    call_user_func_array( $match['target'], $match['params'] );
} else {
	// no route was matched
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}
