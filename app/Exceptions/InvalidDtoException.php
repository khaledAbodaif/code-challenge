<?php

namespace App\Exceptions;

use App\Infrastructure\Helpers\Traits\LogException;
use Exception;

/**
 * Exception for handling and logging DTO mapping failures.
 * This exception is thrown when Ingredient stock doesn't fit the required order quantity
 */
class InvalidDtoException extends Exception
{
    use LogException;

    private string $serviceName;
    protected string $expectedDTO;

    /**
     * Create a new OrderProcessingException instance.
     *
     * Constructs the exception and automatically logs the error with provided context.
     *
     * @param string $message The exception message
     * @param string $serviceName The name of the service that the fail on it
     * @param string $expectedDTO required DTO
     *
     * @example
     *
     * throw new OrderProcessingException(
     *     service::class,
     *     DTO::class,
     *     "message"
     * );
     *
     */
    public function __construct(string $serviceName, string $expectedDTO, string $message = "Invalid DTO provided for ")
    {
        $this->serviceName = $serviceName;
        $this->expectedDTO = $expectedDTO;
        parent::__construct($message . $serviceName . '.');

        $this->logException(context: [
            "service" => $this->serviceName,
            "DTO" => $this->expectedDTO,
        ], title: "Dto Mapper Failed");
    }


}
