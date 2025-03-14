<?php

namespace App\Modules\Pet\Interfaces;

interface PetServiceInterface
{
    public function addPet(array $data);
    public function getPetById(int $id);
    public function getPetByStatus(string $status);
    public function uploadPetImage(int $id, $request);
    public function partialUpdatePet(int $id, array $data);
    public function updatePet(array $data);
    public function deletePet(int $id);
}
