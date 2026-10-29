<?php

namespace App\Models\Concerns;

use App\Support\Tenancy\TenantContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait BelongsToTenant
{
    public static function bootBelongsToTenant(): void
    {
        // 1. Otomatis nambahin WHERE id_penyelenggara = X setiap kali query
        static::addGlobalScope('tenant', function (Builder $builder): void {
            $context = app(TenantContext::class);
            if ($context->has()) {
                $builder->where($builder->qualifyColumn('id_penyelenggara'), $context->id());
            }
        });

        // 2. Otomatis ngisi id_penyelenggara pas bikin data baru
        static::creating(function (Model $model): void {
            $context = app(TenantContext::class);
            if ($context->has() && empty($model->getAttribute('id_penyelenggara'))) {
                $model->setAttribute('id_penyelenggara', $context->id());
            }
        });
    }
}