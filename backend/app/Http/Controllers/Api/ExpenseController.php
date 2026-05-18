<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = auth('api')->user()->expenses()->with('category')->latest('spent_at');

        if ($request->filled('month')) {
            $query->whereMonth('spent_at', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('spent_at', $request->year);
        }

        return response()->json($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = auth('api')->user();

        $validated = $request->validate([
            'category_id' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id')->where(fn ($query) => $query
                    ->where(function ($q) use ($user) {
                        $q->whereNull('user_id')
                          ->orWhere('user_id', $user->id);
                    })
                    ->whereIn('type', ['expense', 'both'])),
            ],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:255'],
            'spent_at' => ['required', 'date'],
        ]);

        $expense = $user->expenses()->create($validated);

        return response()->json($expense->load('category'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense): JsonResponse
    {
        abort_unless($expense->user_id === auth('api')->id(), 403);

        return response()->json($expense->load('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense): JsonResponse
    {
        abort_unless($expense->user_id === auth('api')->id(), 403);
        $user = auth('api')->user();

        $validated = $request->validate([
            'category_id' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id')->where(fn ($query) => $query
                    ->where(function ($q) use ($user) {
                        $q->whereNull('user_id')
                          ->orWhere('user_id', $user->id);
                    })
                    ->whereIn('type', ['expense', 'both'])),
            ],
            'amount' => ['sometimes', 'required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:255'],
            'spent_at' => ['sometimes', 'required', 'date'],
        ]);

        $expense->update($validated);

        return response()->json($expense->refresh()->load('category'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense): JsonResponse
    {
        abort_unless($expense->user_id === auth('api')->id(), 403);
        $expense->delete();

        return response()->json([], 204);
    }
}
