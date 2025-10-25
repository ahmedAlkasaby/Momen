<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Notifications\NotifyUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;

class ContactController extends MainController
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        parent::__construct();
        $this->setClass('contacts');
    }
    public function index()
    {

        $contacts = Contact::paginate($this->perPage);
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->seen = true;
        $contact->save();
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */

    
    public function sendMessage($id, Request $request)
    {
        $request->validate([
            "title" => "required|string|max:255",
            "body" => "required|string"
        ]);
        $message = Contact::findOrFail($id);
        Notification::route('mail', $message->email)
            ->notify(new NotifyUser($request->body,  $request->title));
        
        return redirect()->back()->with('success', __('site.send_message_successfully'));
    }
}
