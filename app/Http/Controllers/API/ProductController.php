<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ProductCatalogService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(
        protected ProductCatalogService $productCatalogService
    ) {
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $page = (int) $request->input('page', 1);
        $perPage = (int) $request->input('per_page', 40);
        $properties = $request->input('properties', []);

        $result = $this->productCatalogService->getFilteredProducts($page, $perPage, $properties);

        return response()->json($result);
    }
}