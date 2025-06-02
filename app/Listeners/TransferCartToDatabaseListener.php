<?php

namespace App\Listeners;

use App\Events\Login;
use App\Models\Carts;
use Illuminate\Auth\Events\Login as LoginEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;

class TransferCartToDatabaseListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LoginEvent $event): void
    {
        $user = $event->user;
        $cart = Session::get('cart', []);

        if (!empty($cart)) {
            foreach ($cart as $productId => $item) {
                Carts::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'product_id' => $productId,
                    ],
                    [
                        'quantity' => $item['quantity']
                    ]
                );
            }

            Session::forget('cart');
        }
    }
}
