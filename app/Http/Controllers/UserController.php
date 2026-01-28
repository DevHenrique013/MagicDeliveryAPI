<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTO\User\CreateUserDTO;
use App\DTO\User\BalanceChangeDTO;
use App\Http\Requests\CreateUserRequest;
use Symfony\Component\HttpFoundation\Response;
use App\DTO\User\AuthUserDTO;
use App\Services\UserService;

final class UserController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    /**
     * POST /api/users
     * Criar conta (pública)
     */
    public function store(CreateUserRequest $request): Response
    {
        $validatedData = $request->validated();
        $dto = CreateUserDTO::fromArray($validatedData);

        $user = $this->userService->create($dto);

        return response()->json([
            'user' => AuthUserDTO::fromModel($user)->toArray(),
        ], 201);
    }

    /**
     * GET /api/users/me
     * Retorna usuário logado (protegida)
     */
    public function me(Request $request): Response
    {
        $user = $request->user();

        return response()->json([
            'user' => AuthUserDTO::fromModel($user)->toArray(),
        ], 200);
    }

    /**
     * GET /api/users
     * (opcional) listar usuários - normalmente isso seria admin
     */
    public function index(): Response
    {
        $users = $this->userService->list();

        return response()->json([
            'users' => $users->map(fn ($u) => AuthUserDTO::fromModel($u)->toArray())->values(),
        ], 200);
    }

    /**
     * PATCH /api/users/balance/increase
     * body: { "amount": 100, "reason": "...", "referenceId": "..." }
     */
    public function increaseBalance(Request $request): Response
    {
        $data = $request->validate([
            'amount' => ['required', 'integer', 'min:1'],
            'reason' => ['sometimes', 'string', 'max:255'],
            'referenceId' => ['sometimes', 'string', 'max:100'],
        ]);

        $userId = (string)$request->user()->id;

        $dto = BalanceChangeDTO::increase(
            userId: $userId,
            amount: (int)$data['amount'],
            reason: $data['reason'] ?? null,
            referenceId: $data['referenceId'] ?? null
        );

        $user = $this->userService->applyBalanceChange($dto);

        return response()->json([
            'user' => AuthUserDTO::fromModel($user)->toArray(),
        ], 200);
    }

    /**
     * PATCH /api/users/balance/decrease
     * body: { "amount": 100, "reason": "...", "referenceId": "..." }
     */
    public function decreaseBalance(Request $request): Response
    {
        $data = $request->validate([
            'amount' => ['required', 'integer', 'min:1'],
            'reason' => ['sometimes', 'string', 'max:255'],
            'referenceId' => ['sometimes', 'string', 'max:100'],
        ]);

        $userId = (string)$request->user()->id;

        $dto = BalanceChangeDTO::decrease(
            userId: $userId,
            amount: (int)$data['amount'],
            reason: $data['reason'] ?? null,
            referenceId: $data['referenceId'] ?? null
        );

        $user = $this->userService->applyBalanceChange($dto);

        return response()->json([
            'user' => AuthUserDTO::fromModel($user)->toArray(),
        ], 200);
    }
}
