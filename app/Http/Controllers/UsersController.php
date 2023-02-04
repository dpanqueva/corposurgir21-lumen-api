<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller{

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
    public function index(){
        $users = User::all();
        return $this->successResponse($users);
    }

    /**
     * Create a new About
     * @param request
     * @return Illuminate\Http\Response
     */
    public function create(Request $request){
        $rules = [
            'nombre' => 'required|max:50',
            'apellido' => 'required|max:50',
            'clave' => 'required|min:8',
            'confirmar_clave' => 'required|same:clave',
            'correo' => 'required|max:50|email',
        ];
        $this->validate($request, $rules);

        $fields = $request->all();
        $fields['clave'] = Hash::make($request->clave);

        $user = User::create($fields);

        return $this->successResponse($user, Response::HTTP_CREATED);
    }

    /**
     * Show a About by id
     * @param usersId
     * @return Illuminate\Http\Response
     */
    public function show($usersId){

        $usersId = User::findOrFail($usersId);
        return $this->successResponse($usersId);
    }

    /**
     * Update the About
     * @param request
     * @param usersId
     * @return Illuminate\Http\Response
     */
    public function update(Request $request,$usersId){
        $rules = [
            'nombre'=>'max:50',
            'codigo'=>'max:20',
            'snactivo'=>'in:S,N',
            'logo'=>'max:100'
        ];

        $this->validate($request,$rules);
        $usersId = User::findOrFail($usersId);

        $usersId->fill($request->all());
        if($usersId->isClean()){
            return $this->errorResponse('At least one value must change'
                ,Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $usersId->save();
        return $this->successResponse($usersId);
    }

    /**
     * Delete a About
     * @param usersId
     * @return Illuminate\Http\Response
     */
    public function delete($usersId){

        $usersId = User::findOrFail($usersId);

        // $usersId->delete();

        $usersId->snactivo='N';
        $usersId->save();
        return $this->successResponse($usersId);
    }
}
