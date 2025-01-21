<?php

namespace App\Exceptions;

use App\Infrastructure\Helpers\Traits\LogException;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Exception for handling and logging database transaction failures.
 * This exception is thrown when database transactions fail, ensuring that all transaction
 */
class TransactionException extends \RuntimeException
{
    use LogException;


    /**
     * Create a new TransactionException instance.
     *
     * Constructs the exception and automatically logs the error with provided context.
     *
     * @param string $message The exception message
     * @param Throwable|null $previous The previous throwable/exception that caused this exception
     * @param array $context Additional context data to be included in the log
     *
     * @example
     *
     * throw new TransactionException(
     *     "Failed to process payment",
     *     $previousException,
     *     ['order_id' => 123, 'amount' => 99.99]
     * );
     *
     */
    public function __construct(
        string $message = "",
        ?Throwable $previous = null,
        array $context = []
    ) {
        parent::__construct($message, 0, $previous);

        $this->logException(context: $context , channel: 'transactions' ,title: "Transaction Failed");
    }





}
