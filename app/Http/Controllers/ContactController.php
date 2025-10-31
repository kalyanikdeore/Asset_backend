<?php

namespace App\Http\Controllers\api;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Get contact information
     */
    public function index()
    {
        try {
            $contact = Contact::first();
            
            if (!$contact) {
                return response()->json([
                    'success' => true,
                    'data' => $this->emptyContactStructure()
                ]);
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'companyName' => $contact->company_name,
                    'tagline' => $contact->tagline,
                    'phoneNumbers' => $contact->phone_numbers ?? [],
                    'emails' => $contact->emails ?? [],
                    'whatsappNumber' => $contact->whatsapp_number,
                    'workingHours' => $contact->working_hours ?? [],
                    'appointmentInfo' => $contact->appointment_info,
                    'address' => $contact->address,
                    'socialLinks' => $contact->social_links ?? [],
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('ContactController error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error'
            ], 500);
        }
    }

    /**
     * Returns an empty contact structure
     * 
     * @return array
     */
    protected function emptyContactStructure()
    {
        return [
            'companyName' => null,
            'tagline' => null,
            'phoneNumbers' => [],
            'emails' => [],
            'whatsappNumber' => null,
            'workingHours' => [],
            'appointmentInfo' => null,
            'address' => null,
            'socialLinks' => [],
        ];
    }
}