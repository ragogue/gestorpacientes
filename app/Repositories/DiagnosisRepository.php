<?php

namespace App\Repositories;

use App\Models\Diagnosis;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Database\Eloquent\Collection;

class DiagnosisRepository
{
    public function getDiagnosis(int $id) : Collection
    {
         $result = Diagnosis::where('patient_id', $id)->get();

         if (is_null($result)){
             throw new NotFound('Diagnosis for patient_id: ' . $id);
         }
         return $result;
    }

    public function saveDiagnosis(Diagnosis $diagnosis) : bool
    {
        $result =  $diagnosis->save();

         if ($result === 0){
             throw new NotFound('Diagnosis not saved');
         }
         return $result;
    }


}
