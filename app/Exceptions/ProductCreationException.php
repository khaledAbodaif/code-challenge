<?php

namespace App\Exceptions;

use App\Infrastructure\Helpers\Traits\LogException;
use Exception;

/**
 * Exception for handling and logging order creation failures.
 * This exception is thrown when order faced any exception when it processed
 */
class ProductCreationException extends Exception
{
    use LogException;


    /**
     * Create a new OrderProcessingException instance.
     *
     * Constructs the exception and automatically logs the error with provided context.
     *
     * @param string $message The exception message
     * @param \Throwable|null $previous The previous throwable/exception that caused this exception
     * @param array $context Additional context data to be included in the log
     *
     * @example
     *
     * throw new OrderProcessingException(
     *     "order creation filed",
     *     $previousException,
     *     []
     * );
     *
     */
    public function __construct(
        string $message = "",
        ?\Throwable $previous = null,
        array $context = []
    ) {
        parent::__construct($message, 0, $previous);

        $this->logException(context: $context , channel: 'product' ,title: "Order Failed");
    }
}
