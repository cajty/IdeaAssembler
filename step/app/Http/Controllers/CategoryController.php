<?php

namespace App\Http\Controllers;

use App\Services\ICategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(ICategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function showCategory()
    {
        $categories = $this->categoryService->getAllCategories();
        return response()->json($categories);
    }

    public function storeCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $categorie = $this->categoryService->createCategory([
            'name' => $request->name,
        ]);

        return response()->json($categorie);
    }

    public function deleteCategory($id)
    {
        $this->categoryService->deleteCategory($id);
        return response()->json(['message' => 'Category deleted successfully']);
    }

    public function editCategory(Request $request, $id)
    {
        $categorie = $this->categoryService->updateCategory($id, ['name' => $request->name]);
        return response()->json(['message' => 'Category updated successfully']);
    }
}