<?php

namespace App\Infrastructure\Interfaces\DTOs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface DtoInterface
{
    /**
     * Create a new DTO instance from a model instance.
     *
     * @param Model $model The model instance to create the DTO from
     * @return self Returns a new instance of the DTO
     * @throws \InvalidArgumentException When the model is invalid or missing required properties
     */
    public function fromModel(Model $model): self;

    /**
     * Create a new DTO instance from an array of data.
     *
     * @param array $data Associative array of data to create the DTO from
     * @return self Returns a new instance of the DTO
     * @throws \InvalidArgumentException When required data is missing or invalid
     */
    public static function fromArray(array $data): self;

    /**
     * Create multiple DTO instances from an array of data arrays.
     *
     * @param array<int, array<string, mixed>> $data Array of associative arrays, each containing data for a single DTO
     * @return array<int, self> Returns an array of DTO instances
     * @throws \InvalidArgumentException When any data array is invalid or missing required properties
     */
    public static function fromMultipleArray(array $data): array;

    /**
     * Convert the DTO to an array representation.
     *
     * @return array<string, mixed> Returns an associative array representation of the DTO
     */
    public function toArray(): array;
    public function toMultipleArray(): array;

    /**
     * Convert the DTO to a Laravel Collection.
     *
     * @return Collection Returns a collection containing the DTO data
     */
    public function toCollection(): Collection;


}
