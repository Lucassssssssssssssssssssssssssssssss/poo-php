<?php

declare(strict_types=1);

namespace App\MatchMaker\Player;

class QueuingPlayer implements QueuingPlayerInterface
{
    /** @var PlayerInterface */
    private $player;

    /** @var int */
    private $range = 1;

    public function __construct(PlayerInterface $player, $range = 1)
    {
        $this->player = $player;
        $this->range = (int) $range;
    }

    public function getName(): string
    {
        return $this->player->getName();
    }

    public function getRatio(): float
    {
        return $this->player->getRatio();
    }

    public function updateRatioAgainst(AbstractPlayer $opponent, int $result)
    {
        $this->player->updateRatioAgainst($opponent, $result);
    }

    public function getRange(): int
    {
        return $this->range;
    }

    public function upgradeRange()
    {
        $this->range = min($this->range + 1, 40);
    }
}
