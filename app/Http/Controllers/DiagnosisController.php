<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Repositories\DiagnosisRepository;
use App\Repositories\PatientRepository;
use ErrorException;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use TypeError;
use function PHPUnit\Framework\isEmpty;

class DiagnosisController extends Controller
{
    public function store(DiagnosisRepository $diagnosisRepository, Request $request) : JsonResponse
    {
        $diagnosis = new Diagnosis();
        $diagnosis->description = $request->description;
        $diagnosis->patient_id = $request->patient_id;

        try{
            $diagnosisRepository->saveDiagnosis($diagnosis);
            return JsonResponse::create(['success' => 1]);
        } catch (NotFound $notFoundException){
            return JsonResponse::create([
                'success' => 0,
                'error' => $notFoundException->getMessage()
            ], Response::HTTP_NOT_FOUND);
        } catch (InvalidArgumentException | ErrorException | TypeError $invalidArgument){
            return JsonResponse::create([
                'success' => 0,
                'error' => 'Invalid Argument Exception'
            ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception){
            return JsonResponse::create([
                'success' => 0,
                'error' => 'A error has been produced.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(DiagnosisRepository $diagnosisRepository, Request $request) : JsonResponse
    {
        try {
            $result = $diagnosisRepository->getDiagnosis($request->id);
            return JsonResponse::create([
                'success' => 1,
                'data' => $result->toArray()
            ]);
        } catch (NotFound $notFoundException){
            return JsonResponse::create([
                'success' => 0,
                'error' => $notFoundException->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        } catch (InvalidArgumentException | ErrorException | TypeError $invalidArgument){
            return JsonResponse::create([
                'success' => 0,
                'error' => 'Invalid Argument Exception'
            ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception){
            return JsonResponse::create([
                'success' => 0,
                'error' => 'A error has been produced.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
