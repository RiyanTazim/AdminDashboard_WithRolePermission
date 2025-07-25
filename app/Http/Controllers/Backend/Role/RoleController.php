<?php
namespace App\Http\Controllers\Backend\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller//implements HasMiddleware

{
    public function __construct()
    {
        // $this->middleware('permission:View roles')->only(['index']);
        // $this->middleware('permission:Create roles')->only(['create', 'store']);
        // $this->middleware('permission:Edit roles')->only(['edit', 'update']);
        // $this->middleware('permission:Delete roles')->only(['destroy']);

        $this->middleware('role:Admin|Super Admin')->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    }
    public function index()
    {
        // $roles = Role::orderBy('created_at', 'asc')->paginate(10);
        return view('Backend.Role.list');
    }

    public function getData(Request $request)
    {
        $data = Role::with('permissions')->get(); // Eager load permissions

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('permissions', function ($row) {
                return $row->permissions->pluck('name')->implode(', ');
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . route('role.edit', $row->id) . '" class="btn btn-sm btn-inverse-warning"><i data-feather="edit"></i></a>
                     <a href="javascript:void(0);" data-id="' . $row->id . '" class="btn btn-sm btn-inverse-danger delete-btn" title="Delete">
                        <i data-feather="trash-2"></i>
                    </a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $permissions = Permission::orderBy('name', 'asc')->get();
        return view('Backend.Role.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $role = Role::create([
            'name' => $request->input('name'),
        ]);

        if (! empty($request->permission)) {
            foreach ($request->permission as $name) {
                $role->givePermissionTo($name);
            }
        }

        $notification = [
            'message'    => 'Role Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('role.list')->with($notification);
    }

    public function edit($id)
    {
        $role           = Role::findOrFail($id);
        $permissions    = Permission::orderBy('name', 'asc')->get();
        $hasPermissions = $role->permissions->pluck('name')->toArray();
        return view('Backend.Role.edit', compact('role', 'permissions', 'hasPermissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validatedData = Validator::make($request->all(), [
            'name'        => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'required|array',
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $role->update([
            'name' => $request->input('name'),
        ]);

        $role->syncPermissions($request->permissions);

        $notification = [
            'message'    => 'Role Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('role.list')->with($notification);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if ($role->users()->count() > 0) {
            return redirect()->route('role.list')->with([
                'message'    => 'The role is assigned to users. Cannot be deleted.',
                'alert-type' => 'error',
            ]);
        }

        // Optional: detach all permissions if you want
        $role->permissions()->detach();

        $role->delete();

        return redirect()->route('role.list')->with([
            'message'    => 'Role Deleted Successfully',
            'alert-type' => 'success',
        ]);
    }
}
