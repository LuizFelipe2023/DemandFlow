<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemandHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'demand_id',
        'user_id',       
        'user_name',     
        'type',
        'description',
        'old_status',
        'new_status',
    ];

    /**
     * Os atributos que devem ser convertidos (Casting).
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

   
    public function demand(): BelongsTo
    {
        return $this->belongsTo(Demand::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getAuthorNameAttribute(): string
    {
        return $this->user?->name ?? $this->user_name ?? 'Sistema';
    }
}