<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['Index', 'detail']);
    }

    public function index()
    {
        // return "Article Controller Index";

        /* $data = [
            [ "title" => "First Article"],
            [ "title" => "Second Article"],
            [ "title" => "Third Article"],
       ]; */

        //$data = Article::all();

        $data = Article::latest()->paginate(5);
        return view('articles.index', ['articles' => $data]);
    }

    public function detail($id)
    {
        //return "Controller - Article Detail - $id";
        /* $article = Article::find($id);
        return view('article.detail',[
            "article" => $article
        ]); */
        $data = Article::find($id);
        return view('articles.detail', [
            'article' => $data
        ]);
    }

    public function delete($id)
    {
        $article = Article::find($id);
        
        if(Gate::denies('delete-article', $article))
        {
            return back()->with("info", "Unauthorize");
        }

        $article->delete();

        return redirect('/articles')->with("info", "$article->title deleted");
    }

    public function add()
    {
        $data = Category::all();
        return view('articles.add', [
            'categories' => $data
        ]);
    }

    public function edit($id)
    {
        //$data = Category::all();
        $article = Article::find($id);

        $categories = Category::all();
        return view('articles.edit', [
            "article" => $article,
            "categories" => $categories,
        ]);
    }
    public function update($id)
    {
        //$article = Category::find($id);
        $article = Article::find($id);
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->save();
        return redirect("/articles/detail/$id");
    }

    public function create()
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $article = new Article;
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->user_id = auth()->user()->id;
        $article->save();
        return redirect('/articles');
    }
}
