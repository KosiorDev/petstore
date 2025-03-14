<?php

namespace App\Modules\Pet\Repositories;

use App\Modules\Pet\Interfaces\PetRepositoryInterface;
use App\Modules\Pet\Requests\UploadImageRequest;
use App\Modules\Pet\Services\ApiResponseHandler;
use Illuminate\Support\Facades\Http;

class PetRepository implements PetRepositoryInterface
{
    protected string $baseUrl;
    protected ApiResponseHandler $responseHandler;

    public function __construct(string $baseUrl, ApiResponseHandler $responseHandler)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        return $this->responseHandler = $responseHandler;
    }

    public function create(array $data)
    {
        $response = Http::post($this->baseUrl, $data);

        return $this->responseHandler->handle($response, __FUNCTION__);
    }

    public function getById(int $id)
    {
        $response = Http::get("{$this->baseUrl}/{$id}");

        return $this->responseHandler->handle($response, __FUNCTION__);
    }

    public function getByStatus(string $status)
    {
        $response = Http::get("{$this->baseUrl}/findByStatus", ['status' => $status]);

        return $this->responseHandler->handle($response, __FUNCTION__);
    }

    public function uploadImage($id, UploadImageRequest $request)
    {
        $response = Http::attach(
            'file', $request->file('file')->get(), $request->file('file')->getClientOriginalName()
        )->asMultipart()->post("{$this->baseUrl}/{$id}/uploadImage", [
            'additionalMetadata' => $request->input('additionalMetadata'),
        ]);

        return $this->responseHandler->handle($response, __FUNCTION__);
    }

    public function partialUpdate(int $id, array $data)
    {
        $response = Http::asForm()->post("{$this->baseUrl}/{$id}", $data);

        return $this->responseHandler->handle($response, __FUNCTION__);
    }

    public function update(array $data)
    {
        $response = Http::put("{$this->baseUrl}", $data);

        return $this->responseHandler->handle($response, __FUNCTION__);
    }

    public function delete(int $id)
    {
        $response = Http::withHeader('api_key', config('services.petstore.api_key'))
            ->delete("{$this->baseUrl}/{$id}");
        return $this->responseHandler->handle($response, __FUNCTION__);
    }
}
