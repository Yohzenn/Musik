<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ApiKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $apiKeys = $request->user()->apiKeys()->latest()->get();

        return Inertia::render('ApiKeys/Index', [
            'apiKeys' => $apiKeys->map(fn (ApiKey $apiKey) => [
                'id' => $apiKey->id,
                'slug' => $apiKey->slug,
                'name' => $apiKey->name,
                'key' => $apiKey->key,
                'created_at' => $apiKey->created_at->format('d/m/Y H:i'),
            ]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('ApiKeys/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $request->user()->apiKeys()->create([
            'slug' => 'key-' . Str::uuid(),
            'name' => $validated['name'],
            'key' => Str::random(64),
        ]);

        return redirect()->route('api-keys.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApiKey $apiKey)
    {
        $this->authorize('update', $apiKey);

        return Inertia::render('ApiKeys/Edit', [
            'apiKey' => [
                'slug' => $apiKey->slug,
                'name' => $apiKey->name,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ApiKey $apiKey)
    {
        $this->authorize('update', $apiKey);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $apiKey->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('api-keys.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApiKey $apiKey)
    {
        $this->authorize('delete', $apiKey);

        $apiKey->delete();

        return redirect()->back();
    }
}

