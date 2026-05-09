<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(protected UserRepository $repository) {}

    public function getAll(int $perPage = 10)
    {
        return $this->repository->getAll($perPage);
    }

    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): User
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        return $this->repository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        if ($id === auth()->id()) {
            abort(403, 'Tidak bisa menghapus akun sendiri.');
        }
        return $this->repository->delete($id);
    }
}