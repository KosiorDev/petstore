<?php

namespace App\Modules\Pet\Services;


use Illuminate\Http\Client\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiResponseHandler
{
    public function handle(Response $response, string $endpoint)
    {
        if ($response->successful()) {
            return $response->json();
        }

        switch ($endpoint) {
            case 'getByStatus':
                $this->handleGetPetByStatusError($response);
                break;

            case 'getById':
                $this->handleGetPetByIdError($response);
                break;

            case 'create':
                $this->handleCreatePetError($response);
                break;

            case 'update':
                $this->handleUpdatePetError($response);
                break;

            case 'uploadImage':
                $this->handleUploadImageError($response);
                break;

            default:
                $this->handleGenericError($response);
                break;
        }
    }


    private function handleGetPetByStatusError(Response $response)
    {
        if ($response->status() === 400) {
            throw new \Exception('Podano nieprawidłowy status.', 400);
        }

        $this->handleGenericError($response);
    }
    private function handleGetPetByIdError(Response $response)
    {
        switch ($response->status()) {
            case 400:
                throw new \Exception('Podane nieprawidłowe ID.', 400);

            case 404:
                throw new \Exception('Nie znaleziono zwierzaka.', 400);
        }

        $this->handleGenericError($response);
    }

    private function handleCreatePetError(Response $response)
    {
        if ($response->status() === 400) {
            throw new HttpResponseException(response()->json(['error' => 'Błąd walidacji.'], 400));
        }

        $this->handleGenericError($response);
    }

    private function handleUpdatePetError(Response $response)
    {
        if ($response->status() === 404) {
            throw new HttpResponseException(response()->json(['error' => 'Nie można zaktualizować – zwierzak nie istnieje.'], 404));
        }

        $this->handleGenericError($response);
    }

    private function handleUploadImageError(Response $response)
    {
        if ($response->status() === 415) {
            throw new HttpResponseException(response()->json(['error' => 'Nieprawidłowy format pliku.'], 415));
        }

        $this->handleGenericError($response);
    }

    private function handleGenericError(Response $response)
    {
        throw new HttpResponseException(response()->json([
            'error' => 'Wystąpił błąd API.',
            'status' => $response->status(),
            'message' => $response->body(),
        ], $response->status()));
    }
}
