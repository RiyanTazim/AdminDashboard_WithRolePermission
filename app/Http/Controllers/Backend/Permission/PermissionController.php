<?php
namespace App\Http\Controllers\Backend\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //method to display a list of permissions
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'asc')->paginate(10);
        return view('Backend.Permission.list', compact('permissions'));
    }

    public function create()
    {
        return view('Backend.Permission.create');
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        // Save permission
        Permission::create([
            'name' => $request->input('name'),
        ]);

        $notification = [
            'message'    => 'Permission added Successfully',
            'alert-type' => 'success',
        ];

        // return redirect()->route('permission.list')->with('success', 'Permission created successfully.');
        return redirect()->route('permission.list')->with($notification);
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('Backend.Permission.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $id,
        ]);

        $permission = Permission::findOrFail($id);
        $permission->update(['name' => $validated['name']]);

        $notification = [
            'message'    => 'Permission Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('permission.list')->with($notification);

    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        // Check if permission is assigned to any role
        if ($permission->roles()->count() > 0) {
            return redirect()->route('permission.list')->with([
                'message'    => 'Cannot delete this permission as it is assigned to one or more roles.',
                'alert-type' => 'error',
            ]);
        }

        $permission->delete();

        return redirect()->route('permission.list')->with([
            'message'    => 'Permission Deleted Successfully',
            'alert-type' => 'success',
        ]);
    }
}
