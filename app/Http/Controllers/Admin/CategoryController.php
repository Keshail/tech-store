<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('products')->orderBy('name')->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.form', ['category' => new Category()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Категория добавлена');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $this->validateData($request, $category->id);
        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Категория обновлена');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return back()->with('error', 'Нельзя удалить категорию, в которой есть товары');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Категория удалена');
    }

    /**
     * @return array<string, string|null>
     */
    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:120'],
            'slug'        => [
                'nullable', 'string', 'max:140', 'regex:/^[a-z0-9-]+$/',
                Rule::unique('categories', 'slug')->ignore($ignoreId),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [
            'slug.regex' => 'Slug может содержать только строчные латинские буквы, цифры и дефис',
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);

        return $data;
    }
}
