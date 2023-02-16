<?php

namespace App\Http\Controllers;

use App\Models\AboutInformation;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AboutController extends Controller
{

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
    public function index()
    {
        $aboutInformation = AboutInformation::all();
        return $this->successResponse($aboutInformation);
    }

    /**
     * Create a new About
     * @param request
     * @return Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $rules = [
                'titulo' => 'required',
                'descripcion' => 'required',
                'logo' => 'required'
            ];
            $this->validate($request, $rules);
            $aboutId = AboutInformation::create($request->all());
        } catch (ValidationException $ex) {
            return $this->errorResponse(
                $ex->errors(),
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Show a About by id
     * @param aboutId
     * @return Illuminate\Http\Response
     */
    public function show($aboutId)
    {

        $aboutId = AboutInformation::findOrFail($aboutId);
        return $this->successResponse($aboutId);
    }

    /**
     * Update the About
     * @param request
     * @param aboutId
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $aboutId)
    {
        $rules = [
            'nombre' => 'max:50',
            'codigo' => 'max:20',
            'snactivo' => 'in:S,N',
            'logo' => 'max:100'
        ];

        $this->validate($request, $rules);
        $aboutId = AboutInformation::findOrFail($aboutId);

        $aboutId->fill($request->all());
        if ($aboutId->isClean()) {
            return $this->errorResponse(
                'At least one value must change',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $aboutId->save();
        return $this->successResponse($aboutId);
    }


    /**
     * Delete a category
     * @param about
     * @return Illuminate\Http\Response
     */
    public function delete($aboutId){
        try{
            $about = AboutInformation::findOrFail($aboutId);
            $about->delete();
            return $this->successResponse($about);
        }catch (ValidationException $ex ) {       
            return $this->errorResponse($ex->errors()
            ,Response::HTTP_BAD_REQUEST);
        }catch(ModelNotFoundException $e){
            return $this->errorResponse('Not found data with parameter '.$about 
            ,Response::HTTP_NOT_FOUND);
        }
    }
}
