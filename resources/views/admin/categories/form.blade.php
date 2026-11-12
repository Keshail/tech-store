@extends('admin.layout')

@section('title', $category->exists ? 'Изменить категорию' : 'Новая категория')
@section('crumb', 'Категории')
@section('heading', $category->exists ? 'Изменить категорию' : 'Новая категория')

@section('content')
    <form class="admin-form" method="post"
          action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
        @csrf
        @if($category->exists)
            @method('PUT')
        @endif

        <div class="field">
            <label for="name">Название</label>
            <input id="name" type="text" name="name" value="{{ old('name', $category->name) }}" required maxlength="120">
            @error('name') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="field">
            <label for="slug">Slug (латиницей, необязательно)</label>
            <input id="slug" type="text" name="slug" value="{{ old('slug', $category->slug) }}" maxlength="140"
                   placeholder="сгенерируется из названия">
            @error('slug') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="field">
            <label for="description">Описание</label>
            <textarea id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
            @error('description') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <button class="btn" type="submit">Сохранить</button>
            <a class="btn btn-ghost" href="{{ route('admin.categories.index') }}">Отмена</a>
        </div>
    </form>
@endsection
