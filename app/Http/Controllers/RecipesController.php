<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Response;
use App\Http\Requests\StoreRecipesRequest;
use App\Http\Requests\UpdateRecipesRequest;
use App\Models\Recipes;
use Illuminate\Support\Facades\Gate;

class RecipesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Recipes
        //abort_if(Gate::denies('recipes-view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $recipes = Recipes::all();
        return view('recipes.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //abort_if(Gate::denies('recipes-create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('recipes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecipesRequest $request)
    {
        //
        //$this->authorize('recipes-edit');
        //abort_if(Gate::denies('recipes-edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        Recipes::create($request->validated());

        return redirect()->route('recipes.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Recipes $recipes)
    {

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($recipe)
//    public function edit(Request $request)
    {

        $recipe = Recipes::where('id', $recipe)->first();
        //dd($request->get);
        return view('recipes.edit', compact('recipe'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecipesRequest $request, Recipes $recipes)
    {
        //$this->authorize('recipes-edit');
        $recipes->update($request->validated());

        return redirect()->route('recipes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipes $recipes)
    {
        //
        //$this->authorize('recipes-delete');
        $recipes->delete();

        return redirect()->route('recipes.index');
    }
}
