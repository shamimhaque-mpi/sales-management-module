@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <div class="flex items-center gap-2 mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3v2.25M14.25 3v2.25M3 9.75h18M4.5 6h15a1.5 1.5 0 011.5 1.5v12a1.5 1.5 0 01-1.5 1.5h-15A1.5 1.5 0 013 19.5v-12A1.5 1.5 0 014.5 6z" />
        </svg>
        <h1 class="text-xl font-semibold text-gray-700 tracking-tight">ERP Dashboard</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Sales Module -->
        <div class="bg-white shadow rounded p-5 flex flex-col justify-between">
            <div class="flex items-center gap-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v6H3V3zm0 8h18v10H3V11z" />
                </svg>
                <h2 class="text-base font-semibold text-gray-800">Sales</h2>
            </div>
            <p class="text-sm text-gray-600 mb-4">View and manage all sales transactions.</p>
            <a href="{{ route('admin.sales.list') }}"
               class="inline-flex items-center justify-center gap-1 w-full px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                Go to Sale List
            </a>
        </div>

        <!-- Inventory Module -->
        <div class="bg-white shadow rounded p-5 flex flex-col justify-between">
            <div class="flex items-center gap-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                <h2 class="text-base font-semibold text-gray-800">Inventory</h2>
            </div>
            <p class="text-sm text-gray-600 mb-4">Track product stock and availability.</p>
            <button disabled
                class="inline-flex items-center justify-center gap-1 w-full px-3 py-2 bg-gray-300 text-gray-500 text-sm rounded cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                Coming Soon
            </button>
        </div>

        <!-- Customers Module -->
        <div class="bg-white shadow rounded p-5 flex flex-col justify-between">
            <div class="flex items-center gap-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A4 4 0 017 16h10a4 4 0 011.879.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <h2 class="text-base font-semibold text-gray-800">Customers</h2>
            </div>
            <p class="text-sm text-gray-600 mb-4">Manage customer profiles and history.</p>
            <button disabled
                class="inline-flex items-center justify-center gap-1 w-full px-3 py-2 bg-gray-300 text-gray-500 text-sm rounded cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                Coming Soon
            </button>
        </div>
    </div>
</div>
@endsection
