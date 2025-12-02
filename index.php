<?php

declare(strict_types=1);

spl_autoload_register(function (string $fqcn) {
    $path = __DIR__ . '/src/' . str_replace('App\\', '', $fqcn) . '.php';
    $path = str_replace('\\', '/', $path);

    if (file_exists($path)) {
        require_once $path;
    }
});

use App\MatchMaker\Lobby\Lobby;
use App\MatchMaker\Player\BlitzPlayer;

$greg = new BlitzPlayer('greg');
$jade = new BlitzPlayer('jade');

$lobby = new Lobby();
$lobby->addPlayers($greg, $jade);

var_dump($lobby->findOponents($lobby->queuingPlayers[0]));

exit(0);
