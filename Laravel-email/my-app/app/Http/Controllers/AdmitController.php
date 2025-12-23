<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class AdmitController extends Controller
{
    public function showForm()
    {
        return view('admit.form');
    }

    public function generatePDF(Request $request)
    {
        $validated = $request->validate([
            'unit' => 'required|string',
            'gst_roll' => 'required|string',
            'candidate_name' => 'required|string',
            'father_name' => 'required|string',
            'mother_name' => 'required|string',
            'quota' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('upload/admit'), $photoName);
            $photoPath = public_path('upload/admit/' . $photoName);
        }

        // Prepare data
        $data = [
            'unit' => $request->unit,
            'gst_roll' => $request->gst_roll,
            'candidate_name' => $request->candidate_name,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'quota' => $request->quota,
            'photo' => $photoPath,
            'pending_bill_no' => $request->pending_bill_no,
            'pending_amount' => $request->pending_amount,
            'paid_bill_no' => $request->paid_bill_no,
            'paid_amount' => $request->paid_amount,
            'subjects' => $request->subjects ?? [],
        ];

        // Generate PDF
        $pdf = PDF::loadView('admit.pdf', compact('data'));
        
        $fileName = 'Admit_' . $request->gst_roll . '_' . time() . '.pdf';
        
        return $pdf->download($fileName);
    }
}
