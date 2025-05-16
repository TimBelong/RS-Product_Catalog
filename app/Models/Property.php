<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int                        $id
 * @property string                     $name
 * @property Carbon                     $created_at
 * @property Carbon                     $updated_at
 *
 * @property PropertyValue[]|Collection $values
 */
class Property extends Model
{
    use HasFactory;
    use HasTimestamps;

    protected $table = 'properties';

    protected $fillable = [
        'name',
    ];

    public function values(): HasMany
    {
        return $this->hasMany(PropertyValue::class, 'property_id');
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
}