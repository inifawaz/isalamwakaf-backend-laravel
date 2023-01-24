<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleDetailsResource;
use App\Http\Resources\ArticleItemResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            if ($request->user()->hasRole('Admin')) {
                if ($request->has('search')) {
                    return response()->json([
                        "data" => ArticleItemResource::collection(Article::where('title', 'LIKE', "%" . $request->search . "%")->orderBy('id', 'desc')->get())
                    ]);
                }
                if ($request->has('type')) {
                    if ($request->type == 'hidden') {
                        return response()->json([
                            "data" => ArticleItemResource::collection(Article::where('is_hidden', 1)->latest()->get())
                        ]);
                    }
                    if ($request->type == 'selected') {
                        return response()->json([
                            "data" => ArticleItemResource::collection(Article::where('is_selected', 1)->latest()->get())
                        ]);
                    }
                }
                if ($request->has('category')) {
                    return response()->json([
                        "data" => ArticleItemResource::collection(Article::where('category_id', $request->category)->latest()->get())
                    ]);
                }
                return response()->json([
                    "data" => ArticleItemResource::collection(Article::latest()->orderBy('id', 'desc')->get())
                ]);
            }
        }

        if ($request->has('type')) {

            if ($request->type == 'selected') {
                return response()->json([
                    "data" => ArticleItemResource::collection(Article::where('is_hidden', 0)->where('is_selected', 1)->latest()->get())
                ]);
            }
        }
        if ($request->has('category')) {
            return response()->json([
                "data" => ArticleItemResource::collection(Article::where('is_hidden', 0)->where('category_id', $request->category)->latest()->get())
            ]);
        }

        return response()->json([
            "data" => ArticleItemResource::collection(Article::where('is_hidden', 0)->latest()->orderBy('id', 'desc')->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $article = new Article();
        if ($request->featured_image_url == 'null') {
            Storage::disk('public')->delete('featured-images/article/' . $article->featured_image_url);
            $article->featured_image_url = null;
        }
        if ($request->hasFile('featured_image_file')) {
            Storage::disk('public')->delete('featured-images/article/' . $article->featured_image_url);
            $file = $request->file('featured_image_file');
            $fileName = now()->format('Y_m_d_His') . '_' . Str::slug($request->title, '_') . '.' . $file->extension();
            $file->storeAs('featured-images/article', $fileName, ['disk' => 'public']);
            $article->featured_image_url = $fileName;
        }
        $article->slug = Str::slug($request->title);
        $article->creator_id = Auth::user()->id;
        $article->category_id = $request->category_id == 'null' ? null : $request->category_id;
        $article->title = $request->title;
        $article->content = $request->content;
        $article->is_hidden = $request->is_hidden;
        $article->is_selected = $request->is_selected;
        $article->save();
        return response()->json([
            "message" => "Berhasil membuat artikel baru",
            "data" => new ArticleDetailsResource($article->fresh())
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return response()->json([
            "data" =>  new ArticleDetailsResource($article)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        if ($request->featured_image_url == 'null') {
            Storage::disk('public')->delete('featured-images/article/' . $article->featured_image_url);
            $article->featured_image_url = null;
        }
        if ($request->hasFile('featured_image_file')) {
            Storage::disk('public')->delete('featured-images/article/' . $article->featured_image_url);
            $file = $request->file('featured_image_file');
            $fileName = now()->format('Y_m_d_His') . '_' . Str::slug($request->title, '_') . '.' . $file->extension();
            $file->storeAs('featured-images/article', $fileName, ['disk' => 'public']);
            $article->featured_image_url = $fileName;
        }
        $article->category_id = $request->category_id == 'null' ? null : $request->category_id;
        $article->title = $request->title;
        $article->content = $request->content;
        $article->is_hidden = $request->is_hidden;
        $article->is_selected = $request->is_selected;
        $article->update();
        return response()->json([
            "message" => "Berhasil merubah artikel",
            "data" => new ArticleDetailsResource($article->fresh())
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json([
            "message" => 'Berhasil menghapus artikel'
        ]);
    }
}
