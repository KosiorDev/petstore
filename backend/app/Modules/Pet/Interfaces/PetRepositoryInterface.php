<?php

namespace App\Modules\Pet\Interfaces;

interface PetRepositoryInterface
{
    public function create(array $data);
    public function getById(int $id);
    public function getByStatus(string $status);
    public function uploadImage($id, $request);
    public function partialUpdate(int $id, array $data);
    public function update(array $data);
    public function delete(int $id);
}
