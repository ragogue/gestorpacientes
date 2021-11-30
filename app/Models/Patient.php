<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'nif'];

    /**
     * Get the patient's diagnosis
     */
    public function diagnosis(): HasMany
    {
        return $this->hasMany(Diagnosis::class, 'patient_id');
    }
}
