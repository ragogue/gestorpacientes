<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\TestCase;

class Patient extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $patient = new \App\Models\Patient();
        $this->isInstanceOf(Collection::class, $patient->diagnosis());
    }
}
