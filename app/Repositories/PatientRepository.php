<?php

namespace App\Repositories;

use App\Models\Patient;

class PatientRepository
{
    public function getAllPatients()
    {
        return Patient::all();
    }

    public function getByID(int $id)
    {
        return Patient::find($id);
    }

    public function save(Patient $patient)
    {
        return $patient->save();
    }

    public function deleteByID(string $nif)
    {
        return Patient::where('id', $nif)->delete();
    }

    public function getByNIF(string $nif)
    {
        return Patient::where('nif', $nif)->get();
    }
}
