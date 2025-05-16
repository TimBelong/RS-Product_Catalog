<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Repositories\PropertyRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductCatalogService
{
    public function __construct(
        protected ProductRepository $productRepository,
        protected PropertyRepository $propertyRepository,
    ) {
    }

    public function getFilteredProducts(int $page = 1, int $perPage = 40, array $properties = []): array
    {
        $products = $this->getProductsQuery($properties)
            ->with('propertyValues.property')
            ->paginate($perPage, ['*'], 'page', $page);

        return [
            'products' => $this->transformProducts($products),
            'pagination' => $this->getPaginationData($products),
        ];
    }

    protected function getProductsQuery(array $properties): Builder
    {
        $query = $this->productRepository->all()->toQuery();

        foreach ($properties as $propertyName => $values) {
            if (empty($values)) continue;

            if ($property = $this->propertyRepository->findByName($propertyName)) {
                $this->addPropertyFilter($query, $property->getId(), $values);
            }
        }

        return $query;
    }

    protected function addPropertyFilter(Builder $query, int $propertyId, array $propertyValues): void
    {
        $query->whereHas('propertyValues', function (Builder $q) use ($propertyId, $propertyValues) {
            $q->whereIn('property_values.id', function ($sub) use ($propertyId, $propertyValues) {
                $sub->select('id')
                    ->from('property_values')
                    ->where('property_id', $propertyId)
                    ->whereIn('value', (array)$propertyValues);
            });
        });
    }

    protected function transformProducts(LengthAwarePaginator $products): array
    {
        return $products->map(fn ($product) => [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'quantity' => $product->getQuantity(),
            'properties' => collect($product->propertyValues)
                ->groupBy(fn ($item) => $item->property->getName())
                ->map(fn ($group) => $group->pluck('value')->toArray())
                ->toArray(),
        ])->toArray();
    }

    /**
     * Получить данные пагинации
     */
    protected function getPaginationData(LengthAwarePaginator $paginator): array
    {
        return [
            'total' => $paginator->total(),
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
        ];
    }
}