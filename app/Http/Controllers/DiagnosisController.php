<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Repositories\DiagnosisRepository;
use App\Repositories\PatientRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use function PHPUnit\Framework\isEmpty;

class DiagnosisController extends Controller
{
    /**
     * Create a new diagnosis
     * @param \Illuminate\Http\Request
     */
    public function store(DiagnosisRepository $diagnosisRepository, PatientRepository $patientRepository, Request $request)
    {
        $diagnosis = new Diagnosis();
        $diagnosis->description = $request->description;
        $diagnosis->patient_id = $request->patient_id;

        $result = $diagnosisRepository->saveDiagnosis($diagnosis);

        if ($result){
            return JsonResponse::create(['success' => 1]);
        } else {
            return JsonResponse::create(['success' => 0], 404);
        }
    }

    /**
     * Show all patient`s diagnosis
     * @param \Illuminate\Http\Request
     */
    public function show(DiagnosisRepository $diagnosisRepository, Request $request)
    {
       $result = $diagnosisRepository->getDiagnosis($request->id);
       $resultArray = $result->toArray();

       if (!empty($resultArray)){
           return JsonResponse::create([
               'success' => 1,
               'data' => $result->toArray()
        ]);
       } else{
           return JsonResponse::create([
               'success' => 0,
               'data' => []
        ]);
       }

    }
}
