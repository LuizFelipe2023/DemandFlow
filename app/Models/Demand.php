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
        'status',
        'priority',
        'demand_date',
    ];

    protected $casts = [
        'demand_date' => 'date',
    ];

    /**
     * Histórico de alterações da demanda.
     */
    public function histories(): HasMany
    {
        return $this->hasMany(DemandHistory::class);
    }

    /**
     * Usuário responsável pela execução da demanda.
     */
    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }
}