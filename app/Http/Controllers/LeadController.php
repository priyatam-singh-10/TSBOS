<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        return view('frontend.default.student.leads.index');
    }
    public function webinar_page()
    {
        return view('frontend.default.student.leads.webinar');
    }
    public function LeadsPayment()
    {
        return view('frontend.default.student.leads.payment');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullName' => 'required|string|min:3|max:50',
            'whatsappNumber' => 'required|digits:10',
        ]);

        $lead = Lead::create([
            'name' => $request->fullName,
            'mobile' => $request->whatsappNumber,
            'city' => $request->city,
            'main_concern' => $request->mainConcern
        ]);
        // ✅ SESSION  store
        session([
            'lead_purchase' => [
                'user_name' => $lead->name,
                'mobile' => $lead->mobile,
                'city' => $lead->city,
            ]
        ]);

        return redirect()->route('webinar-page')
            ->with('success', 'Lead saved successfully');
    }
    public function ThankYou()
    {
        return view('frontend.default.success-page');
    }
}
