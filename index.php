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
use App\MatchMaker\MessageService;
use App\MatchMaker\Exceptions\EmailSendingErrorException;
use App\MatchMaker\Exceptions\NotificationSendingErrorException;
use App\MatchMaker\Exceptions\ShortTextException;

$greg = new BlitzPlayer('greg');
$jade = new BlitzPlayer('jade');

$lobby = new Lobby();
$lobby->addPlayers($greg, $jade);

try {
    var_dump($lobby->findOponents($lobby->queuingPlayers[0]));
    MessageService::sendMessage("Salut !");
} catch (ShortTextException $e) {
    echo "Erreur : " . $e->getMessage();
} catch (EmailSendingErrorException $e) {
    echo "Erreur : " . $e->getMessage();
} catch (NotificationSendingErrorException $e) {
    echo "Erreur : " . $e->getMessage();
} catch (\Exception $e) {
    echo "Erreur inattendue : " . $e->getMessage();
}

exit(0);
