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
        //$companyInfoss = CompanyInfo::with('CompanyInfoDetail')->get();
        $companyInfos = CompanyInfo::all();
    
                
        return $this->successResponse($companyInfos);
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
        $companyInfos = CompanyInfo::create($request->all());
        return $this->successResponse($companyInfos,Response::HTTP_CREATED);
    }

    /**
     * Show a CompanyInfo by id
     * @param CompanyInfo
     * @return Illuminate\Http\Response
     */
    public function show($infoCompanyId){

        $infoCompanyId = CompanyInfo::findOrFail($infoCompanyId);
        return $this->successResponse($infoCompanyId);
    }

      /**
     * Show a category by id
     * @param socialNet
     * @return Illuminate\Http\Response
     */
    public function showDetail($infoCompanyId){

        $infoCompanyId = CompanyInfo::findOrFail($infoCompanyId)->with('caracteristicas')->first();
        return $this->successResponse($infoCompanyId);
    }

    /**
     * Update the CompanyInfo
     * @param request
     * @return Illuminate\Http\Response
     */
    public function update(Request $request,$infoCompanyId){
        $rules = [
            'nombre'=>'max:50',
            'codigo'=>'max:20',
            'snactivo'=>'in:S,N',
            'logo'=>'max:100'
        ];

        $this->validate($request,$rules);
        $infoCompanyId = CompanyInfo::findOrFail($infoCompanyId);

        $infoCompanyId->fill($request->all());
        if($infoCompanyId->isClean()){
            return $this->errorResponse('At least one value must change'
                ,Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $infoCompanyId->save();
        return $this->successResponse($infoCompanyId);
    }

    /**
     * Delete a CompanyInfo
     * @param CompanyInfo
     * @return Illuminate\Http\Response
     */
    public function delete($infoCompanyId){

        $infoCompanyId = CompanyInfo::findOrFail($infoCompanyId);

        // $companyInfos->delete();

        $infoCompanyId->snactivo='N';
        $infoCompanyId->save();
        return $this->successResponse($infoCompanyId);
    }
    
    
    

}