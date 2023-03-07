<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class LoginUsersController extends Controller
{

    use ApiResponser;

    public function __construct()
    {
    }


    public function login(Request $request)
    {
        try {
            $rules = [
                'clave' => 'required|min:8',
                'correo' => 'required|max:50|email',
            ];
            $this->validate($request, $rules);
            $user = User::where('correo', $request->correo)->first();

            if (!isset($user) || !Hash::check($request->clave, $user->clave)) {
                return $this->errorResponse(
                    'Bad credentials',
                    Response::HTTP_UNAUTHORIZED
                );
            }
            $user->api_token = Str::random(150);
            $user->save();
            return $this->successResponse($user);
        } catch (ValidationException $ex) {
            $errors = $ex->errors();
            return $this->errorResponse(
                $errors,
                Response::HTTP_BAD_REQUEST
            );
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = auth()->user();
            $authHeadLogout = $request->header('Authorization');
            if ($user != null) {
                $user->api_token = null;
                $user->save();
            } else if ($authHeadLogout != null) {
                $user = User::where('api_token', $authHeadLogout)->firstOrFail();
                $user->api_token = null;
                $user->save();
            }
            return $this->successResponse("Close session successfull");
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
