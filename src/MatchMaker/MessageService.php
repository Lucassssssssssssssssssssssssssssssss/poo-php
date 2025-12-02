<?php

declare(strict_types=1);

namespace App\MatchMaker;

use App\MatchMaker\Exceptions\EmailSendingErrorException;
use App\MatchMaker\Exceptions\NotificationSendingErrorException;
use App\MatchMaker\Exceptions\ShortTextException;

class MessageService
{
    public static function sendEmail(string $text): bool
    {
        if (false) {
            throw new EmailSendingErrorException();
        }
        return true;
    }

    public static function sendNotification(string $text): bool
    {
        if (true) {
            throw new NotificationSendingErrorException();
        }
        return true;
    }

    public static function sendMessage(string $text): bool
    {
        if (strlen($text) < 10) {
            throw new ShortTextException();
        }

        self::sendEmail($text);
        self::sendNotification($text);

        return true;
    }
}
