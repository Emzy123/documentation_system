<?php

namespace App\Http\Controllers;

use App\Models\DocumentCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = DocumentCategory::paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:document_categories',
            'description' => 'nullable|string|max:500',
        ]);

        DocumentCategory::create($request->only('name', 'description'));

        return redirect()->back()->with('success', 'Category created successfully.');
    }

    public function update(Request $request, DocumentCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:document_categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
        ]);

        $category->update($request->only('name', 'description'));

        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    public function destroy(DocumentCategory $category)
    {
        if ($category->documents()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete category because it has associated documents.');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
