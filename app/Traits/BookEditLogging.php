<?php


namespace App\Traits;

use App\Models\BookEditLog;

trait BookEditLogging
{
    //
    public function logAction($userId, $action): void
    {
        $bookEditLog = new BookEditLog();

        $bookEditLog->create(
            [
                'userID' => $userId,
                'editAction' => $action
            ]
        );
    }
}
