<?php

namespace App\Modules\Pet\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Pet\Enums\PetStatus;
use App\Modules\Pet\Interfaces\PetServiceInterface;
use App\Modules\Pet\Requests\CreateOrUpdateRequest;
use App\Modules\Pet\Requests\PartialUpdateRequest;
use App\Modules\Pet\Requests\UploadImageRequest;
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
        } catch (\Exception $e) {
            return view('pets.error', [
                'errorCode' => $e->getCode(),
                'errorMessage' => $e->getMessage()
            ]);
        }
    }

    public function edit(int $id)
    {
        try {
            $pet = $this->petService->getPetById($id);
            $categories = config('petstore.categories');
            return view('pets.edit', compact('pet', 'categories'));
        } catch (\Exception $e) {
            return view('pets.error', [
                'errorCode' => $e->getCode(),
                'errorMessage' => $e->getMessage()
            ]);
        }
    }

    public function update(CreateOrUpdateRequest $request)
    {
        $data = $request->all();
        try {
            response()->json($this->petService->updatePet($data));
            session()->flash('success', 'Edycja zwierzaka powiodła się');
            return redirect()->route('pets.index');
        } catch (\Exception $e) {
            return view('pets.error', [
                'errorCode' => $e->getCode(),
                'errorMessage' => $e->getMessage()
            ]);
        }

    }

    public function partialEdit(int $id)
    {
        try {
            $pet = $this->petService->getPetById($id);
            return view('pets.partial_edit', compact('pet'));
        } catch (\Exception $e) {
            return view('pets.error', [
                'errorCode' => $e->getCode(),
                'errorMessage' => $e->getMessage()
            ]);
        }
    }

    public function partialUpdate(int $id, PartialUpdateRequest $request)
    {
        $data = $request->all();
        try {
            $this->petService->partialUpdatePet($id, $data);
            session()->flash('success', 'Edycja częściowa zwierzaka powiodła się');
            return redirect()->route('pets.index');
        } catch (\Exception $e) {
            return view('pets.error', [
                'errorCode' => $e->getCode(),
                'errorMessage' => $e->getMessage()
            ]);
        }
    }

    public function uploadImage(int $id, UploadImageRequest $request)
    {
        try {
            $this->petService->uploadPetImage($id, $request);
            session()->flash('success', 'Dodanie zdjęcia powiodło się');
            return redirect()->route('pets.index');
        } catch (\Exception $e) {
            return view('pets.error', [
                'errorCode' => $e->getCode(),
                'errorMessage' => $e->getMessage()
            ]);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->petService->deletePet($id);
            session()->flash('success', 'Zwierzak został usunięty');
            return redirect()->route('pets.index');
        } catch (\Exception $e) {
            return view('pets.error', [
                'errorCode' => $e->getCode(),
                'errorMessage' => $e->getMessage()
            ]);
        }
    }
}
