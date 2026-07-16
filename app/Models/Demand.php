<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Demand extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'requester',
        'responsible_id',
        'system',
        'priority',
        'demand_date',
        'is_audited',
        'audit_approved',
        'justification',
    ];

    protected $casts = [
        'demand_date'    => 'date',
        'is_audited'     => 'boolean',
        'audit_approved' => 'boolean',
    ];

    public function histories(): HasMany
    {
        return $this->hasMany(DemandHistory::class);
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }
}