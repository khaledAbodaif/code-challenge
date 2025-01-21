<?php

namespace App\Exceptions;


use App\Infrastructure\Helpers\Traits\LogException;

/**
 * Exception for handling and logging Ingredient stock failures.
 * This exception is thrown when Ingredient stock doesn't fit the required order quantity
 */
class InsufficientStockException extends \Exception
{

    use LogException;


    /**
     * Create a new InsufficientStockException instance.
     *
     * Constructs the exception and automatically logs the error with provided context.
     *
     * @param string $message The exception message
     * @param \Throwable|null $previous The previous throwable/exception that caused this exception
     * @param array $context Additional context data to be included in the log
     *
     * @example
     *
     * throw new InsufficientStockException(
     *     "Insufficient Stock Quantity",
     *     $previousException,
     *     ["ingredient_id"=>i,"required_quantity"=>100,"existing_quantity"=>10]
     * );
     *
     */
    public function __construct(
        string $message = "",
        ?\Throwable $previous = null,
        array $context = []
    ) {
        parent::__construct($message, 0, $previous);

        $this->logException(context: $context ,title: "Stock Failed");
    }
}
