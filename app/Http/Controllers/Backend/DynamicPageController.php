<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DynamicPageController extends Controller
{
    public function index()
    {
        // $dynamicpages = DynamicPage::all();
        return view('Backend.admin.DynamicPage.list');
    }

    public function getData(Request $request)
    {
        $data = DynamicPage::get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('body', function ($row) {
                return strlen($row->body) > 40 ? substr($row->body, 0, 50) . '...' : $row->body;
            })
            ->addColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d F Y');
            })
            ->addColumn('content', function ($row) {
                // Remove HTML tags and trim whitespace
                return Str::limit(strip_tags($row->content), 80);
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . route('dynamicpage.edit', $row->id) . '" class="btn btn-sm btn-inverse-warning"><i data-feather="edit"></i></a>
                         <a href="javascript:void(0);" data-id="' . $row->id . '" class="btn btn-sm btn-inverse-danger delete-btn" title="Delete">
                            <i data-feather="trash-2"></i>
                            </a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('Backend.admin.DynamicPage.create');
    }

    public function store(Request $request)
    {
        // Step 1: Validate input
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Step 2: Save to database
        $dynamicpage          = new DynamicPage();
        $dynamicpage->title   = $request->title;
        $dynamicpage->content = $request->content;
        $dynamicpage->save();

        // Step 3: Notification on success
        $notification = [
            'message'    => 'Content created successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->route('dynamicpage.list')->with($notification);
    }

    public function edit($id)
    {
        $dynamicpage = DynamicPage::findOrFail($id);
        return view('Backend.admin.DynamicPage.edit', compact('dynamicpage'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $dynamicpage          = DynamicPage::findOrFail($id);
        $dynamicpage->title   = $request->title;
        $dynamicpage->content = $request->content;
        $dynamicpage->save();

        $notification = [
            'message'    => 'Content Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('dynamicpage.list')->with($notification);
    }

    public function destroy($id)
    {
        $page = DynamicPage::findOrFail($id);
        $page->delete();

        $notification = [
            'message'    => 'Content deleted successfully.',
            'alert-type' => 'success',
        ];

        return redirect()->route('dynamicpage.list')->with($notification);
    }

}
