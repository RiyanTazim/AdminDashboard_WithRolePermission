<?php
namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserContoller extends Controller
{
    public function userdashboard()
    {
        return view('Backend.Layout.user.index');
    }

    public function userlogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function userprofile()
    {

        $id          = Auth::user()->id;
        $profileData = User::find($id);

        return view('Backend.Layout.user.user_profile_view', compact('profileData'));
    }

    public function userprofilestore(Request $request)
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
            $file->move(public_path('upload/user_images'), $filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = [
            'message'    => 'User Profile Updated Successfully',
            'alert-type' => 'success',
        ];
        return back()->with($notification);

    }

    public function userchangepassword()
    {

        $id          = Auth::user()->id;
        $profileData = User::find($id);

        return view('Backend.Layout.user.user_change_password', compact('profileData'));
    }

    public function userupdatepassword(Request $request)
    {

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        ///Match Password

        if (! Hash::check($request->old_password, auth::user()->password)) {

            $notification = [
                'message'    => 'Old Password Does not Match',
                'alert-type' => 'error',
            ];
            return back()->with($notification);
        }

        ///Update new password

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        $notification = [
            'message'    => 'Password Changed Successfully',
            'alert-type' => 'success',
        ];
        return back()->with($notification);
    }
}
