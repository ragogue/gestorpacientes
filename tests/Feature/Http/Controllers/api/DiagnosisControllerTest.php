<?php

namespace Tests\Feature\Http\Controllers\api;

use App\Http\Controllers\DiagnosisController;
use App\Repositories\DiagnosisRepository;

use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DiagnosisControllerTest extends TestCase
{

    public function testShowSuccess()
    {
        $diagnosisController = new DiagnosisController();
        $response = $diagnosisController->show(
            $this->diagnosisRepositoryShowMock(),
            $this->requestMock()
        );
        $arrayResponse = json_decode($response->getContent(), true);

        $this->assertEquals('1', $arrayResponse['success']);
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testShowException()
    {
        $diagnosisController = new DiagnosisController();
        $response = $diagnosisController->show(
            $this->diagnosisRepositoryShowMock(true),
            $this->requestMock()
        );
        $arrayResponse = json_decode($response->getContent(), true);
        $this->assertEquals('0', $arrayResponse['success']);
        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }


    public function testStoreSuccess()
    {
        $diagnosisController = new DiagnosisController();
        $response = $diagnosisController->store(
            $this->diagnosisRepositoryStoreMock(),
            $this->requestMock()
        );
        $arrayResponse = json_decode($response->getContent(), true);

        $this->assertEquals('1', $arrayResponse['success']);
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testStoreError()
    {
        $diagnosisController = new DiagnosisController();
        $response = $diagnosisController->store(
            $this->diagnosisRepositoryStoreMock(true),
            $this->requestMock()
        );
        $arrayResponse = json_decode($response->getContent(), true);
        $this->assertEquals('0', $arrayResponse['success']);
        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    private function diagnosisRepositoryShowMock ($exception = false)
    {
        $mock = $this->createMock(DiagnosisRepository::class);
        if ($exception === true){
            $mock->expects(self::once())->method('getDiagnosis')->willThrowException(new Exception());
        } else {
            $mock->expects(self::once())->method('getDiagnosis');
        }
        return $mock;
    }

    private function diagnosisRepositoryStoreMock ($exception = false) : DiagnosisRepository
    {
        $mock = $this->createMock(DiagnosisRepository::class);
        if ($exception === true){
            $mock->expects(self::once())->method('saveDiagnosis')->willThrowException(new Exception());
        } else {
            $mock->expects(self::once())->method('saveDiagnosis');
        }
        return $mock;
    }

    private function requestMock() : Request
    {
        return new Request([
            'id' => 2,
            'description' => '',
            'patient_id' => 2
        ]);
    }
}
