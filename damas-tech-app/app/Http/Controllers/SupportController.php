<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\SendSupportReplyEmail;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    use ApiResponse;

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'required|string|min:10',
            'name' => 'required|string',
        ]);

        // Logic to save ticket to database would go here...
        $ticketId = 'SUP-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);

        $data = [
            'name' => $request->name,
            'ticketId' => $ticketId,
            'originalMessage' => $request->message,
        ];

        SendSupportReplyEmail::dispatch($request->email, $data);

        return $this->success(['ticket_id' => $ticketId], 'messages.success.support_received');
    }
}
