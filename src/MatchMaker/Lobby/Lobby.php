<?php

declare(strict_types=1);

namespace App\MatchMaker\Lobby;

use App\MatchMaker\Player\PlayerInterface;
use App\MatchMaker\Player\QueuingPlayerInterface;
use App\MatchMaker\Player\QueuingPlayer;

class Lobby implements LobbyInterface
{
    /** @var QueuingPlayerInterface[] */
    public $queuingPlayers = [];

    public function findOponents(QueuingPlayerInterface $player): array
    {
        $minLevel = round($player->getRatio() / 100);
        $maxLevel = $minLevel + $player->getRange();

        return array_filter(
            $this->queuingPlayers,
            static function (QueuingPlayerInterface $potentialOponent) use ($minLevel, $maxLevel, $player) {
                $playerLevel = round($potentialOponent->getRatio() / 100);

                return $player !== $potentialOponent
                    && ($minLevel <= $playerLevel)
                    && ($playerLevel <= $maxLevel);
            }
        );
    }

    public function addPlayer(PlayerInterface $player)
    {
        $this->queuingPlayers[] = new QueuingPlayer($player);
    }

    public function addPlayers(PlayerInterface ...$players)
    {
        foreach ($players as $player) {
            $this->addPlayer($player);
        }
    }
}
