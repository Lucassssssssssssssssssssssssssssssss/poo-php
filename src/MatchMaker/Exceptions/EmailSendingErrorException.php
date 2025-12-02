<?php

declare(strict_types=1);

namespace App\MatchMaker\Exceptions;

use RuntimeException;

class EmailSendingErrorException extends RuntimeException
{
    protected $message = "Impossible d'envoyer l'email.";
}
