<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = $request->user()
            ->orders()
            ->withCount('items')
            ->latest()
            ->paginate(10);

        return view('account.orders.index', ['orders' => $orders]);
    }

    public function show(Request $request, string $orderNumber): View
    {
        $order = $request->user()
            ->orders()
            ->where('order_number', $orderNumber)
            ->with('items')
            ->firstOrFail();

        return view('account.orders.show', ['order' => $order]);
    }
}
