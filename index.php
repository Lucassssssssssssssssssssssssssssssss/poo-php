<?php

declare(strict_types=1);

require_once __DIR__ . '/src/MatchMaker/Lobby/Lobby.php';
require_once __DIR__ . '/src/MatchMaker/Player/AbstractPlayer.php';
require_once __DIR__ . '/src/MatchMaker/Player/Player.php';
require_once __DIR__ . '/src/MatchMaker/Player/QueuingPlayer.php';
require_once __DIR__ . '/src/MatchMaker/Player/BlitzPlayer.php';

use App\MatchMaker\Lobby\Lobby;
use App\MatchMaker\Player\BlitzPlayer;

$greg = new BlitzPlayer('greg');
$jade = new BlitzPlayer('jade');

$lobby = new Lobby();
$lobby->addPlayers($greg, $jade);

var_dump($lobby->findOponents($lobby->queuingPlayers[0]));

exit(0);
