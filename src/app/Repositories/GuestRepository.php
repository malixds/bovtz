<?php

namespace App\Repositories;

use App\Interfaces\IGuestRepository;
use App\Models\Guest;

class GuestRepository implements IGuestRepository
{
    public function find(int $id): ?Guest
    {
        return Guest::query()->find($id);
    }

    public function update(int $id, array $data): void
    {
        Guest::whereId($id)->update($data);
    }

    public function delete(int $id): void
    {
        Guest::query()->find($id)->delete();
    }

    public function create(array $data): ?Guest
    {
        return Guest::query()->create($data);
    }

    /**
     * @throws \Exception
     */
    public function findOrFail($id): ?Guest
    {
        $guest = Guest::query()->find($id);
        if ($guest === null) {
            throw new \Exception('Guest not found');
        } else {
            return $guest;
        }
    }

}
