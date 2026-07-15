<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Services\UserTypeService;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $userService;
    protected UserTypeService $userTypeService;

    public function __construct(UserService $userService, UserTypeService $userTypeService)
    {
        $this->userService = $userService;
        $this->userTypeService = $userTypeService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = $this->userService->getAll($search);

        return view('users.index', compact('users', 'search'));
    }

    public function create()
    {
        $userTypes = $this->userTypeService->getAllTypes();

        return view('users.create', compact('userTypes'));
    }

    public function store(StoreUserRequest $request)
    {
        // $request->validated() já traz somente os dados sanitizados e validados
        $this->userService->storeUser($request->validated());

        return redirect()->route('users.index')
            ->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function show(int $id)
    {
        $user = $this->userService->getUserById($id);

        return view('users.show', compact('user'));
    }

    public function edit(int $id)
    {
        $user = $this->userService->getUserById($id);
        $userTypes = $this->userTypeService->getAllTypes();

        return view('users.edit', compact('user', 'userTypes'));
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        $this->userService->updateUser($id, $request->validated());

        return redirect()->route('users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(int $id)
    {
        $this->userService->deleteUser($id);

        return redirect()->route('users.index')
            ->with('success', 'Usuário excluído com sucesso!');
    }
}