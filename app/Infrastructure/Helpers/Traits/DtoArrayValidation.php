<?php

namespace App\Infrastructure\Helpers\Traits;


use App\Exceptions\InvalidDtoException;

/**
 * Trait providing validation functionality for arrays of DTOs.
 *
 * This trait offers methods to validate that all elements in an array
 * are instances of a specified DTO class. It's designed to be used
 * in services that process collections of DTOs.
 */
trait DtoArrayValidation
{

    /**
     * Validates that all elements in an array are instances of the specified DTO class.
     *
     * This method performs two validations:
     * 1. Checks if the input array is not empty
     * 2. Verifies that each element is an instance of the specified DTO class
     *
     * @param array $dtos Array of elements to validate
     * @param class-string $dto The expected DTO class name
     * @throws InvalidDtoException When validation fails due to:
     *         - Empty array
     *         - Element not being an instance of specified DTO class
     */
    private function dtoInstanceValidation(array $dtos , string $dto): void
    {

        if (empty($dtos)) {
            throw new InvalidDtoException(serviceName: self::class, expectedDTO: $dto);
        }

        foreach ($dtos as $ingredient) {
            if (!$ingredient instanceof $dto) {
                throw new InvalidDtoException(serviceName: self::class, expectedDTO: $dto);
            }
        }
    }
}
