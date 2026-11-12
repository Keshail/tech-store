@extends('admin.layout')

@section('title', 'Категории')
@section('crumb', 'Категории')
@section('heading', 'Категории')

@section('actions')
    <a class="btn" href="{{ route('admin.categories.create') }}">+ Добавить категорию</a>
@endsection

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Название</th>
            <th>Slug</th>
            <th>Товаров</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td><code>{{ $category->slug }}</code></td>
                <td>{{ $category->products_count }}</td>
                <td class="actions-cell">
                    <a class="btn btn-sm btn-ghost" href="{{ route('admin.categories.edit', $category) }}">Изменить</a>
                    <form method="post" action="{{ route('admin.categories.destroy', $category) }}"
                          onsubmit="return confirm('Удалить категорию «{{ $category->name }}»?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Удалить</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="muted">Категорий пока нет.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div class="pagination">{{ $categories->links('partials.pagination') }}</div>
@endsection
