<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Property;
use App\Models\PropertyValue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductFilterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Подготовка данных для тестов
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->seedTestData();
    }

    /**
     * Тест получения всех товаров без фильтров
     */
    public function test_get_all_products_without_filters(): void
    {
        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'products',
                    'pagination' => [
                        'total',
                        'per_page',
                        'current_page',
                        'last_page',
                        'from',
                        'to',
                    ],
                ]
            )
            ->assertJsonCount(6, 'products');
    }

    /**
     * Тест фильтрации по одному свойству с одним значением
     */
    public function test_filter_by_single_property_value(): void
    {
        $response = $this->getJson('/api/products?properties[color][]=red');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'products')
            ->assertJsonPath('products.0.name', 'Red T-Shirt')
            ->assertJsonPath('products.1.name', 'Red Hoodie');
    }

    /**
     * Тест фильтрации по одному свойству с несколькими значениями
     */
    public function test_filter_by_single_property_multiple_values(): void
    {
        $response = $this->getJson('/api/products?properties[color][]=red&properties[color][]=blue');

        $response->assertStatus(200)
            ->assertJsonCount(4, 'products')
            ->assertJsonPath('pagination.total', 4);
    }

    /**
     * Тест фильтрации по нескольким свойствам
     */
    public function test_filter_by_multiple_properties(): void
    {
        $response = $this->getJson('/api/products?properties[color][]=red&properties[size][]=L');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'products') // 1 красный товар размера L
            ->assertJsonPath('products.0.name', 'Red Hoodie');
    }

    /**
     * Тест пагинации результатов
     */
    public function test_pagination(): void
    {
        for ($i = 0; $i < 15; $i++) {
            Product::create(
                [
                    'name' => "Extra Product {$i}",
                    'price' => 10.99 + $i,
                    'quantity' => 10 + $i,
                ]
            );
        }

        $response = $this->getJson('/api/products?per_page=10&page=2');

        $response->assertStatus(200)
            ->assertJsonPath('pagination.current_page', 2)
            ->assertJsonPath('pagination.per_page', 10);
    }

    /**
     * Тест отсутствия результатов при несуществующих значениях свойств
     */
    public function test_no_results_with_nonexistent_property_values(): void
    {
        $response = $this->getJson('/api/products?properties[color][]=purple');

        $response->assertStatus(200)
            ->assertJsonCount(0, 'products');
    }

    /**
     * Заполнение базы тестовыми данными
     */
    private function seedTestData(): void
    {
        /**@var Property $colorProperty */
        $colorProperty = Property::create(['name' => 'color']);
        $sizeProperty = Property::create(['name' => 'size']);
        $materialProperty = Property::create(['name' => 'material']);

        $red = PropertyValue::create(['property_id' => $colorProperty->getId(), 'value' => 'red']);
        $blue = PropertyValue::create(['property_id' => $colorProperty->getId(), 'value' => 'blue']);
        $green = PropertyValue::create(['property_id' => $colorProperty->getId(), 'value' => 'green']);

        $sizeS = PropertyValue::create(['property_id' => $colorProperty->getId(), 'value' => 'S']);
        $sizeM = PropertyValue::create(['property_id' => $sizeProperty->getId(), 'value' => 'M']);
        $sizeL = PropertyValue::create(['property_id' => $sizeProperty->getId(), 'value' => 'L']);

        $cotton = PropertyValue::create(['property_id' => $materialProperty->getId(), 'value' => 'cotton']);
        $polyester = PropertyValue::create(['property_id' => $materialProperty->getId(), 'value' => 'polyester']);

        $redTShirt = Product::create(['name' => 'Red T-Shirt', 'price' => 19.99, 'quantity' => 50]);
        $redTShirt->propertyValues()->attach([$red->getId(), $sizeS->getId(), $cotton->getId()]);

        $redHoodie = Product::create(['name' => 'Red Hoodie', 'price' => 39.99, 'quantity' => 30]);
        $redHoodie->propertyValues()->attach([$red->getId(), $sizeL->getId(), $cotton->getId()]);

        $blueTShirt = Product::create(['name' => 'Blue T-Shirt', 'price' => 19.99, 'quantity' => 40]);
        $blueTShirt->propertyValues()->attach([$blue->getId(), $sizeM->getId(), $cotton->getId()]);

        $blueJacket = Product::create(['name' => 'Blue Jacket', 'price' => 79.99, 'quantity' => 20]);
        $blueJacket->propertyValues()->attach([$blue->getId(), $sizeL->getId(), $polyester->getId()]);

        $greenShorts = Product::create(['name' => 'Green Shorts', 'price' => 29.99, 'quantity' => 35]);
        $greenShorts->propertyValues()->attach([$green->getId(), $sizeM->getId(), $cotton->getId()]);

        $greenCap = Product::create(['name' => 'Green Cap', 'price' => 14.99, 'quantity' => 60]);
        $greenCap->propertyValues()->attach([$green->getId(), $sizeS->getId(), $polyester->getId()]);
    }
}