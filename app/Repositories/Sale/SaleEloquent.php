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
    public function list(Request $request, String $type = 'general'): LengthAwarePaginator
    {
        $query = Sale::with('customer', 'items.product');

        if($type=='trash')
            $query = $query->onlyTrashed();

        if ($request->customer) {
            $query->whereHas('customer', fn($q) => $q->where('name', 'like', "%{$request->customer}%"));
        }

        if ($request->product) {
            $query->whereHas('items.product', fn($q) => $q->where('name', 'like', "%{$request->product}%"));
        }

        if ($request->from) {
            $query->where('sale_date', '>=', $request->from);
        }

        if ($request->to) {
            $query->where('sale_date', '<=', $request->to);
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
                $sale->note()->create(['body'=>$data['note']]);

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
        return Sale::with('customer', 'items.product', 'creator')->withTrashed()->findOrFail($id);
    }


    /**
     * Soft delete a sale by ID.
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        $sale = Sale::findOrFail($id);
        return $sale->delete();
    }


    /**
     * Restore a soft-deleted sale.
     *
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool
    {
        $sale = Sale::onlyTrashed()->findOrFail($id);
        return $sale->restore();
    }
}
