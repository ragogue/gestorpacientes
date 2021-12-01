<?php

namespace Tests\Feature\Http\Controllers\api;

use App\Http\Controllers\PatientController;
use App\Models\Patient;
use App\Repositories\PatientRepository;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PatientControllerTest extends TestCase
{

    public function testShowSuccess()
    {
        $patientController = new PatientController();
        $response = $patientController->show(
            $this->patientRepositoryShowMock(),
            $this->requestMock()
        );
        $arrayResponse = json_decode($response->getContent(), true);

        $this->assertEquals('1', $arrayResponse['success']);
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testShowException()
    {
        $patientController = new PatientController();
        $response = $patientController->show(
            $this->patientRepositoryShowMock(true),
            $this->requestMock()
        );
        $arrayResponse = json_decode($response->getContent(), true);
        $this->assertEquals('0', $arrayResponse['success']);
        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testShowAllSuccess()
    {
        $patientController = new PatientController();
        $response = $patientController->listAll(
            $this->patientRepositoryShowAllMock()
        );
        $arrayResponse = json_decode($response->getContent(), true);

        $this->assertEquals('1', $arrayResponse['success']);
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testShowAllException()
    {
        $patientController = new PatientController();
        $response = $patientController->listAll(
            $this->patientRepositoryShowAllMock(true)
        );
        $arrayResponse = json_decode($response->getContent(), true);
        $this->assertEquals('0', $arrayResponse['success']);
        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }


    public function testStoreSuccess()
    {
        $patientController = new PatientController();
        $response = $patientController->store(
            $this->patientRepositoryStoreMock(),
            $this->requestMock()
        );
        $arrayResponse = json_decode($response->getContent(), true);

        $this->assertEquals('1', $arrayResponse['success']);
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testStoreError()
    {
        $patientController = new PatientController();
        $response = $patientController->store(
            $this->patientRepositoryStoreMock(true),
            $this->requestMock()
        );
        $arrayResponse = json_decode($response->getContent(), true);
        $this->assertEquals('0', $arrayResponse['success']);
        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testUpdateSuccess()
    {
        $patientController = new PatientController();
        $response = $patientController->update(
            $this->patientRepositoryUpdateMock(),
            $this->requestMock()
        );
        $arrayResponse = json_decode($response->getContent(), true);

        $this->assertEquals('1', $arrayResponse['success']);
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testUpdateGetByIDError()
    {
        $patientController = new PatientController();
        $response = $patientController->update(
            $this->patientRepositoryUpdateMock(true),
            $this->requestMock()
        );
        $arrayResponse = json_decode($response->getContent(), true);
        $this->assertEquals('0', $arrayResponse['success']);
        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testUpdateSaveError()
    {
        $patientController = new PatientController();
        $response = $patientController->update(
            $this->patientRepositoryUpdateMock(true, true),
            $this->requestMock()
        );
        $arrayResponse = json_decode($response->getContent(), true);
        $this->assertEquals('0', $arrayResponse['success']);
        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testDestroySuccess()
    {
        $patientController = new PatientController();
        $response = $patientController->destroy(
            $this->patientRepositoryDeleteMock(),
            $this->requestMock()
        );
        $arrayResponse = json_decode($response->getContent(), true);

        $this->assertEquals('1', $arrayResponse['success']);
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testDestroyError()
    {
        $patientController = new PatientController();
        $response = $patientController->destroy(
            $this->patientRepositoryDeleteMock(true),
            $this->requestMock()
        );
        $arrayResponse = json_decode($response->getContent(), true);
        $this->assertEquals('0', $arrayResponse['success']);
        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    private function patientRepositoryShowMock ($exception = false)
    {
        $mock = $this->createMock(PatientRepository::class);
        if ($exception === true){
            $mock->expects(self::once())->method('getByID')->willThrowException(new Exception());
        } else {
            $mock->expects(self::once())->method('getByID');
        }
        return $mock;
    }

    private function patientRepositoryShowAllMock ($exception = false)
    {
        $mock = $this->createMock(PatientRepository::class);
        if ($exception === true){
            $mock->expects(self::once())->method('getAllPatients')->willThrowException(new Exception());
        } else {
            $mock->expects(self::once())->method('getAllPatients')->willReturn(new Collection());
        }
        return $mock;
    }

    private function patientRepositoryDeleteMock ($exception = false)
    {
        $mock = $this->createMock(PatientRepository::class);
        if ($exception === true){
            $mock->expects(self::once())->method('deleteByID')->willThrowException(new Exception());
        } else {
            $mock->expects(self::once())->method('deleteByID');
        }
        return $mock;
    }

    private function patientRepositoryUpdateMock ($saveException = false, $getByIDException = false)
    {
        $mock = $this->createMock(PatientRepository::class);
        if ($getByIDException === true){
            $mock->expects(self::once())->method('getByID')->willThrowException(new Exception());
        } else{
            $mock->expects(self::once())->method('getByID')->willReturn(new Patient());

        }

        if ($saveException === true && $getByIDException === true) {
            $mock->expects(self::never())->method('save');
        } else if ($saveException === true) {
            $mock->expects(self::once())->method('save')->willThrowException(new Exception());
        } else {
            $mock->expects(self::once())->method('save');
        }
        return $mock;
    }

    private function patientRepositoryStoreMock ($exception = false)
    {
        $mock = $this->createMock(PatientRepository::class);
        if ($exception === true){
            $mock->expects(self::once())->method('save')->willThrowException(new Exception());
        } else {
            $mock->expects(self::once())->method('save');
        }
        return $mock;
    }

    private function requestMock() : Request
    {
        return new Request([
            'id' => 2,
            'name' => '',
            'nif' => ''
        ]);
    }
}
