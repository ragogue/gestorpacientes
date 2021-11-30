<?php

namespace App\Http\Controllers;

use App\Repositories\PatientRepository;
use Illuminate\Http\Request;
use App\Models\Patient;
use Symfony\Component\HttpFoundation\JsonResponse;

class PatientController extends Controller
{
    /**
     * Create a new patient
     * @param \Illuminate\Http\Request
     */
    public function store(PatientRepository $patientRepository, Request $request)
    {
        $patient = new Patient();
        $patient->name = $request->name;
        $patient->nif = $request->nif;

        if ($patientRepository->save($request->id)){
            return JsonResponse::create(['success' => 1]);
        } else {
            return JsonResponse::create(['success' => 0], 400);
        }    }

    /**
     * Update a patient
     * @param \Illuminate\Http\Request
     */
    public function update(PatientRepository $patientRepository, Request $request)
    {
        $patient = $patientRepository->getByID($request->id);
        $patient->name = $request->name;
        $patient->nif = $request->nif;

        if ($patientRepository->save($request->id)){
            return JsonResponse::create(['success' => 1]);
        } else {
            return JsonResponse::create(['success' => 0], 400);
        }
    }

    /**
     * Update a patient
     * @param \Illuminate\Http\Request
     */
    public function destroy(PatientRepository $patientRepository, Request $request)
    {
        if ($patientRepository->deleteByID($request->id)){
            return JsonResponse::create(['success' => 1]);
        } else {
            return JsonResponse::create(['success' => 0], 400);
        }
    }

    /**
     * List a patient
     */
    public function show(PatientRepository $patientRepository, Request $request)
    {
        $result = $patientRepository->getByID($request->id);

        if (isset($result)){
            return JsonResponse::create([
                'success' => 1,
                'data' => $result
            ]);
        } else{
            return JsonResponse::create([
                'success' => 0,
                'data' => []
            ], 404);
        }
    }

    /**
     * List all patients
     */
    public function listAll(PatientRepository $patientRepository)
    {

        $result = $patientRepository->getAllPatients();

        $resultArray = $result->toArray();

        if (!empty($resultArray)){
            return JsonResponse::create([
                'success' => 1,
                'data' => $resultArray
            ]);
        } else{
            return JsonResponse::create([
                'success' => 0,
                'data' => []
            ], 404);
        }
    }
}
