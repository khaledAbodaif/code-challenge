<?php

namespace App\Infrastructure\Services\Ingredient;


use App\Enums\UnitEnum;
use App\Events\StockUpdatedEvent;
use App\Exceptions\InsufficientStockException;
use App\Infrastructure\DTOs\IngredientDto;
use App\Infrastructure\Helpers\Traits\DtoArrayValidation;
use App\Infrastructure\Interfaces\Services\IngredientServiceInterface;
use App\Infrastructure\Interfaces\Repositories\IngredientRepositoryInterface;
use App\Infrastructure\ValueObjects\Quantity;
use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class IngredientService implements IngredientServiceInterface
{

    use DtoArrayValidation;
    public const STOCK_PERCENTAGE_LIMIT = 50;

    public function __construct(
        private readonly IngredientRepositoryInterface $ingredientRepository
    )
    {
    }

    public function create(IngredientDto $dto): Model|Ingredient
    {
        return $this->ingredientRepository->create($dto->toArray());
    }

    public function isTableEmpty(): bool
    {
        return $this->ingredientRepository->isTableEmpty();
    }

    public function createMany(array $dtos): void
    {

       $this->validateInput($dtos);
        $this->ingredientRepository->insert(IngredientDto::toMultipleArray($dtos));

    }


    public function reduceIngredients(Collection $ingredients, Quantity $quantity): void
    {

        foreach ($ingredients as $ingredient) {
            $quantityInKG = UnitEnum::from($ingredient->pivot->unit)->toKilograms($ingredient->pivot->quantity) * $quantity->getValue();
            if ($ingredient->stock_quantity > $quantityInKG) {
                $ingredient->stock_quantity = $ingredient->stock_quantity - $quantityInKG;
            } else {
                throw new InsufficientStockException("stock exception");
            }
            $ingredient->save();
            event(new StockUpdatedEvent($ingredient));

        }


    }


    public function update(int $id, array $data): bool
    {
        return $this->ingredientRepository->update($id, $data);
    }

    public function lockTableForUpdate(array $ids): Collection
    {
        return $this->ingredientRepository->lockTableWhereActiveIds($ids);
    }

    public function shouldSendStockAlert(IngredientDto $dto): bool
    {
        return $dto->stock_quantity <= ($dto->initial_stock_quantity * self::STOCK_PERCENTAGE_LIMIT) / 100
            && !$dto->stock_alert_sent;
    }

    private function validateInput(array $data): void
    {
        $this->dtoInstanceValidation($data, IngredientDto::class);
    }
}
