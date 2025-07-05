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
            foreach ($cart as $key => $item) {
                // استخراج product_id و code از کلید (مثلاً "162_;n5")
                [$productId] = explode('_', $key);
                $code = $item['code'] ?? null;

                // ذخیره یا به‌روزرسانی رکورد در جدول carts
             Carts::updateOrCreate(
                    [
                        'user_id'    => $user->id,
                        'product_id' => (int) $productId,
                        'code'       => $code,
                    ],
                    [
                        'quantity'   => (int) $item['quantity'],
                    ]
                );
            }

            Session::forget('cart');
        }
    }
}
