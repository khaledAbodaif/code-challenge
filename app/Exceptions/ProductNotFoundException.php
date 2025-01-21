<?php

namespace App\Exceptions;

use App\Infrastructure\Helpers\Traits\LogException;
use Exception;
use Throwable;

/**
 * Exception for handling and logging product not found.
 * This exception is thrown when trying to fetch some products with id and not found
 */
class ProductNotFoundException extends Exception
{
    use LogException;

    /**
     * Create a new ProductNotFoundException instance.
     *
     * Constructs the exception and automatically logs the error with provided context.
     *
     * @param string $message The exception message
     * @param array $context Additional context data to be included in the log
     *
     * @example
     *
     * throw new ProductNotFoundException(
     *     "some product ids not found",
     *     [required => [1,2] , found =>[2,3]]
     * );
     *
     */
    public function __construct(
        string $message = "",
        array $context = []
    ) {
        parent::__construct($message, 0);

        $this->logException(context: $context,channel: 'product');
    }

}
