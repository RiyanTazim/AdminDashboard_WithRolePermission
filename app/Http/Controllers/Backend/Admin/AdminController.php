<?php
namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AdminController extends Controller//implements HasMiddleware

{
    public function __construct()
    {
        $this->middleware('permission:View users')->only(['index']);
        // $this->middleware('permission:Create users')->only(['create', 'store']);
        $this->middleware('permission:Edit users')->only(['edit', 'update']);
        $this->middleware('permission:Delete users')->only(['destroy']);
    }
    public function admindashboard()
    {
        return view('Backend.Layout.admin.index');
    }

    public function adminlogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function adminprofile()
    {

        $id          = Auth::user()->id;
        $profileData = User::find($id);

        return view('Backend.Layout.admin.admin_profile_view', compact('profileData'));
    }

    public function adminprofilestore(Request $request)
    {

        $id             = Auth::user()->id;
        $data           = User::find($id);
        $data->username = $request->username;
        $data->name     = $request->name;
        $data->email    = $request->email;
        $data->phone    = $request->phone;
        $data->address  = $request->address;

        if ($request->file('photo')) {
            $file = $request->file('photo');

            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $data['photo'] = $filename;
        }

        $data->save();

        return redirect()->back();

    }

    public function adminchangepassword()
    {

        $id          = Auth::user()->id;
        $profileData = User::find($id);

        return view('Backend.Layout.admin.admin_change_password', compact('profileData'));
    }

    public function adminupdatepassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => [
                'required',
                'confirmed',
                function ($attribute, $value, $fail) use ($request) {
                    if (Hash::check($value, Auth::user()->password)) {
                        $fail('New password cannot be the same as the old password.');
                    }
                },
            ],
        ]);

        // Check if old password matches
        if (! Hash::check($request->old_password, Auth::user()->password)) {
            return back()->withErrors(['old_password' => 'Old password does not match.'])
                ->withInput();
        }

        // Update new password
        User::whereId(Auth::id())->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with([
            'message'    => 'Password changed successfully.',
            'alert-type' => 'success',
        ]);
    }

    ///////////////// User List /////////////////
    public function adminuserlist()
    {
        return view('Backend.Layout.admin.user_list');
    }

    public function getData(Request $request)
    {
        // $data = User::with('roles')->get();
        $data = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Super Admin');
        })->with('roles')->get();

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('photo', function ($row) {
                $userPath    = public_path('upload/user_images/' . $row->photo);
                $adminPath   = public_path('upload/admin_images/' . $row->photo);
                $defaultPath = asset('upload/no_image.jpg');

                if (File::exists($userPath)) {
                    $image = asset('upload/user_images/' . $row->photo);
                } elseif (File::exists($adminPath)) {
                    $image = asset('upload/admin_images/' . $row->photo);
                } else {
                    $image = $defaultPath;
                }

                return '<img src="' . $image . '" alt="image" height="60px" width="60px" class="rounded-circle">';
            })
            ->addColumn('roles', function ($row) {
                return $row->getRoleNames()->implode(', ');
            })
            ->addColumn('status', function ($row) {
                $statusClass = $row->status === 'active' ? 'success' : 'danger';
                $statusText  = ucfirst($row->status);
                $statusUrl   = route('user.status', $row->id);

                return '<a href="' . $statusUrl . '" class="btn btn-inverse-' . $statusClass . '">' . $statusText . '</a>';
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . route('user.password.reset', $row->id) . '" class="btn btn-outline-info my-1">Reset Password</a>
                    <a href="' . route('user.profile.edit', $row->id) . '" class="btn btn-sm btn-inverse-warning"><i data-feather="edit"></i></a>
                    <a href="javascript:void(0);" data-id="' . $row->id . '" class="btn btn-sm btn-inverse-danger delete-btn" title="Delete">
                        <i data-feather="trash-2"></i>
                    </a>';
            })
            ->rawColumns(['photo', 'status', 'action'])
            ->make(true);
    }

    public function adminusercreate()
    {
        $roles = Role::orderBy('name', 'asc')->get();
        return view('Backend.Layout.admin.user_create', compact('roles'));
    }

    public function adminUserStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'username' => 'required|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'roles'    => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->roles);

        $notification = [
            'message'    => 'User Created Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('admin.user.list')->with($notification);
    }
    ///////////////// User Status Change /////////////////

    public function userstatus($id)
    {
        $user = User::find($id);

        if ($user) {
            if ($user->status === 'active') {
                $user->status = 'inactive';
            } else {
                $user->status = 'active';
            }
            $user->save();
        }

        $notification = [
            'message'    => 'Status Changed Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);

    }

    ////////////////////// USER Password Reset //////////////

    public function userpasswordreset($id)
    {

        $profileData = User::find($id);

        return view('Backend.Layout.admin.user_password_reset', compact('profileData'));

    }

    public function userpasswordupdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (! $request->filled('password')) {
            return redirect()->back()->with([
                'message'    => 'Please enter a password.',
                'alert-type' => 'warning',
            ]);
        }

        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $user->password = bcrypt($request->password); // Always hash!
        $user->save();

        return redirect()->back()->with([
            'message'    => 'Password Changed Successfully',
            'alert-type' => 'success',
        ]);
    }

    //////////////// User Profile Update /////////////

    public function userprofileedit($id)
    {

        $user  = User::find($id);
        $roles = Role::orderBy('name', 'asc')->get();
        return view('Backend.Layout.admin.user_profile_edit', compact('user', 'roles'));
    }

    public function userprofileupdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'username' => 'required|min:3',
            'name'     => 'required|max:100',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'required|digits:11|unique:users,phone,' . $user->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->username = $request->username;
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->phone    = $request->phone;
        $user->address  = $request->address;

        // Handle photo upload
        if ($request->file('photo')) {
            $file     = $request->file('photo');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $user->photo = $filename;
        }

        $user->save();

        // ✅ Sync user roles
        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        $notification = [
            'message'    => 'User Profile Updated Successfully',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }

    public function userprofiledelete($id)
    {

        $user = User::find($id);

        if (! is_null($user)) {
            $user->delete();
        }

        $notification = [
            'message'    => 'User Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
