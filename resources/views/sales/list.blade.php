@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto bg-white">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between bg-slate-200 p-3">
        <h1 class="text-2xl font-bold text-gray-800">Sales List</h1>

        <div class="mt-4 md:mt-0 flex gap-3">
            <a href="{{ route('admin.sales.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                + Add Sale
            </a>
            <button type="button" id="toggleFilter"
               class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Filter
            </button>
        </div>
    </div>

    <div class="p-4">
        <form method="GET" action="{{ route('admin.sales.list') }}"
            id="filterForm"
            class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4 hidden">
            <input type="text" name="customer" value="{{ request('customer') }}" placeholder="Customer Name"
                class="px-4 py-2 border rounded">

            <input type="text" name="product" value="{{ request('product') }}" placeholder="Product Name"
                class="px-4 py-2 border rounded">

            <input type="date" name="from" value="{{ request('from') }}" class="px-4 py-2 border rounded">
            <input type="date" name="to" value="{{ request('to') }}" class="px-4 py-2 border rounded">

            <button type="submit"
                class="col-span-1 md:col-span-4 bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700">
                Apply Filters
            </button>
        </form>

        {{-- Sales Table --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Customer</th>
                        <th class="px-4 py-2">Creator</th>
                        <th class="px-4 py-2">Items</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2 w-[60px]">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    @forelse ($sales as $sale)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $loop->iteration + ($sales->currentPage() - 1) * $sales->perPage() }}</td>
                            <td class="px-4 py-2">{{ $sale->sale_date?->format('d M Y') }}</td>
                            <td class="px-4 py-2">{{ $sale->customer?->name }}</td>
                            <td class="px-4 py-2">{{ $sale->creator?->name }}</td>
                            <td class="px-4 py-2 font-semibold">{{ $sale->items?->count() }}</td>
                            <td class="px-4 py-2 font-semibold">{{ $sale->formatted_total }}</td>
                            <td class="px-4 py-2 text-center">
                                <a href="{{route('admin.sales.show', $sale)}}"
                                class="text-indigo-600 hover:underline">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">No sales found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $sales->withQueryString()->links() }}
        </div>

        {{-- Page Total --}}
        <div class="mt-4 text-right text-sm text-gray-700">
            <strong>Total on this page:</strong>
            {{ number_format($sales->sum('total'), 2) }} BDT
        </div>
    </div>
</div>

{{-- Filter Toggle Script --}}
<script>
    document.getElementById('toggleFilter').addEventListener('click', () => {
        const form = document.getElementById('filterForm');
        form.classList.toggle('hidden');
    });
</script>
@endsection
