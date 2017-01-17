<?php
namespace App\Http\Controllers;

use App\Http\Requests\ContactMeRequest;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Show the form
     *
     * @return View
     */
    public function showForm()
    {
        return view('blog.contact');
    }

    /**
     * Email the contact request
     *
     * @param ContactMeRequest $request
     * @return Redirect
     */
    public function sendContactInfo(ContactMeRequest $request)
    {
        $data = $request->only('name', 'email', 'phone');
        $data['messageLines'] = explode("\n", $request->get('message'));

        Mail::queue('emails.contact', $data, function ($message) use ($data) {
            $message->subject('JZi博客联系人邮件: '.$data['name'])
                ->to(config('blog.contact_email'))
                ->replyTo($data['email']);
        });

        return back()
            ->withSuccess("感谢您的邮件.邮件已发送");
    }
}
