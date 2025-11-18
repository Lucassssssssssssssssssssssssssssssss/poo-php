<?php

class Player
{
    private $level;

    // Constructeur
    public function __construct($level)
    {
        if (!is_int($level)) {
            throw new InvalidArgumentException('Level must be an integer.');
        }
        $this->level = $level;
    }

    // Accesseur (getter)
    public function getLevel()
    {
        return $this->level;
    }

    // Mutateur (setter)
    public function setLevel($level)
    {
        if (!is_int($level)) {
            throw new InvalidArgumentException('Level must be an integer.');
        }
        if ($level < 0) {
            trigger_error('Le niveau doit être positif.', E_USER_ERROR);
        }
        $this->level = $level;
    }
}

class Encounter
{
    const RESULT_WINNER = 1;
    const RESULT_LOSER = -1;
    const RESULT_DRAW = 0;
    const RESULT_POSSIBILITIES = [
        self::RESULT_WINNER,
        self::RESULT_LOSER,
        self::RESULT_DRAW
    ];

    public static function probabilityAgainst(Player $playerOne, Player $playerTwo)
    {
        return 1 / (1 + (pow(10, (($playerTwo->getLevel() - $playerOne->getLevel()) / 400))));
    }

    public static function setNewLevel(Player $playerOne, Player $playerTwo, $playerOneResult)
    {
        if (!in_array($playerOneResult, self::RESULT_POSSIBILITIES, true)) {
            trigger_error(sprintf('Invalid result. Expected %s', implode(' or ', self::RESULT_POSSIBILITIES)));
        }

        $newLevel = $playerOne->getLevel() + (int) (32 * ($playerOneResult - self::probabilityAgainst($playerOne, $playerTwo)));
        $playerOne->setLevel($newLevel);
    }
}

$greg = new Player(400);
$jade = new Player(800);

echo sprintf(
    'Greg a %.2f%% chance de gagner face à Jade',
    Encounter::probabilityAgainst($greg, $jade) * 100
) . PHP_EOL;

// Imaginons que Greg l’emporte
Encounter::setNewLevel($greg, $jade, Encounter::RESULT_WINNER);
Encounter::setNewLevel($jade, $greg, Encounter::RESULT_LOSER);

echo sprintf(
    'Les niveaux des joueurs ont évolué vers %s pour Greg et %s pour Jade',
    $greg->getLevel(),
    $jade->getLevel()
) . PHP_EOL;

exit(0);
