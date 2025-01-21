<?php

namespace App\Infrastructure\Interfaces\DTOs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class DtoAbstract
{
    public static array $requiredKeys = [];

    abstract public static function fromModel(Model $ingredient): self;

    /**
     * Create a new DTO instance from an array of data.
     *
     * @param array $data Associative array of data to create the DTO from
     * @return self Returns a new instance of the DTO
     * @throws \InvalidArgumentException When required data is missing or invalid
     */
    public static function fromArray(array $data): self
    {
        return new static(...array_intersect_key($data, array_flip(static::$requiredKeys)));
    }

    /**
     * Create multiple DTO instances from an array of data arrays.
     *
     * @param array<int, array<string, mixed>> $data Array of associative arrays, each containing data for a single DTO
     * @return array<int, self> Returns an array of DTO instances
     * @throws \InvalidArgumentException When any data array is invalid or missing required properties
     */
    public static function fromMultipleArray(array $data): array
    {
        return array_map(fn(array $ingredient) => self::fromArray($ingredient), $data);
    }

    /**
     * Convert the DTO to an array representation.
     *
     * @return array<string, mixed> Returns an associative array representation of the DTO
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    /**
     * Convert the array if dto to a multiple array  representation.
     *
     * @return array<string, mixed> Returns an associative array representation of the DTO
     */
    public static function toMultipleArray(array $data): array
    {
        $items =[];
        foreach ($data as $item){
            $items[]=$item->toArray();
        }
        return $items;
    }

    /**
     * Convert the DTO to a Laravel Collection.
     *
     * @return Collection Returns a collection containing the DTO data
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }

}
