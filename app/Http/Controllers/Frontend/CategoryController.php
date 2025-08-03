<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        if (!$category->is_active) {
            abort(404);
        }

        $news = $category->publishedNews()
            ->with(['user', 'tags'])
            ->latest('published_at')
            ->paginate(12);

        return view('frontend.categories.show', compact('category', 'news'));
    }
}
