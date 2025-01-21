<?php

namespace App\Infrastructure\Interfaces\Services;

/**
 * Interface NotificationServiceInterface
 *
 * Defines the contract for notification services within the application.
 * This interface ensures consistent notification handling across different
 * notification types and channels.
 *
 */
interface NotificationServiceInterface
{

    /**
     * Send a notification for the given event.
     *
     * @param mixed $event The event triggering the notification
     *                     This could be a model, array, or any data structure
     *                     containing the notification details
     *
     * @throws \Exception When notification delivery fails
     * @throws \InvalidArgumentException When the event data is invalid
     *
     * @return void
     */
    public function send(mixed $event):void;
}
