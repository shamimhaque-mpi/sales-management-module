<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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
    public function trashList(Request $request): View
    {
        $sales = $this->sale->list($request, 'trash');
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


    /**
     * Soft deletes a sale record by its ID and redirects back with a success message.
     *
     * This method delegates the deletion logic to the Sale repository,
     * which uses Laravel's SoftDeletes to mark the record as deleted.
     * After deletion, it redirects the user back to the previous page
     * and flashes a success message to the session.
     *
     * @param Request $request The incoming HTTP request
     * @param int $id The ID of the sale to delete
     * @return RedirectResponse Redirects back with a success notification
     */
    public function destroy(Request $request, $id): RedirectResponse
    {
        $this->sale->destroy($id);
        return redirect()
            ->back()
            ->with('success', 'Sale deleted successfully.');
    }


    /**
     * Restores a soft-deleted sale by its ID and redirects back with a success message.
     *
     * This method uses the Sale repository to locate and restore a sale that was previously soft-deleted.
     * After restoration, it redirects the user back to the previous page and flashes a success notification.
     *
     * @param Request $request The incoming HTTP request
     * @param int $id The ID of the sale to restore
     * @return RedirectResponse Redirects back with a success notification
     */
    public function restore(Request $request, $id): RedirectResponse
    {
        $this->sale->restore($id);
        return redirect()
            ->back()
            ->with('success', 'Sale restored successfully.');
    }
}
