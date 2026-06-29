<x-layouts.storefront title="My Orders">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">My Orders</h1>
            <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">Account Settings</a>
        </div>

        @if ($orders->isEmpty())
            <div class="mt-8 rounded-lg border border-dashed border-gray-300 py-16 text-center">
                <p class="text-gray-500">You haven't placed any orders yet.</p>
                <a href="{{ route('shop.index') }}" class="mt-4 inline-block rounded-md bg-emerald-600 px-6 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                    Start Shopping
                </a>
            </div>
        @else
            <div class="mt-6 overflow-hidden rounded-lg border border-gray-200 bg-white">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Order</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Items</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Total</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($orders as $order)
                            <tr>
                                <td class="px-4 py-4 text-sm font-medium text-gray-900">{{ $order->order_number }}</td>
                                <td class="px-4 py-4 text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-4 text-sm text-gray-500">{{ $order->items_count }}</td>
                                <td class="px-4 py-4">
                                    <x-storefront.order-status-badge :status="$order->status" />
                                </td>
                                <td class="px-4 py-4 text-sm font-semibold text-gray-900">{{ money($order->total) }}</td>
                                <td class="px-4 py-4 text-right">
                                    <a href="{{ route('orders.show', $order->order_number) }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-layouts.storefront>
