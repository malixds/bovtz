<?php

namespace App\Interfaces;

use App\Models\Guest;

interface IGuestRepository
{
    public function find(int $id): ?Guest;
    public function update(int $id, array $data): void;
    public function delete(int $id): void;
    public function create(array $data): ?Guest;
    public function findOrFail($id): ?Guest;


}
