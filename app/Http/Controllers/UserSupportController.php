<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\SupportMail; // Assuming you've created a SupportMail Mailable

class UserSupportController extends Controller
{
    public function index()
    {
        // Log the action of visiting the support page
        Log::info('User visited the support page.');

        return view('support'); // Return the support form view
    }

    public function store(Request $request)
    {
        // Log the incoming request
        Log::info('Received support query submission.', ['data' => $request->all()]);

        // Validate form inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Prepare email data
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => strip_tags($request->message), // Clean any HTML tags from the message
        ];

        // Send email using Gmail SMTP
        try {
            // Send the support email using a Mailable
            Mail::to('sania@brightandsharley.com') // Your support email
                ->send(new SupportMail($data)); // Using a Mailable class to send the email

            Log::info('Support email sent successfully.', ['to' => 'sania@brightandsharley.com']);
        } catch (\Exception $e) {
            Log::error('Failed to send support email.', ['error' => $e->getMessage()]);
            return back()->with('error', 'There was an issue sending your query. Please try again later.');
        }

        return back()->with('success', 'Your query has been submitted successfully.');
    }
}
