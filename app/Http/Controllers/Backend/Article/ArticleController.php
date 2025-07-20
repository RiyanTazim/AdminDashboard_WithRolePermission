<?php
namespace App\Http\Controllers\Backend\Article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $articles = Article::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                ->orWhere('body', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%");
        })
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('Backend.Article.list', compact('articles'));
    }

    public function create()
    {
        return view('Backend.Article.create');
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'title'  => 'required|string|max:100',
            'author' => 'required|string|max:100',
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        Article::create([
            'title'  => $request->input('title'),
            'body'   => $request->input('body'),
            'author' => $request->input('author'),
        ]);

        $notification = [
            'message'    => 'Article added Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('article.list')->with($notification);
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('Backend.Article.edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'  => 'required|string|max:100',
            'body'   => 'nullable|string',
            'author' => 'required|string|max:100',
        ]);

        $article = Article::findOrFail($id);
        $article->update([
            'title'  => $validated['title'],
            'body'   => $validated['body'],
            'author' => $validated['author'],
        ]);

        $notification = [
            'message'    => 'Article Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('article.list')->with($notification);
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return redirect()->route('article.list')->with('success', 'Article deleted successfully.');
    }
}
