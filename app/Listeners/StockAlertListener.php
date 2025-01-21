<?php

namespace App\Listeners;

use App\Events\StockUpdatedEvent;
use App\Infrastructure\Services\Notification\StockNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;


/**
 * Stock Alert Listener
 *
 * Handles low stock notifications and updates alert status.
 * Implements ShouldQueue to process notifications asynchronously.
 *
 * @implements ShouldQueue
 */
class StockAlertListener implements ShouldQueue
{
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var array<int, int>
     */
    public $backoff = [60, 120, 300]; // 1min, 2mins, 5mins


    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param StockUpdatedEvent $event
     * @return void
     */
    public function handle(StockUpdatedEvent $event): void
    {

            $notification = app(StockNotificationService::class);
            $notification->send($event);


    }


}
