<?php

namespace App\Http\Controllers;

use App\Repositories\PatientRepository;
use ErrorException;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Patient;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use TypeError;

final class PatientController extends Controller
{
    public function store(PatientRepository $patientRepository, Request $request) : JsonResponse
    {
        $patient = new Patient();
        $patient->name = $request->name;
        $patient->nif = $request->nif;

        try{
            $patientRepository->save($patient);
            return JsonResponse::create([
                'success' => 1,
                'data' => $patient->toArray()

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

    public function update(PatientRepository $patientRepository, Request $request) : JsonResponse
    {
        try{
        $patient = $patientRepository->getByID($request->id);
        $patient->name = $request->name;
        $patient->nif = $request->nif;

            $patientRepository->save($patient);
            return JsonResponse::create([
                'success' => 1,
                'data' => $patient->toArray()
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

    public function destroy(PatientRepository $patientRepository, Request $request) : JsonResponse
    {
        try{
            $patientRepository->deleteByID($request->id);
            return JsonResponse::create(['success' => 1]);
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
        } catch (QueryException $exception){
            return JsonResponse::create([
                'success' => 0,
                'error' => 'Patient cant be deleted because has diagnoses'
            ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $exception){
            return JsonResponse::create([
                'success' => 0,
                'error' => 'A error has been produced.'
                ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * List a patient
     */
    public function show(PatientRepository $patientRepository, Request $request) : JsonResponse
    {
        try{
            $result = $patientRepository->getByID($request->id);
            return JsonResponse::create([
                'success' => 1,
                'data' => $result
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

    public function listAll(PatientRepository $patientRepository) : JsonResponse
    {
        try{
            $result = $patientRepository->getAllPatients();

            $resultArray = $result->toArray();
            return JsonResponse::create([
                'success' => 1,
                'data' => $resultArray
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
