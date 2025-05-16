<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int           $id
 * @property int           $product_id
 * @property int           $property_value_id
 *
 * @property Product       $product
 * @property PropertyValue $propertyValue
 */
class ProductPropertyValue extends Model
{
    use HasFactory;

    protected $table = 'product_property_value';
    protected $fillable = ['product_id', 'property_value_id'];
    public $timestamps = false;

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function propertyValue(): BelongsTo
    {
        return $this->belongsTo(PropertyValue::class, 'property_value_id');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return ProductPropertyValue
     */
    public function setId(int $id): ProductPropertyValue
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }

    /**
     * @param int $product_id
     *
     * @return ProductPropertyValue
     */
    public function setProductId(int $product_id): ProductPropertyValue
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getPropertyValueId(): int
    {
        return $this->property_value_id;
    }

    /**
     * @param int $property_value_id
     *
     * @return ProductPropertyValue
     */
    public function setPropertyValueId(int $property_value_id): ProductPropertyValue
    {
        $this->property_value_id = $property_value_id;

        return $this;
    }
}