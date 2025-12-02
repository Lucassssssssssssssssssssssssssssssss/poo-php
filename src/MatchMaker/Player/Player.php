<?php

declare(strict_types=1);

namespace App\MatchMaker\Player;

class Player extends AbstractPlayer implements PlayerInterface
{
    protected function probabilityAgainst(AbstractPlayer $player): float
    {
        return 1 / (1 + (10 ** (($player->getRatio() - $this->getRatio()) / 400)));
    }

    public function updateRatioAgainst(AbstractPlayer $player, int $result)
    {
        $this->ratio += 32 * ($result - $this->probabilityAgainst($player));
    }
}