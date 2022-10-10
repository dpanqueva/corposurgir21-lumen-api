<?php

namespace App\Http\Controllers;

use App\Models\AllianceDetail;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AllianceDetailController extends Controller{

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
     * Return all alliances
     * @return Illuminate\Http\Response
     */
    public function index(){
        $alliances = AllianceDetail::with('allianceImage')->get();
        //$alliances = AllianceDetail::where('snactivo','S')->get();
    
                
        return $this->successResponse($alliances);
    }

    /**
     * Create a new Alliance
     * @param request
     * @return Illuminate\Http\Response
     */
    public function create(Request $request){
        $rules = [
            'nombre'=>'required|max:50',
            'codigo'=>'required|max:20',
            'snactivo'=>'required|in:S,N',
            'logo'=>'required|max:100'
        ];
        $this->validate($request,$rules);
        $alliances = AllianceDetail::create($request->all());
        return $this->successResponse($alliances,Response::HTTP_CREATED);
    }

    /**
     * Show a Alliance by id
     * @param Alliance
     * @return Illuminate\Http\Response
     */
    public function show($alliances){

        $alliances = AllianceDetail::findOrFail($alliances);
        return $this->successResponse($alliances);
    }

    /**
     * Update the Alliance
     * @param request
     * @return Illuminate\Http\Response
     */
    public function update(Request $request,$alliances){
        $rules = [
            'nombre'=>'max:50',
            'codigo'=>'max:20',
            'snactivo'=>'in:S,N',
            'logo'=>'max:100'
        ];

        $this->validate($request,$rules);
        $alliances = AllianceDetail::findOrFail($alliances);

        $alliances->fill($request->all());
        if($alliances->isClean()){
            return $this->errorResponse('At least one value must change'
                ,Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $alliances->save();
        return $this->successResponse($alliances);
    }

    /**
     * Delete a Alliance
     * @param Alliance
     * @return Illuminate\Http\Response
     */
    public function delete($alliances){

        $alliances = AllianceDetail::findOrFail($alliances);

        // $alliances->delete();

        $alliances->snactivo='N';
        $alliances->save();
        return $this->successResponse($alliances);
    }
    
    
    

}