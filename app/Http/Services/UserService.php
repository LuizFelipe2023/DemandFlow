<?php

namespace App\Http\Services;

use App\Models\User;

class UserService
{

    public function getAll(?string $search = null)
    {
        return User::with('type')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10);
    }

    public function getUserById(int $id)
    {
        return User::with('type')->findOrFail($id);
    }

    public function storeUser(array $data)
    {
        return User::create($data);
    }

    public function updateUser(int $id, array $data): User
    {
        $user = $this->getUserById($id);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return $user;
    }

    public function deleteUser(int $id): bool
    {
        $user = $this->getUserById($id);

        return $user->delete();
    }
}