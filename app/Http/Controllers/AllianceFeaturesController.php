<?php

namespace App\Http\Controllers;

use App\Models\AllianceFeatures;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AllianceFeaturesController extends Controller
{
    use ApiResponser;

    public function __construct(){}

    public function index()
    {
        try{
            return $this->successResponse(AllianceFeatures::all());
        }catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function showAlliancesByIdAndName($allianceId,$allianceName){
        try{
            return $this->successResponse(AllianceFeatures::where([
              ['alianza_id', '=',$allianceId,],
              ['codigo_nombre','=',$allianceName]
            ])->get());
        }catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred' . $ex,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function create(Request $request)
    {
        try {
            $this->validate($request, $this->rules());
            return $this->successResponse(AllianceFeatures::create($request->all()), Response::HTTP_CREATED);
        } catch (ValidationException $ex) {
            return $this->errorResponse(
                $ex->errors(),
                Response::HTTP_BAD_REQUEST
            );
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function show($allianceId)
    {
        try {
            return $this->successResponse(AllianceFeatures::findOrFail($allianceId));
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $allianceId,
                Response::HTTP_NOT_FOUND
            );
        }
    }

    public function update(Request $request, $allianceId)
    {
        try {
            $this->validate($request, $this->rules());
            $alliances = AllianceFeatures::findOrFail($allianceId);
            $alliances->fill($request->all());
            if ($alliances->isClean()) {
                return $this->errorResponse(
                    'At least one value must change',
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }
            $alliances->save();
            return $this->successResponse($alliances);
        } catch (ValidationException $ex) {
            return $this->errorResponse(
                $ex->errors(),
                Response::HTTP_BAD_REQUEST
            );
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $alliances,
                Response::HTTP_NOT_FOUND
            );
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function delete($allianceId)
    {
        try {
            $alliances = AllianceFeatures::findOrFail($allianceId);
            $alliances->delete();
            return $this->successResponse($alliances);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $alliances,
                Response::HTTP_NOT_FOUND
            );
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    private function rules()
    {
        return [
            'descripcion' => 'required',
            'codigo_nombre' => 'required',
            'nombre_caracteristica' => 'required',
            'alianza_id' => 'required'
        ];
    }
}
