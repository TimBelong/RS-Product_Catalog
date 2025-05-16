<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Property;
use App\Models\PropertyValue;
use App\Models\ProductPropertyValue;

class ProductCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colorProperty = Property::create(['name' => 'Цвет']);
        $sizeProperty = Property::create(['name' => 'Размер']);
        $materialProperty = Property::create(['name' => 'Материал']);
        $brandProperty = Property::create(['name' => 'Бренд']);

        $redValue = PropertyValue::create(['property_id' => $colorProperty->getId(), 'value' => 'Красный']);
        $blueValue = PropertyValue::create(['property_id' => $colorProperty->getId(), 'value' => 'Синий']);
        $greenValue = PropertyValue::create(['property_id' => $colorProperty->getId(), 'value' => 'Зеленый']);
        $blackValue = PropertyValue::create(['property_id' => $colorProperty->getId(), 'value' => 'Черный']);
        $whiteValue = PropertyValue::create(['property_id' => $colorProperty->getId(), 'value' => 'Белый']);

        $smallValue = PropertyValue::create(['property_id' => $sizeProperty->getId(), 'value' => 'S']);
        $mediumValue = PropertyValue::create(['property_id' => $sizeProperty->getId(), 'value' => 'M']);
        $largeValue = PropertyValue::create(['property_id' => $sizeProperty->getId(), 'value' => 'L']);
        $xlargeValue = PropertyValue::create(['property_id' => $sizeProperty->getId(), 'value' => 'XL']);

        $cottonValue = PropertyValue::create(['property_id' => $materialProperty->getId(), 'value' => 'Хлопок']);
        $polyesterValue = PropertyValue::create(['property_id' => $materialProperty->getId(), 'value' => 'Полиэстер']);
        $leatherValue = PropertyValue::create(['property_id' => $materialProperty->getId(), 'value' => 'Кожа']);
        $denimValue = PropertyValue::create(['property_id' => $materialProperty->getId(), 'value' => 'Деним']);

        $nikeValue = PropertyValue::create(['property_id' => $brandProperty->getId(), 'value' => 'Nike']);
        $adidasValue = PropertyValue::create(['property_id' => $brandProperty->getId(), 'value' => 'Adidas']);
        $pumaValue = PropertyValue::create(['property_id' => $brandProperty->getId(), 'value' => 'Puma']);
        $reebokValue = PropertyValue::create(['property_id' => $brandProperty->getId(), 'value' => 'Reebok']);

        $tshirt1 = Product::create(
            [
                'name' => 'Футболка спортивная Nike',
                'price' => 29.99,
                'quantity' => 100,
            ]
        );

        ProductPropertyValue::create(['product_id' => $tshirt1->getId(), 'property_value_id' => $redValue->getId()]);
        ProductPropertyValue::create(['product_id' => $tshirt1->getId(), 'property_value_id' => $mediumValue->getId()]);
        ProductPropertyValue::create(['product_id' => $tshirt1->getId(), 'property_value_id' => $cottonValue->getId()]);
        ProductPropertyValue::create(['product_id' => $tshirt1->getId(), 'property_value_id' => $nikeValue->getId()]);

        $tshirt2 = Product::create(
            [
                'name' => 'Футболка Adidas',
                'price' => 24.99,
                'quantity' => 150,
            ]
        );

        ProductPropertyValue::create(['product_id' => $tshirt2->getId(), 'property_value_id' => $blueValue->getId()]);
        ProductPropertyValue::create(['product_id' => $tshirt2->getId(), 'property_value_id' => $largeValue->getId()]);
        ProductPropertyValue::create(
            ['product_id' => $tshirt2->getId(), 'property_value_id' => $polyesterValue->getId()]
        );
        ProductPropertyValue::create(['product_id' => $tshirt2->getId(), 'property_value_id' => $adidasValue->getId()]);

        $jeans = Product::create(
            [
                'name' => 'Джинсы классические',
                'price' => 59.99,
                'quantity' => 75,
            ]
        );

        ProductPropertyValue::create(['product_id' => $jeans->getId(), 'property_value_id' => $blueValue->getId()]);
        ProductPropertyValue::create(['product_id' => $jeans->getId(), 'property_value_id' => $largeValue->getId()]);
        ProductPropertyValue::create(['product_id' => $jeans->getId(), 'property_value_id' => $denimValue->getId()]);
        ProductPropertyValue::create(['product_id' => $jeans->getId(), 'property_value_id' => $pumaValue->getId()]);

        $jacket = Product::create(
            [
                'name' => 'Куртка кожаная',
                'price' => 129.99,
                'quantity' => 50,
            ]
        );

        ProductPropertyValue::create(['product_id' => $jacket->getId(), 'property_value_id' => $blackValue->getId()]);
        ProductPropertyValue::create(['product_id' => $jacket->getId(), 'property_value_id' => $xlargeValue->getId()]);
        ProductPropertyValue::create(['product_id' => $jacket->getId(), 'property_value_id' => $leatherValue->getId()]);
        ProductPropertyValue::create(['product_id' => $jacket->getId(), 'property_value_id' => $reebokValue->getId()]);

        for ($i = 1; $i <= 46; $i++) {
            $product = Product::create(
                [
                    'name' => "Товар {$i}",
                    'price' => rand(999, 9999) / 100,
                    'quantity' => rand(10, 200),
                ]
            );

            $colorValues = [$redValue->getId(), $blueValue->getId(), $greenValue->getId(), $blackValue->getId(), $whiteValue->getId()];
            $sizeValues = [$smallValue->getId(), $mediumValue->getId(), $largeValue->getId(), $xlargeValue->getId()];
            $materialValues = [$cottonValue->getId(), $polyesterValue->getId(), $leatherValue->getId(), $denimValue->getId()];
            $brandValues = [$nikeValue->getId(), $adidasValue->getId(), $pumaValue->getId(), $reebokValue->getId()];

            ProductPropertyValue::create(
                [
                    'product_id' => $product->getId(),
                    'property_value_id' => $colorValues[array_rand($colorValues)],
                ]
            );

            ProductPropertyValue::create(
                [
                    'product_id' => $product->getId(),
                    'property_value_id' => $sizeValues[array_rand($sizeValues)],
                ]
            );

            ProductPropertyValue::create(
                [
                    'product_id' => $product->getId(),
                    'property_value_id' => $materialValues[array_rand($materialValues)],
                ]
            );

            ProductPropertyValue::create(
                [
                    'product_id' => $product->getId(),
                    'property_value_id' => $brandValues[array_rand($brandValues)],
                ]
            );
        }
    }
}