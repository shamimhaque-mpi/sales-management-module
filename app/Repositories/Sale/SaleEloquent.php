<?php

namespace App\Repositories\Sale;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SaleEloquent implements SaleInterface
{


    /**
     * Get a paginated list of sales with optional filters.
     *
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request): LengthAwarePaginator
    {
        $query = Sale::with('customer', 'items.product');

        if ($request->filled('customer')) {
            $query->whereHas('customer', fn($q) => $q->where('name', 'like', "%{$request->customer}%"));
        }

        if ($request->filled('product')) {
            $query->whereHas('items.product', fn($q) => $q->where('name', 'like', "%{$request->product}%"));
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('sale_date', [$request->from, $request->to]);
        }

        return $query->orderBy('id', 'DESC')->paginate(10);
    }




    /**
     * Store a new sale with its items.
     *
     * @param array $data
     * @return Sale
     */
    public function store(array $data): Sale
    {
        return \DB::transaction(function () use ($data) {
            $items = $data['items'];
            $total = calculateSaleTotal($items);

            $sale = Sale::create([
                'customer_id' => $data['customer_id'],
                'creator_id'  => $data['creator_id'],
                'sale_date'   => $data['sale_date'],
                'total'       => $total,
            ]);

            if(isset($data['note']))
                $sale->notes()->create(['body'=>$data['note']]);

            collect($items['product_id'] ?? [])->each(function ($productId, $key) use ($items, $sale) {
                $sale->items()->create([
                    'product_id' => $productId,
                    'price'      => $items['price'][$key],
                    'quantity'   => $items['quantity'][$key],
                    'discount'   => $items['discount'][$key],
                ]);
            });

            return $sale;
        });
    }




    /**
     * Get a single sale with its relationships.
     *
     * @param int $id
     * @return Sale
     */
    public function show(int $id): Sale
    {
        return Sale::with('customer', 'items.product', 'creator')->findOrFail($id);
    }
}
