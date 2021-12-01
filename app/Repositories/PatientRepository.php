<?php

namespace App\Repositories;

use App\Models\Patient;
use Facade\FlareClient\Http\Exceptions\NotFound;

class PatientRepository
{
    public function getAllPatients()
    {
        $result = Patient::all();
        if (is_null($result)){
            throw new NotFound('Patients not found:');
        }
        return $result;
    }

    public function getByID(int $id)
    {
        $result = Patient::find($id);
        if (is_null($result)){
            throw new NotFound('Patient with id:'. $id . ' not found');
        }
        return $result;
    }

    public function save(Patient $patient)
    {
        $result = $patient->save();
        if ($result === 0){
            throw new NotFound('Patient not saved');
        }
        return $result;
    }

    public function deleteByID(int $id)
    {
        $result = Patient::where('id', $id)->delete();
        if ($result === 0){
            throw new NotFound('Patient not deleted');
        }
        return $result;
    }

    public function getByNIF(string $nif)
    {
        $result = Patient::where('nif', $nif)->get();
        if (is_null($result)){
            throw new NotFound('Patient not found');
        }
        return $result;
    }
}
