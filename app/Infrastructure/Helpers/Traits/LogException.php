<?php

namespace App\Infrastructure\Helpers\Traits;

use Illuminate\Support\Facades\Log;

trait LogException
{

    /**
     * Log the exception details.
     *
     * @param string $title Error message
     * @param array<string, mixed> $context Additional context data
     * @param string $channel Log channel (error, warning, info)
     */
    protected function logException(array $context = [], string $channel = 'stack' , string $title = "Failed"): void
    {

        $logData = [
            'message' => $this->getMessage(),
            'file' => $this->getFile(),
            'line' => $this->getLine(),
            'previous' => $this->getPrevious()?->getMessage(),
            ...$context
        ];

        Log::channel($channel)->error(
            $title . " : {$this->getMessage()}",
            $logData
        );

    }

}
