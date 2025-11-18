<?php

const RESULT_WINNER = 1;
const RESULT_LOSER = -1;
const RESULT_DRAW = 0;
const RESULT_POSSIBILITIES = [RESULT_WINNER, RESULT_LOSER, RESULT_DRAW];

class Player
{
    public $level;

    public function __construct($level)
    {
        if (!is_int($level)) {
            throw new InvalidArgumentException('Level must be an integer.');
        }
        $this->level = $level;
    }
}

class Encounter
{
    public function probabilityAgainst(Player $playerOne, Player $playerTwo)
    {
        return 1 / (1 + (pow(10, (($playerTwo->level - $playerOne->level) / 400))));
    }

    public function setNewLevel(Player $playerOne, Player $playerTwo, $playerOneResult)
    {
        if (!in_array($playerOneResult, RESULT_POSSIBILITIES, true)) {
            trigger_error(sprintf('Invalid result. Expected %s', implode(' or ', RESULT_POSSIBILITIES)));
        }

        $playerOne->level += (int) (32 * ($playerOneResult - $this->probabilityAgainst($playerOne, $playerTwo)));
    }
}

$greg = new Player(400);
$jade = new Player(800);

$encounter = new Encounter();

echo sprintf(
    'Greg a %.2f%% chance de gagner face à Jade',
    $encounter->probabilityAgainst($greg, $jade) * 100
) . PHP_EOL;

// Imaginons que Greg l’emporte tout de même.
$encounter->setNewLevel($greg, $jade, RESULT_WINNER);
$encounter->setNewLevel($jade, $greg, RESULT_LOSER);

echo sprintf(
    'Les niveaux des joueurs ont évolué vers %s pour Greg et %s pour Jade',
    $greg->level,
    $jade->level
) . PHP_EOL;

exit(0);
