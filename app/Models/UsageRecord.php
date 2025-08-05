<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UsageRecord
 *
 * @property int $id
 * @property int $spare_part_id
 * @property int $user_id
 * @property int $quantity_used
 * @property string $purpose
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon $usage_date
 * @property string $status
 * @property int|null $approved_by
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\SparePart $sparePart
 * @property-read \App\Models\User $user
 * @property-read \App\Models\User|null $approver
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|UsageRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UsageRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UsageRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|UsageRecord whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsageRecord whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsageRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsageRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsageRecord whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsageRecord wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsageRecord whereQuantityUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsageRecord whereSparePartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsageRecord whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsageRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsageRecord whereUsageDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsageRecord whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UsageRecord pending()
 * @method static \Illuminate\Database\Eloquent\Builder|UsageRecord approved()
 * @method static \Database\Factories\UsageRecordFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class UsageRecord extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'spare_part_id',
        'user_id',
        'quantity_used',
        'purpose',
        'notes',
        'usage_date',
        'status',
        'approved_by',
        'approved_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'usage_date' => 'date',
        'approved_at' => 'datetime',
        'quantity_used' => 'integer',
    ];

    /**
     * Get the spare part for this usage record.
     */
    public function sparePart(): BelongsTo
    {
        return $this->belongsTo(SparePart::class);
    }

    /**
     * Get the user who recorded this usage.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who approved this usage.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope a query to only include pending records.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include approved records.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}