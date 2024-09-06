<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestRequest;
use App\Http\Requests\GuestRequestUpdate;
use App\Models\Guest;
use App\Repositories\GuestRepository;
use Illuminate\Http\Request;

class GuestController
{

    protected GuestRepository $repository;

    public function __construct(GuestRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return response()->json(Guest::all(), 200);
    }

    public function create(GuestRequest $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validated();
        if (!$validatedData['country']) {
            $validatedData['country'] = $this->getCountryFromPhone($validatedData['phone']);
        }
        $guest = $this->repository->create($validatedData);
        if ($guest === null) {
            return response()->json(['message' => 'Guest not created'], 500);
        }
        return response()->json($guest, 201);
    }

    public function get(int $id): \Illuminate\Http\JsonResponse
    {
        $guest = $this->repository->find($id);
        if ($guest === null) {
            return response()->json(['message' => 'Guest not found'], 404);
        }
        return response()->json($guest, 200);
    }

    /**
     * @throws \Exception
     */
    public function update(GuestRequestUpdate $request, int $id): \Illuminate\Http\JsonResponse
    {
        $guest = $this->repository->find($id);
        $validatedData = $request->validated();
        if (isset($validatedData['phone']) && !$validatedData['country']) {
            $validatedData['country'] = $this->getCountryFromPhone($validatedData['phone']);
        }
        $this->repository->update($guest->id, $validatedData);
        return response()->json($guest->fresh(), 200);
    }

    public function delete(int $id): \Illuminate\Http\JsonResponse
    {
        $this->repository->delete($id);
        return response()->json(['message' => 'Guest deleted'], 204);
    }

    private function getCountryFromPhone($phone): string
    {
        if (str_starts_with($phone, '+7')) {
            return 'Russia';
        } elseif (str_starts_with($phone, '+1')) {
            return 'USA';
        } else {
            return 'Unknown';
        }
    }
}
