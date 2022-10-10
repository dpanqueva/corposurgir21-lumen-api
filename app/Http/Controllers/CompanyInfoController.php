<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompanyInfoController extends Controller{

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
     * Return all CompanyInfos
     * @return Illuminate\Http\Response
     */
    public function index(){
        //$CompanyInfoss = CompanyInfo::with('CompanyInfoDetail')->get();
        $CompanyInfos = CompanyInfo::where('snactivo','S')->get();
    
                
        return $this->successResponse($CompanyInfos);
    }

    /**
     * Create a new CompanyInfo
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
        $CompanyInfos = CompanyInfo::create($request->all());
        return $this->successResponse($CompanyInfos,Response::HTTP_CREATED);
    }

    /**
     * Show a CompanyInfo by id
     * @param CompanyInfo
     * @return Illuminate\Http\Response
     */
    public function show($CompanyInfos){

        $CompanyInfos = CompanyInfo::findOrFail($CompanyInfos);
        return $this->successResponse($CompanyInfos);
    }

    /**
     * Update the CompanyInfo
     * @param request
     * @return Illuminate\Http\Response
     */
    public function update(Request $request,$CompanyInfos){
        $rules = [
            'nombre'=>'max:50',
            'codigo'=>'max:20',
            'snactivo'=>'in:S,N',
            'logo'=>'max:100'
        ];

        $this->validate($request,$rules);
        $CompanyInfos = CompanyInfo::findOrFail($CompanyInfos);

        $CompanyInfos->fill($request->all());
        if($CompanyInfos->isClean()){
            return $this->errorResponse('At least one value must change'
                ,Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $CompanyInfos->save();
        return $this->successResponse($CompanyInfos);
    }

    /**
     * Delete a CompanyInfo
     * @param CompanyInfo
     * @return Illuminate\Http\Response
     */
    public function delete($CompanyInfos){

        $CompanyInfos = CompanyInfo::findOrFail($CompanyInfos);

        // $CompanyInfos->delete();

        $CompanyInfos->snactivo='N';
        $CompanyInfos->save();
        return $this->successResponse($CompanyInfos);
    }
    
    
    

}