@extends('layouts.app')

@section('content')
<div class="w-7xl mx-auto bg-white min-h-[60vh]">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row items-center justify-between bg-slate-200 p-3">

        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h6m-6 4h10M5 4h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z" />
            </svg>
            <h1 class="text-lg md:text-xl font-semibold text-gray-700 tracking-tight">
                Sales List
            </h1>
        </div>



        <div class="mt-4 md:mt-0 flex gap-2 text-sm">
            {{-- Add Sale --}}
            <a href="{{ route('admin.sales.create') }}" class="inline-flex items-center gap-1 bg-green-600 text-white px-3 py-1.5 rounded hover:bg-green-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Sale
            </a>

            {{-- Trash/List Toggle --}}
            <a href="{{ Route::is('admin.sales.trash.list') ? route('admin.sales.list') : route('admin.sales.trash.list') }}" class="inline-flex items-center gap-1 bg-yellow-600 text-white px-3 py-1.5 rounded hover:bg-yellow-700">
                @if(Route::is('admin.sales.trash.list'))
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M9 12h6m-6 4h6M4 7v13a2 2 0 002 2h12a2 2 0 002-2V7" />
                    </svg>
                    List
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22" />
                    </svg>
                    Trash
                @endif
            </a>

            {{-- Filter Toggle --}}
            <button type="button" id="toggleFilter" class="inline-flex items-center gap-1 bg-indigo-600 text-white px-3 py-1.5 rounded hover:bg-indigo-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L14 13.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 018 17v-3.586L3.293 6.707A1 1 0 013 6V4z" />
                </svg>
                Filter
            </button>
        </div>

    </div>

    <div class="p-4">
        <form method="POST" id="filterForm" class="mb-6 flex flex-wrap items-center gap-3 hidden text-sm">
            @csrf
            {{-- Customer Name --}}
            <input type="text" name="customer" value="{{ request('customer') }}"
                placeholder="Customer Name"
                class="px-3 py-1.5 border rounded w-40 focus:outline-none focus:ring focus:border-indigo-300">

            {{-- Product Name --}}
            <input type="text" name="product" value="{{ request('product') }}"
                placeholder="Product Name"
                class="px-3 py-1.5 border rounded w-40 focus:outline-none focus:ring focus:border-indigo-300">

            {{-- From Date --}}
            <input type="date" name="from" value="{{ request('from') }}"
                class="datepicker px-3 py-1.5 border rounded w-36 focus:outline-none focus:ring focus:border-indigo-300"
                placeholder="From Date">

            {{-- To Date --}}
            <input type="date" name="to" value="{{ request('to') }}"
                class="datepicker px-3 py-1.5 border rounded w-36 focus:outline-none focus:ring focus:border-indigo-300"
                placeholder="To Date">

            {{-- Submit Button --}}
            <button type="submit"
                class="inline-flex items-center gap-1 bg-indigo-600 text-white px-3 py-1.5 rounded hover:bg-indigo-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L14 13.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 018 17v-3.586L3.293 6.707A1 1 0 013 6V4z" />
                </svg>
                Apply Filters
            </button>
        </form>


        {{-- Sales Table --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            @if(session('success'))
                <div class="flex items-center gap-2 bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <table class="min-w-full table-auto">
                <thead class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Customer</th>
                        <th class="px-4 py-2">Creator</th>
                        <th class="px-4 py-2">Items</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2 text-center w-[100px]">Actions</th>
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
                            <td class="px-4 py-2 text-center space-x-2 text-sm flex">
                                {{-- View --}}
                                <a href="{{ route('admin.sales.show', $sale) }}" class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View
                                </a>

                                @if(Route::is('admin.sales.trash.list'))
                                    {{-- Restore --}}
                                    <a href="{{ route('admin.sales.restore', $sale) }}" data-url="{{ route('admin.sales.restore', $sale) }}" class="inline-flex items-center gap-1 text-green-600 hover:text-green-800 hover:underline delete-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21V10m0 0L5 14m4-4l4 4" />
                                        </svg>
                                        Restore
                                    </a>
                                @else
                                    {{-- Delete --}}
                                    <a href="{{ route('admin.sales.destroy', $sale) }}" data-url="{{ route('admin.sales.destroy', $sale) }}" class="inline-flex items-center gap-1 text-red-600 hover:text-red-800 hover:underline delete-link">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Delete
                                    </a>
                                @endif
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
