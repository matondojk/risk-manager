<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Risk extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, LogsActivity, HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'assessment_date' => 'date',
        'next_review_date' => 'date',
        'risk_acceptance' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logUnguarded();
    }

    protected static function booted()
    {
        static::creating(function ($risk) {
            if (empty($risk->code)) {
                $lastRisk = Risk::latest('id')->first();
                $nextId = $lastRisk ? $lastRisk->id + 1 : 1;
                $risk->code = 'RSK-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    public function category(): BelongsTo { return $this->belongsTo(Category::class); }
    public function department(): BelongsTo { return $this->belongsTo(Department::class); }
    public function owner(): BelongsTo { return $this->belongsTo(User::class, 'owner_id'); }
    public function actionPlans(): HasMany { return $this->hasMany(ActionPlan::class); }

    protected function inherentScore(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->inherent_probability * $this->inherent_impact,
        );
    }

    protected function inherentLevel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->calculateRiskLevel($this->inherent_score),
        );
    }

    protected function residualScore(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->residual_probability * $this->residual_impact,
        );
    }

    protected function residualLevel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->calculateRiskLevel($this->residual_score),
        );
    }

    private function calculateRiskLevel($score): ?string
    {
        if (!$score) return null;
        if ($score >= 1 && $score <= 4) return 'Baixo';
        if ($score >= 5 && $score <= 9) return 'Médio';
        if ($score >= 10 && $score <= 16) return 'Alto';
        return 'Crítico';
    }
}
