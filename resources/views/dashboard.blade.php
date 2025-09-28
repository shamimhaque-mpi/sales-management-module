@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">ERP Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Sales Module -->
        <div class="bg-white shadow rounded p-5 flex flex-col justify-between">
            <div>
                <h2 class="text-lg font-semibold mb-2">Sales</h2>
                <p class="text-sm text-gray-600">View and manage all sales transactions.</p>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.sales.list') }}"
                   class="inline-block w-full text-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Go to Sale List →
                </a>
            </div>
        </div>

        <!-- Add more modules here -->
        <div class="bg-white shadow rounded p-5">
            <h2 class="text-lg font-semibold mb-2">Inventory</h2>
            <p class="text-sm text-gray-600">Track product stock and availability.</p>
        </div>

        <div class="bg-white shadow rounded p-5">
            <h2 class="text-lg font-semibold mb-2">Customers</h2>
            <p class="text-sm text-gray-600">Manage customer profiles and history.</p>
        </div>
    </div>
</div>
@endsection
