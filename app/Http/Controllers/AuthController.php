<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\User\AuthUserDTO;
use App\DTO\User\LoginUserDTO;
use App\Http\Requests\LoginUserRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
// use App\Http\Requests\LoginRequest; // (se você já tem)
use Symfony\Component\HttpFoundation\Response;

final class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}

    // Troque Request por seu FormRequest (LoginRequest) se já existir.
    public function login(LoginUserRequest $request): Response
    {
        $validatedData = $request->validated();
        $dto = LoginUserDTO::fromArray($validatedData);

        $result = $this->authService->login($dto);
        $userDto = AuthUserDTO::fromModel($result['user']);

        return response()->json([
            'token' => $result['token'],
            'user' => $userDto->toArray(),
        ], 200);
    }


    public function me(Request $request): Response
    {
        $user = $request->user();

        return response()->json([
            'user' => AuthUserDTO::fromModel($user)->toArray(),
        ]);
    }

    public function logout(Request $request): Response
    {
        $user = $request->user();

        $this->authService->logoutCurrentToken($user);

        return response()->json([
            'message' => 'Logged out',
        ], 200);
    }
}
