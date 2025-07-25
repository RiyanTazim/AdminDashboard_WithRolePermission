<?php
namespace App\Http\Controllers\Backend\Mail;

use App\Http\Controllers\Controller;
use App\Mail\MyTestMail;
use App\Models\SMTP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SMTPController extends Controller
{
    public function index()
    {
        // $data = SMTP::first();
        $data = SMTP::whereId(1)->first();
        return view('Backend.SMTP.smtp-config', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->only([
            'mailer',
            'host',
            'port',
            'username',
            'password',
            'encryption',
            'sender',
        ]);

        SMTP::updateOrCreate(['id' => 1], $validated);

        return redirect()->route('mailconfig.index')->with('message', 'SMTP Updated Successfully');
    }

    public function sendMail()
    {
        $data = [
        'email'   => 'tazimt8@gmail.com',
        'subject' => 'Test Mail',
        'body'    => 'Testing purpose',
    ];

    Mail::to($data['email'])->send(new MyTestMail($data));

    $notification = [
        'message'    => 'Mail Sent Successfully',
        'alert-type' => 'success',
    ];
        return redirect()->route('mailconfig.index')->with($notification);
    }
}
