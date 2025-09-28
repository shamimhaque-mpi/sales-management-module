<?php

    /**
     * Calculates the grand total of a sale based on item-wise price, quantity, and discount.
     *
     * Iterates over each product entry using its index to access corresponding price, quantity, and discount.
     * - Computes subtotal = price × quantity
     * - Computes discount amount = subtotal × (discount / 100)
     * - Computes net total = subtotal − discount
     *
     * Returns the sum of all item-wise net totals as a float.
     *
     * @param array $items  The sale item data containing product_id, price, quantity, and discount arrays.
     * @return float        The final grand total after applying discounts.
     */
    function calculateSaleTotal(array $items): float 
    {
        return collect($items['product_id']??[])?->map(function($product, $key) use ($items){
            $total    = $items['price'][$key] * $items['quantity'][$key];
            $discount = $total * ($items['discount'][$key] / 100);
            return ($total - $discount);
        })?->sum();
    }