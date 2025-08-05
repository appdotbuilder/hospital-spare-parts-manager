<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\SparePart
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $quantity
 * @property string $storage_location
 * @property float $price
 * @property int $minimum_stock
 * @property int|null $supplier_id
 * @property string|null $description
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Supplier|null $supplier
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UsageRecord> $usageRecords
 * @property-read int|null $usage_records_count
 * @property-read bool $is_low_stock
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|SparePart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SparePart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SparePart query()
 * @method static \Illuminate\Database\Eloquent\Builder|SparePart whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SparePart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SparePart whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SparePart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SparePart whereMinimumStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SparePart whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SparePart wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SparePart whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SparePart whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SparePart whereStorageLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SparePart whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SparePart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SparePart active()
 * @method static \Illuminate\Database\Eloquent\Builder|SparePart lowStock()
 * @method static \Database\Factories\SparePartFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class SparePart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'code',
        'quantity',
        'storage_location',
        'price',
        'minimum_stock',
        'supplier_id',
        'description',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'minimum_stock' => 'integer',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var list<string>
     */
    protected $appends = [
        'is_low_stock',
    ];

    /**
     * Get the supplier for this spare part.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the usage records for this spare part.
     */
    public function usageRecords(): HasMany
    {
        return $this->hasMany(UsageRecord::class);
    }

    /**
     * Check if the spare part stock is low.
     *
     * @return bool
     */
    public function getIsLowStockAttribute(): bool
    {
        return $this->quantity <= $this->minimum_stock;
    }

    /**
     * Scope a query to only include active spare parts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include low stock spare parts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLowStock($query)
    {
        return $query->whereRaw('quantity <= minimum_stock');
    }
}