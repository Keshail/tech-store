@extends('admin.layout')

@section('title', $product->exists ? 'Изменить товар' : 'Новый товар')
@section('crumb', 'Товары')
@section('heading', $product->exists ? 'Изменить товар' : 'Новый товар')

@section('content')
    <form class="admin-form" method="post" enctype="multipart/form-data"
          action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}">
        @csrf
        @if($product->exists)
            @method('PUT')
        @endif

        <div class="field">
            <label for="name">Название</label>
            <input id="name" type="text" name="name" value="{{ old('name', $product->name) }}" required maxlength="150">
            @error('name') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="field-row">
            <div class="field">
                <label for="category_id">Категория</label>
                <select id="category_id" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            @selected((int) old('category_id', $product->category_id) === $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label for="brand">Бренд</label>
                <input id="brand" type="text" name="brand" value="{{ old('brand', $product->brand) }}" maxlength="80">
                @error('brand') <span class="field-error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="field-row">
            <div class="field">
                <label for="price">Цена, ₽</label>
                <input id="price" type="number" name="price" step="0.01" min="0" required
                       value="{{ old('price', $product->price) }}">
                @error('price') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label for="stock">На складе, шт.</label>
                <input id="stock" type="number" name="stock" min="0" required
                       value="{{ old('stock', $product->stock ?? 0) }}">
                @error('stock') <span class="field-error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="field">
            <label for="slug">Slug (необязательно)</label>
            <input id="slug" type="text" name="slug" value="{{ old('slug', $product->slug) }}" maxlength="170"
                   placeholder="сгенерируется из названия">
            @error('slug') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="field">
            <label for="description">Описание</label>
            <textarea id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
            @error('description') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="field">
            <label for="image">Изображение</label>
            @if($product->image)
                <div class="current-image">
                    <img src="{{ $product->imageUrl() }}" alt="Текущее изображение">
                </div>
            @endif
            <input id="image" type="file" name="image" accept="image/*">
            <small class="muted">JPG/PNG/SVG до 2 МБ. Если не выбирать — останется текущее.</small>
            @error('image') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <label class="checkbox">
            <input type="checkbox" name="is_featured" value="1"
                @checked(old('is_featured', $product->is_featured))>
            Показывать в блоке «Хиты продаж»
        </label>

        <div class="form-actions">
            <button class="btn" type="submit">Сохранить</button>
            <a class="btn btn-ghost" href="{{ route('admin.products.index') }}">Отмена</a>
        </div>
    </form>
@endsection
