<?php

namespace App\Modules\Pet\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Pet\Enums\PetStatus;
use App\Modules\Pet\Interfaces\PetServiceInterface;
use App\Modules\Pet\Requests\CreateOrUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PetController extends Controller
{
    protected PetServiceInterface $petService;

    public function __construct(PetServiceInterface $petService)
    {
        $this->petService = $petService;
    }

    public function index(Request $request)
    {
        $statuses = PetStatus::values();
        $status = $request->get('status', PetStatus::AVAILABLE->value);
        $pets = $this->petService->getPetByStatus($status);

        return view('pets.index', compact('pets', 'status', 'statuses'));
    }

    public function create()
    {
        $categories = config('petstore.categories');
        $statuses = PetStatus::values();

        return view(
            'pets.create',
            compact('categories', 'statuses')
        );
    }

    public function store(CreateOrUpdateRequest $request)
    {
        try {
            $data = $request->all();
            response()->json($this->petService->addPet($data));
            session()->flash('success', 'Zwierzak został dodany');
            return redirect()->route('pets.index');
        } catch (\Exception $e) {
            return view('pets.error', [
                'errorCode' => $e->getCode(),
                'errorMessage' => $e->getMessage()
            ]);
        }
    }

    public function show(int $id)
    {
        try {
            $pet = $this->petService->getPetById($id);
            return view('pets.show', compact('pet'));
        }
        catch (\Exception $e) {
            return view('pets.error', [
                'errorCode' => $e->getCode(),
                'errorMessage' => $e->getMessage()
            ]);
        }
    }

    public function edit(int $id)
    {
        $pet = $this->petService->getPetById($id);
        $categories = config('petstore.categories');

        return view('pets.edit', compact('pet', 'categories'));
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->all();

        return response()->json($this->petService->updatePet($data));
    }

    public function partialUpdate(int $id, array $data)
    {
        return response()->json($this->petService->partialUpdatePet($data));
    }

    public function uploadImage(int $id, Request $request)
    {
        return response()->json($this->petService->uploadPetImage($id, $request));
    }

    public function destroy(int $id): JsonResponse
    {
        return response()->json($this->petService->deletePet($id));
    }
}
