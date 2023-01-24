<?php

namespace App\Http\Controllers;

use App\Models\ArticleCategory;
use App\Http\Requests\StoreArticleCategoryRequest;
use App\Http\Requests\UpdateArticleCategoryRequest;
use Illuminate\Support\Str;

class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            "data" => ArticleCategory::latest()->orderBy('id', 'desc')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleCategoryRequest $request)
    {
        $category = ArticleCategory::create([
            "name" => $request->name,
            'slug' => Str::slug($request->name)
        ]);
        return response()->json([
            "message" => 'Berhasil membuat kategori artikel baru'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ArticleCategory  $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ArticleCategory $articleCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArticleCategoryRequest  $request
     * @param  \App\Models\ArticleCategory  $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleCategoryRequest $request, ArticleCategory $articleCategory)
    {
        $articleCategory->name = $request->name;
        $articleCategory->slug = Str::slug($request->name);
        $articleCategory->update();
        return response()->json([
            'message' => 'Berhasil merubah kategori artikel'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ArticleCategory  $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArticleCategory $articleCategory)
    {
        $articleCategory->delete();

        return response()->json([
            'message' => 'Berhasil menghapus kategori artikel'
        ]);
    }
}
