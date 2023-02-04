<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginUsersController extends Controller{

    use ApiResponser;    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * Return all information about company
     * @return Illuminate\Http\Response
     */
    public function login(Request $request){
       
        $user = User::where('correo',$request->correo)->first();

        if(!isset($user) || !Hash::check($request->clave, $user->clave) ){
            return $this->errorResponse('Bad credentials'
            ,Response::HTTP_UNAUTHORIZED);
        }
        $user->api_token = Str::random(150);
        $user->save();
        return $this->successResponse($user);
    }

        /**
     * Return all information about company
     * @return Illuminate\Http\Response
     */
    public function logout(Request $request){
       
        $user = auth()->user();
        $user->api_token = null;
        $user->save();

        return $this->successResponse("Close session successfull");
    }

   
}
