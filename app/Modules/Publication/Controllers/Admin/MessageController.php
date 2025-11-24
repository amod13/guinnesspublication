<?php

namespace App\Modules\Publication\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Publication\Models\ConatctMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected string $viewPrefix = 'publication::admin.contact.';
    public function contactMessages()
    {
        $messages = ConatctMessage::paginate(10);

        return view($this->viewPrefix . 'index', compact('messages'));
    }

    public function deleteContactMessage($id)
    {
        $message = ConatctMessage::find($id);
        $message->delete();

        return redirect()->back()->with('success', 'Message Deleted Successfully');
    }

    public function contactMessageShow($id)
    {
        $message = ConatctMessage::find($id);

        return view($this->viewPrefix . 'show', compact('message'));
    }



}
