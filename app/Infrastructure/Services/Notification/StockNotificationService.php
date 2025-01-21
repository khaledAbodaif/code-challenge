<?php

namespace App\Infrastructure\Services\Notification;


use App\Exceptions\StockAlertException;
use App\Infrastructure\DTOs\IngredientDto;
use App\Infrastructure\Interfaces\Services\IngredientServiceInterface;
use App\Infrastructure\Interfaces\Services\NotificationServiceInterface;
use App\Mail\LowStockAlert;
use Illuminate\Support\Facades\Mail;

/**
 * {@inheritdoc}
 */
class StockNotificationService implements NotificationServiceInterface
{

    public function __construct(
        private readonly IngredientServiceInterface $ingredientService
    )
    {
    }

    /**
     * {@inheritdoc}
     *
     * map to dto
     * check if should send or not
     * send mail
     * @throw StockAlertException
     */
    public function send(mixed $event): void
    {
        $ingredientDto = IngredientDto::fromModel($event->ingredient);

        try {

            if ($this->ingredientService->shouldSendStockAlert($ingredientDto)) {
                Mail::queue(new LowStockAlert($ingredientDto)); //
                $this->ingredientService->update($ingredientDto->id, [
                    'stock_alert_sent' => 1
                ]);

            }

        } catch (\Exception $exception) {
            throw new StockAlertException(
                message: "Failed to process stock alert",
                previous: $exception,
                context: ['ingredient_id' => $event->ingredient->id],
            );
        }


    }
}
