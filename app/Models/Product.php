<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'brand', 'description',
        'price', 'stock', 'image', 'is_featured',
    ];

    protected $casts = [
        'price'       => 'decimal:2',
        'stock'       => 'integer',
        'is_featured' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Фильтры каталога: категория, поиск, диапазон цен, сортировка.
     *
     * @param array<string, mixed> $filters
     */
    public function scopeFiltered(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['category'] ?? null, function (Builder $q, string $slug) {
                $q->whereHas('category', fn (Builder $c) => $c->where('slug', $slug));
            })
            ->when($filters['q'] ?? null, function (Builder $q, string $term) {
                $q->where(function (Builder $inner) use ($term) {
                    $inner->where('name', 'like', "%{$term}%")
                        ->orWhere('brand', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%");
                });
            })
            ->when($filters['min'] ?? null, fn (Builder $q, $min) => $q->where('price', '>=', (float) $min))
            ->when($filters['max'] ?? null, fn (Builder $q, $max) => $q->where('price', '<=', (float) $max))
            ->when($filters['sort'] ?? null, fn (Builder $q, string $sort) => match ($sort) {
                'price_asc'  => $q->orderBy('price'),
                'price_desc' => $q->orderByDesc('price'),
                'name'       => $q->orderBy('name'),
                'new'        => $q->orderByDesc('created_at'),
                default      => $q->orderByDesc('is_featured')->orderBy('name'),
            }, fn (Builder $q) => $q->orderByDesc('is_featured')->orderBy('name'));
    }

    public function imageUrl(): string
    {
        if ($this->image) {
            // демо-картинки лежат в public/img, загруженные — на диске public
            return str_starts_with($this->image, 'img/')
                ? asset($this->image)
                : Storage::disk('public')->url($this->image);
        }

        return asset('img/placeholder.svg');
    }
}
