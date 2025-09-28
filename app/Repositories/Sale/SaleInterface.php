<?php

namespace App\Repositories\Sale;

use Illuminate\Http\Request;
use App\Models\Sale;

interface SaleInterface
{
    /**
     * Get a paginated list of sales with optional filters.
     *
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request);

    /**
     * Store a new sale with its items.
     *
     * @param array $data
     * @return Sale
     */
    public function store(array $data): Sale;

    /**
     * Get a single sale with its relationships.
     *
     * @param int $id
     * @return Sale
     */
    public function show(int $id): Sale;

    /**
     * Soft delete a sale by ID.
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool;

    /**
     * Restore a soft-deleted sale.
     *
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool;
}
