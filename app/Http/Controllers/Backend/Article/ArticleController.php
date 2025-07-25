<?php
namespace App\Http\Controllers\Backend\Article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ArticleController extends Controller//implements HasMiddleware

{
    public function __construct()
    {
        $this->middleware('permission:View')->only(['index']);
        $this->middleware('permission:Create')->only(['create', 'store']);
        $this->middleware('permission:Edit')->only(['edit', 'update']);
        $this->middleware('permission:Delete')->only(['destroy']);
    }
    public function index(Request $request)
    {
        // if ($request->ajax()) {
        //     $data = Article::get();
        //     return datatables()->of($data)
        //         ->addIndexColumn()
        //         ->addColumn('body', function ($row) {
        //             return strlen($row->body) > 40 ? substr($row->body, 0, 50) . '...' : $row->body;
        //         })
        //         ->addColumn('action', function ($row) {
        //             return '<a href="' . route('article.edit', $row->id) . '" class="btn btn-sm btn-inverse-warning"><i data-feather="edit"></i></a>
        //             <a href="' . route('article.delete', $row->id) . '" class="btn btn-sm btn-inverse-danger delete-confirm" title="Delete">
        //                                         <i data-feather="trash-2"></i></a>';
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }

        return view('Backend.Article.list');
    }

    public function getData(Request $request)
    {
        $data = Article::get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('body', function ($row) {
                return strlen($row->body) > 40 ? substr($row->body, 0, 50) . '...' : $row->body;
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . route('article.edit', $row->id) . '" class="btn btn-sm btn-inverse-warning"><i data-feather="edit"></i></a>
                    <a href="' . route('article.delete', $row->id) . '" class="btn btn-sm btn-inverse-danger delete-confirm" title="Delete">
                        <i data-feather="trash-2"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
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
