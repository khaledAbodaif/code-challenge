<?php

namespace App\Mail;

use App\Infrastructure\DTOs\IngredientDto;
use App\Models\Ingredient;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Low Stock Alert Email
 *
 * Handles the email notification for low stock alerts.
 */
class LowStockAlert extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param IngredientDto $ingredient
     */
    public function __construct(
        public readonly IngredientDto $ingredient
    ) {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this->markdown('emails.stock.low-alert')
            ->to("admin@example.test")
            ->subject('Low Stock Alert: ' . $this->ingredient->name)
            ->with([
                'ingredient' => $this->ingredient,
                'currentStock' => $this->ingredient->stock_quantity,
                'initialStock' => $this->ingredient->initial_stock_quantity
            ]);
    }
}
