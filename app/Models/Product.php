<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property int                            $id
 * @property string                         $name
 * @property float                          $price
 * @property int                            $quantity
 * @property Carbon                         $created_at
 * @property Carbon                         $updated_at
 *
 * @property PropertyValue[]|Collection     $propertyValues
 */
class Product extends Model
{
    use HasFactory;
    use HasTimestamps;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'quantity',
    ];

    protected $casts = [
        'price' => 'float',
        'quantity' => 'integer',
    ];

    public function propertyValues(): BelongsToMany
    {
        return $this->belongsToMany(
            PropertyValue::class,
            'product_property_value',
            'product_id',
            'property_value_id'
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}