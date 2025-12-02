<?php

declare(strict_types=1);

namespace App\MatchMaker\Player;

abstract class AbstractPlayer
{
    /** @var string */
    protected $name = 'anonymous';

    /** @var float */
    protected $ratio = 400.0;

    /**
     * @param string $name
     * @param float $ratio
     */
    public function __construct($name = 'anonymous', $ratio = 400.0)
    {
        $this->name = $name;
        $this->ratio = $ratio;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRatio(): float
    {
        return $this->ratio;
    }

    protected abstract function probabilityAgainst(AbstractPlayer $player): float;

    public abstract function updateRatioAgainst(AbstractPlayer $player, int $result);
}
