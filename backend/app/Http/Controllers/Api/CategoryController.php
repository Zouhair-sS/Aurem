<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = auth('api')->user();

        // Sync any new system defaults that were added after the user registered
        $systemDefaults = Category::whereNull('user_id')->get();
        $userCategoryNames = $user->categories()->where('is_system_default', true)->pluck('name')->toArray();

        foreach ($systemDefaults as $default) {
            if (!in_array($default->name, $userCategoryNames)) {
                $user->categories()->create([
                    'name' => $default->name,
                    'type' => $default->type,
                    'icon' => $default->icon,
                    'color' => $default->color,
                    'is_system_default' => true,
                ]);
            }
        }

        // Only return the user's own categories (includes copied defaults + custom)
        $categories = $user->categories()->latest()->get();

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:income,expense,both'],
            'color' => ['nullable', 'string', 'max:20'],
            'icon' => ['nullable', 'string', 'max:10'],
        ]);

        $category = auth('api')->user()->categories()->create($validated);

        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): JsonResponse
    {
        // Allow viewing system default categories (user_id IS NULL) or own categories
        abort_unless($category->user_id === null || $category->user_id === auth('api')->id(), 403);

        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        // Only allow editing own categories, not system defaults
        abort_unless($category->user_id !== null && $category->user_id === auth('api')->id(), 403);

        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'type' => ['sometimes', 'required', 'in:income,expense,both'],
            'color' => ['nullable', 'string', 'max:20'],
            'icon' => ['nullable', 'string', 'max:10'],
        ]);

        $category->update($validated);

        return response()->json($category->refresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        // Only allow deleting own categories that are NOT system defaults
        abort_unless(
            $category->user_id !== null 
            && $category->user_id === auth('api')->id() 
            && !$category->is_system_default, 
            403, 
            'Vous ne pouvez pas supprimer une catégorie par défaut.'
        );

        $category->delete();

        return response()->json([], 204);
    }
}
