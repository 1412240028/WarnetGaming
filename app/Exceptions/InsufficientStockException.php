<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InsufficientStockException extends Exception
{
    protected string $itemName;
    protected int $availableStock;
    protected int $requestedQuantity;

    public function __construct(string $itemName, int $availableStock, int $requestedQuantity)
    {
        $this->itemName = $itemName;
        $this->availableStock = $availableStock;
        $this->requestedQuantity = $requestedQuantity;

        parent::__construct(
            "Stok tidak mencukupi untuk {$itemName}. Tersedia: {$availableStock}, diminta: {$requestedQuantity}."
        );
    }

    /**
     * Laravel otomatis manggil method ini kalau exception ini yang di-throw,
     * gak perlu daftarin manual di Handler/bootstrap/app.php
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
            'error' => 'insufficient_stock',
            'item' => $this->itemName,
            'available_stock' => $this->availableStock,
            'requested_quantity' => $this->requestedQuantity,
        ], 409); // 409 Conflict: request valid, tapi state saat ini gak memungkinkan
    }
}

