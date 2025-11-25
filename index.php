<?php

/*
 * This file is part of the OpenClassRoom PHP Object Course.
 *
 * (c) Grégoire Hébert <contact@gheb.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

final class Lobby
{
    /** @var QueuingPlayer[] */
    public $queuingPlayers = [];

    public function findOponents(QueuingPlayer $player)
    {
        $minLevel = round($player->getRatio() / 100);
        $maxLevel = $minLevel + $player->getRange();

        return array_filter(
            $this->queuingPlayers,
            function (QueuingPlayer $potentialOponent) use ($minLevel, $maxLevel, $player) {
                $playerLevel = round($potentialOponent->getRatio() / 100);

                return $player !== $potentialOponent
                    && ($minLevel <= $playerLevel)
                    && ($playerLevel <= $maxLevel);
            }
        );
    }

    public function addPlayer(Player $player)
    {
        $this->queuingPlayers[] = new QueuingPlayer($player);
    }

    public function addPlayers(Player ...$players)
    {
        foreach ($players as $player) {
            $this->addPlayer($player);
        }
    }
}

abstract class Player
{
    protected $name;
    protected $ratio;

    public function __construct(string $name, float $ratio = 400.0)
    {
        $this->name = $name;
        $this->ratio = $ratio;
    }

    abstract public function getName(): string;

    protected function probabilityAgainst(Player $player)
    {
        return 1 / (1 + (10 ** (($player->getRatio() - $this->getRatio()) / 400)));
    }

    public function updateRatioAgainst(Player $player, int $result)
    {
        $this->ratio += 32 * ($result - $this->probabilityAgainst($player));
    }

    public function getRatio()
    {
        return $this->ratio;
    }
}

class SimplePlayer extends Player
{
    public function getName(): string
    {
        return $this->name;
    }
}

class QueuingPlayer extends Player
{
    protected $range;

    public function __construct(Player $player, int $range = 1)
    {
        parent::__construct($player->getName(), $player->getRatio());
        $this->range = $range;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRange()
    {
        return $this->range;
    }

    public function setRange(int $range)
    {
        $this->range = $range;
    }
}

$greg = new SimplePlayer('greg', 400);
$jade = new SimplePlayer('jade', 476);

$lobby = new Lobby();
$lobby->addPlayers($greg, $jade);

var_dump($lobby->findOponents($lobby->queuingPlayers[0]));

exit(0);