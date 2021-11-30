<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    /**
     * Create a new diagnosis
     * @param \Illuminate\Http\Request
     */
    public function store(Request $request)
    {
        $diagnosis = new Diagnosis();
        $diagnosis->description = $request->description;
        $diagnosis->patient_id = $request->patient_id;

        $diagnosis->save();
    }

    /**
     * Show all patient`s diagnosis
     * @param \Illuminate\Http\Request
     */
    public function show(Request $request)
    {
        $diagnosis = Diagnosis::where('patient_id', $request->patient_id)->get();
        return $diagnosis;
    }
}
