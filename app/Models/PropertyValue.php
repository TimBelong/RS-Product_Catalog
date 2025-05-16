<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property int                        $id
 * @property int                        $property_id
 * @property string                     $value
 * @property Carbon                     $created_at
 * @property Carbon                     $updated_at
 *
 * @property Property                   $property
 * @property Product[]|Collection       $products
 */
class PropertyValue extends Model
{
    use HasFactory;
    use HasTimestamps;

    protected $table = 'property_values';

    protected $fillable = [
        'property_id',
        'value',
    ];

    /**
     * Связь с свойством, которому принадлежит это значение.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    /**
     * Связь с товарами, имеющими это значение свойства.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_property_value',
            'property_value_id',
            'product_id'
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

    public function getPropertyId(): int
    {
        return $this->property_id;
    }

    public function setPropertyId(int $propertyId): void
    {
        $this->property_id = $propertyId;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}