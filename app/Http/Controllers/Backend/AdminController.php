<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function admindashboard()
    {
        return view('Backend.admin.index');
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

        return view('Backend.admin.admin_profile_view', compact('profileData'));
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

        return view('Backend.admin.admin_change_password', compact('profileData'));
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

    public function adminuserlist()
    {
        $users = User::where('role', 'user')->get(); /// for specific role

        return view('Backend.admin.user_list', compact('users'));
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

        return view('Backend.admin.user_password_reset', compact('profileData'));

    }

    // public function userpasswordupdate(Request $request, $id)
    // {

    //     $user = User::find($id);
    //     if ($request->password) {
    //         $request->validate([

    //             'password' => 'required|confirmed',
    //         ]);
    //         $user->password = $request->password;
    //     }
    //     $user->save();

    //     // $request->validate([
    //     //     'old_password' => 'required',
    //     //     'new_password' => 'required|confirmed'
    //     // ]);

    //     ///Match Password

    //     // if(!Hash::check($request->old_password, User::where('id', $id)->get()->password)){

    //     //     $notification  = array(
    //     //         'message' => 'Old Password Does not Match',
    //     //         'alert-type' => 'error'
    //     //     );
    //     //     return back()->with($notification);
    //     // }

    //     ///Update new password

    //     // User::whereId($users()->id)->update([
    //     //     'password' => Hash::make($request->new_password)
    //     // ]);

    //     $notification = [
    //         'message'    => 'Password Changed Successfully',
    //         'alert-type' => 'success',
    //     ];
    //     return back()->with($notification);
    // }

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

        $user = User::find($id);

        return view('Backend.admin.user_profile_edit', compact('user'));
    }

    public function userprofileupdate(Request $request, $id)
    {

        $user = User::find($id);

        $user->username = $request->username;
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->phone    = $request->phone;
        $user->address  = $request->address;

        if ($request->file('photo')) {
            $file = $request->file('photo');

            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $user['photo'] = $filename;
        }

        $user->save();

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
