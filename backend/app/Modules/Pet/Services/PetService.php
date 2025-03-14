<?php

namespace App\Modules\Pet\Services;

use App\Modules\Pet\Interfaces\PetRepositoryInterface;
use App\Modules\Pet\Interfaces\PetServiceInterface;

class PetService implements PetServiceInterface
{
    private readonly PetRepositoryInterface $repository;

    public function __construct(PetRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    public function addPet(array $data)
    {
        return $this->repository->create($data);
    }

    public function getPetById(int $id)
    {
        return $this->repository->getById($id);
    }

    public function getPetByStatus(string $status)
    {
        return $this->repository->getByStatus($status);
    }

    public function uploadPetImage($id, $request)
    {
        return $this->repository->uploadImage($id, $request);
    }

    public function partialUpdatePet(int $id, array $data)
    {
        return $this->repository->partialUpdate($id, $data);
    }

    public function updatePet(array $data)
    {
        return $this->repository->update($data);
    }

    public function deletePet(int $id)
    {
        return $this->repository->delete($id);
    }
}
