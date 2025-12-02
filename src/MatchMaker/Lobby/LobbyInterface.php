<?php

declare(strict_types=1);

namespace App\MatchMaker\Lobby;

use App\MatchMaker\Player\PlayerInterface;
use App\MatchMaker\Player\QueuingPlayerInterface;

interface LobbyInterface
{
    public function findOponents(QueuingPlayerInterface $player): array;
    public function addPlayer(PlayerInterface $player);
    public function addPlayers(PlayerInterface ...$players);
}
