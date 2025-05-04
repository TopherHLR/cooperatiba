<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class YourControllerName extends BaseController
{
    public function index()
    {
        $notifications = [
            [
                'type' => 'order',
                'title' => 'Your order #12345 is ready',
                'content' => 'Your PE uniform order has been completed and is ready for pickup at the coop office.',
                'time' => '10 mins ago',
                'color' => '#EDD100', // Removed brackets for better CSS usage
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>'
            ],
            [
                'type' => 'chat',
                'title' => 'New message from Admin',
                'content' => 'Hello! Just checking if you received your order confirmation.',
                'time' => '1 hour ago',
                'color' => '#047705',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>'
            ]
        ];

        $products = [
            [
                'name' => 'PE Uniform',
                'price' => '₱250.00',
                'image' => '/images/clothes/pe.png'
            ],
            [
                'name' => 'PE Uniform (Large)',
                'price' => '₱275.00',
                'image' => '/images/clothes/pe.png'
            ]
        ];

        return view('coop.items', compact('notifications', 'products'));
    }
}