@extends('layouts.app')

@section('content')
<div class="w-7xl mx-auto">
    <div class="bg-white">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between bg-slate-200 p-3 mb-3">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h6m-6 4h10M5 4h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z" />
                </svg>
                <h1 class="text-lg md:text-xl font-semibold text-gray-700 tracking-tight">
                    Add New Sale
                </h1>
            </div>
            <div class="mt-4 md:mt-0 flex gap-3">
                <a href="{{ route('admin.sales.list') }}" class="inline-flex items-center gap-1 bg-green-600 text-white px-3 py-1.5 text-sm rounded hover:bg-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    List
                </a>
            </div>
        </div>

        <form id="saleForm" class="p-4" action="{{ route('admin.sales.store') }}">

            <div id="globalErrors" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul id="errorList" class="list-disc pl-5"></ul>
            </div>

            @csrf

            {{-- Customer & Date in one row --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="customer_id" class="block text-sm font-medium">Customer</label>
                    <select name="customer_id" id="customer_id" data-live-search="true" class="selectpicker w-full border min-h-[40px] rounded">
                        <option value="" disabled selected>Select a customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="sale_date" class="block text-sm font-medium">Sale Date</label>
                    <input type="date" name="sale_date" id="sale_date" class="datepicker w-full border rounded px-3 py-2" placeholder="Select Date">
                </div>
            </div>

            <hr class="my-5 w-full">

            {{-- Product Items --}}
            <div id="itemsContainer" class="space-y-4">
                <div class="grid grid-cols-7 gap-4">
                    <label for="" class="col-span-2">Product</label>
                    <label for="">Price</label>
                    <label for="">Quantity</label>
                    <label for="">Discount (%)</label>
                    <label for="">Total</label>
                </div>

                <div class="grid grid-cols-7 gap-4 item-row">
                    <select name="items[product_id][]" class="product-select border rounded px-2 py-1 col-span-2">
                        <option value="" disabled selected>Select a product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="items[price][]" oninput="calculateItemWiseTotalPrice()" class="price-input border rounded px-2 py-1" placeholder="Price">
                    <input type="number" name="items[quantity][]" oninput="calculateItemWiseTotalPrice()" class="quantity-input border rounded px-2 py-1" min="1" value="1" placeholder="Quantity">
                    <input type="number" name="items[discount][]" oninput="calculateItemWiseTotalPrice()" class="discount-input border rounded px-2 py-1" min="0" value="0" placeholder="Disc. (%)">
                    <input type="text" name="items[sub_total][]" class="sub-total-input border rounded px-2 py-1" placeholder="Total" readonly>
                    <button type="button" class="removeItem bg-red-500 text-white px-3 py-1 rounded">Remove</button>
                </div>
            </div>
            <hr class="mt-5">

            <div class="grid grid-cols-5 gap-3 mt-4">
                <div class="col-span-3 row-span-2">
                    <textarea type="text" name="note" class="w-full p-3 focus:outline-0" placeholder="Write a note"></textarea>
                </div>
                <div class="col-span-2 grid grid-cols-3 gap-2">
                    <label for="" class="col-span-2 text-right">Total Discount</label>
                    <label for="">: <span id="total_discount">0</span></label>

                    <label for="" class="col-span-2 text-right">Grand Total</label>
                    <label for="">: <span id="grand_total">0</span></label>
                </div>
            </div>



            {{-- Add Button Row --}}
            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded mr-2">Submit</button>
                <button type="button" id="addItem" class="bg-green-600 text-white px-4 py-2 rounded">Add Product</button>
            </div>

            <div class="mt-6">
            </div>
        </form>
    </div>
</div>

{{-- Template for additional product rows --}}
<template id="productRowTemplate">
    <div class="grid grid-cols-7 gap-4 item-row">
        <select name="items[product_id][]" class="product-select border rounded px-2 py-1 col-span-2">
            <option value="" disabled selected>Select a product</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
            @endforeach
        </select>
        <input type="number" name="items[price][]" oninput="calculateItemWiseTotalPrice()" class="price-input border rounded px-2 py-1" placeholder="Price">
        <input type="number" name="items[quantity][]" oninput="calculateItemWiseTotalPrice()" class="quantity-input border rounded px-2 py-1" min="1" value="1" placeholder="Quantity">
        <input type="number" name="items[discount][]" oninput="calculateItemWiseTotalPrice()" class="discount-input border rounded px-2 py-1" min="0" value="0" placeholder="Disc. (%)">
        <input type="text" name="items[sub_total][]" class="sub-total-input border rounded px-2 py-1" placeholder="Total" readonly>
        <button type="button" class="removeItem bg-red-500 text-white px-3 py-1 rounded">Remove</button>
    </div>
</template>

@endsection

@push('scripts')
    <script src="{{ asset('js/components/sale/createSale.js') }}"></script>
@endpush