<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    /**
     * Create a new patient
     * @param \Illuminate\Http\Request
     */
    public function store(Request $request)
    {
        $patient = new Patient();
        $patient->name = $request->name;
        $patient->nif = $request->nif;

        $patient->save();
    }

    /**
     * Update a patient
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $patient = Patient::findOrFail($request->id);
        $patient->name = $request->name;
        $patient->nif = $request->nif;

        $patient->save();
        return $patient;
    }

    /**
     * Update a patient
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $patient = Patient::where('nif', $request->nif)->delete();
        return $patient;
    }

    /**
     * List a patient
     */
    public function show(Request $request)
    {
        $patient = Patient::find($request->id);
        return $patient;
    }

    /**
     * List all patients
     */
    public function listAll()
    {
        $patients = Patient::all();
        return $patients;
    }
}
