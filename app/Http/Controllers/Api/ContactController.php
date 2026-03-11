<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Traits\ApiResponse;

class ContactController extends Controller
{
    use ApiResponse;
    public function store(Request $request)
    {
        $createContact = Contact::create($request->all());
        return $this->success($createContact, 'Message Sent Successfully');
    }
}
