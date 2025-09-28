@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Sale Details</h2>

    <div class="mb-6">
        <p><strong>Customer:</strong> {{ $sale->customer->name }}</p>
        <p><strong>Sale Date:</strong> {{ $sale->sale_date }}</p>
        <p><strong>Created By:</strong> {{ $sale->creator->name ?? 'N/A' }}</p>
        <p><strong>Total Amount:</strong> {{ $sale->formatted_total }}</p>
    </div>

    <h3 class="text-lg font-semibold mb-2">Items</h3>
    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2 text-left">Product</th>
                <th class="border px-4 py-2 text-right">Price</th>
                <th class="border px-4 py-2 text-right">Quantity</th>
                <th class="border px-4 py-2 text-right">Discount (%)</th>
                <th class="border px-4 py-2 text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $item)
                @php
                    $subtotal = $item->price * $item->quantity;
                    $discountAmount = $subtotal * ($item->discount / 100);
                    $total = $subtotal - $discountAmount;
                @endphp
                <tr>
                    <td class="border px-4 py-2">{{ $item->product->name }}</td>
                    <td class="border px-4 py-2 text-right">{{ number_format($item->price, 2) }} BDT</td>
                    <td class="border px-4 py-2 text-right">{{ $item->quantity }}</td>
                    <td class="border px-4 py-2 text-right">{{ $item->discount }}%</td>
                    <td class="border px-4 py-2 text-right">{{ number_format($total, 2) }} BDT</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <ul class="mt-3">
        @foreach($sale->notes as $note)
        <li>{{$note->body}}</li>
        @endforeach
    </ul>

    <div class="mt-6 text-right">
        <strong>Grand Total:</strong> {{ $sale->formatted_total }}
    </div>

    <div class="mt-8">
        <a href="{{ route('admin.sales.list') }}" class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
            ← Back to List
        </a>
    </div>
</div>
@endsection
