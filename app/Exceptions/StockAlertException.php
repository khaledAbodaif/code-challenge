<?php

namespace App\Exceptions;


use App\Infrastructure\Helpers\Traits\LogException;

/**
 * Exception for handling and logging Notification failures.
 * This exception is thrown when Notification process fail
 */
class StockAlertException extends \Exception
{

    use LogException;


    /**
     * Create a new StockAlertException instance.
     *
     * Constructs the exception and automatically logs the error with provided context.
     *
     * @param string $message The exception message
     * @param \Throwable|null $previous The previous throwable/exception that caused this exception
     * @param array $context Additional context data to be included in the log
     *
     * @example
     *
     * throw new StockAlertException(
     *     ""Failed to process stock alert",
     * ['ingredient_id' => $ingredient->id],
     * $e
     * );
     *
     */
    public function __construct(
        string      $message = "",
        ?\Throwable $previous = null,
        array       $context = []
    )
    {
        parent::__construct($message, 0, $previous);

        $this->logException(context: $context,channel: "notification", title: "Stock Failed");
    }
}
