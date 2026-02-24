<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MonthlyStatistic extends Model
{
    protected $fillable = [
        'year',
        'month',
        'patients_served',
        'utilized_funds',
        'partner_facilities',
        'as_of_date',
        'is_active',
    ];

    protected $casts = [
        'year' => 'integer',
        'month' => 'integer',
        'patients_served' => 'integer',
        'utilized_funds' => 'decimal:2',
        'partner_facilities' => 'integer',
        'as_of_date' => 'date',
        'is_active' => 'boolean'
    ];

    public function getMonthNameAttribute(): string
    {
        return Carbon::create()->month($this->month)->format('F');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeLatestMonth(Builder $query): Builder
    {
        return $query->orderByDesc('year')
                    ->orderByDesc('month');
    }
}
