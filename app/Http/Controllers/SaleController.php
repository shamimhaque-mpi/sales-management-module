<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Sale\SaleCreateRequest;
use App\Repositories\Sale\SaleInterface;
use App\Models\{
    User, Product
};

class SaleController extends Controller
{

    protected SaleInterface $sale;

    public function __construct(SaleInterface $sale)
    {
        $this->sale = $sale;
    }

    /**
     * Display a paginated list of sales with optional filters.
     *
     * Filters supported:
     * - Customer name (partial match)
     * - Product name (partial match)
     * - Sale date range (from/to)
     *
     * @param Request $request
     * @return View
     */
    public function list(Request $request): View
    {
        $sales = $this->sale->list($request);
        return view('sales.list', compact('sales'));
    }





    /**
     * Show the form for creating a new sale.
     *
     * Loads all customers and products to populate dropdowns.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $customers = User::get();
        $products = Product::get();
        return view('sales.create', compact('customers', 'products'));
    }







    /**
     * Store a newly created sale in the database.
     *
     * Calculates total from item rows, creates the sale record,
     * and inserts associated sale items with discount applied.
     *
     * @param SaleCreateRequest $request
     * @return JsonResponse
     */    
    public function store(SaleCreateRequest $request): JsonResponse
    {
        $sale = $this->sale->store([
            'customer_id' => $request->customer_id,
            'creator_id'  => $request->user()?->id,
            'sale_date'   => $request->sale_date,
            'items'       => $request->items,
            'note'        => $request->note,
        ]);

        return response()->json(['message' => 'Sale created successfully']);
    }

    /**
     * Display a single sale with its items and customer.
     *
     * @param Sale $sale
     * @return View
     */
    public function show($id): View
    {
        $sale = $this->sale->show($id);
        return view('sales.show', compact('sale'));
    }
}
