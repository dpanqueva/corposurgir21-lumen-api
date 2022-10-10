<?php

namespace App\Http\Controllers;

use App\Models\CentralImage;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CentralImageController extends Controller{

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
        //$centalImages = CentralImage::with('allianceDetail')->get();
        $centalImages = CentralImage::where('snactivo','S')->get();
    
                
        return $this->successResponse($centalImages);
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
        $images = CentralImage::create($request->all());
        return $this->successResponse($images,Response::HTTP_CREATED);
    }

    /**
     * Show a Alliance by id
     * @param Alliance
     * @return Illuminate\Http\Response
     */
    public function show($images){

        $images = CentralImage::findOrFail($images);
        return $this->successResponse($images);
    }

    /**
     * Update the Alliance
     * @param request
     * @return Illuminate\Http\Response
     */
    public function update(Request $request,$images){
        $rules = [
            'nombre'=>'max:50',
            'codigo'=>'max:20',
            'snactivo'=>'in:S,N',
            'logo'=>'max:100'
        ];

        $this->validate($request,$rules);
        $images = CentralImage::findOrFail($images);

        $images->fill($request->all());
        if($images->isClean()){
            return $this->errorResponse('At least one value must change'
                ,Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $images->save();
        return $this->successResponse($images);
    }

    /**
     * Delete a Alliance
     * @param Alliance
     * @return Illuminate\Http\Response
     */
    public function delete($images){

        $images = CentralImage::findOrFail($images);

        // $images->delete();

        $images->snactivo='N';
        $images->save();
        return $this->successResponse($images);
    }
    
    
    

}