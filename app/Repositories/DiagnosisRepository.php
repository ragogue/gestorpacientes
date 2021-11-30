<?php

namespace App\Repositories;

use App\Models\Diagnosis;

class DiagnosisRepository
{
    public function getDiagnosis(int $id)
    {
        return Diagnosis::where('patient_id', $id)->get();
    }

    public function saveDiagnosis(Diagnosis $diagnosis)
    {
        return $diagnosis->save();
    }


}
