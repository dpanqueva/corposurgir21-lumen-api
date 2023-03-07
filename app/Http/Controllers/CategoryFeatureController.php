<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use App\Models\CategoryFeature;

class CategoryFeatureController extends BaseController
{
    use ApiResponser;

    public function __construct()
    {}

    public function index()
    {
        try {
            return $this->successResponse(CategoryFeature::all());
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function show($featureId)
    {
        try {
            return $this->successResponse(CategoryFeature::findOrFail($featureId));
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $featureId,
                Response::HTTP_NOT_FOUND
            );
        }catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function create(Request $request)
    {
        try {
            $this->validate($request, $this->rules());
            $category = CategoryFeature::create($request->all());
            return $this->successResponse($category, Response::HTTP_CREATED);
        } catch (ValidationException $ex) {
            return $this->errorResponse(
                $ex->errors(),
                Response::HTTP_BAD_REQUEST
            );
        }catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(Request $request, $featureId)
    {
        try {
            $this->validate($request, $this->rules());
            $feature = CategoryFeature::findOrFail($featureId);
            $feature->fill($request->all());
            if ($feature->isClean()) {
                return $this->errorResponse(
                    'At least one value must change',
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }
            $feature->save();
            return $this->successResponse($feature);
        } catch (ValidationException $ex) {
            return $this->errorResponse(
                $ex->errors(),
                Response::HTTP_BAD_REQUEST
            );
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $feature,
                Response::HTTP_NOT_FOUND
            );
        }catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function delete($featureObj)
    {
        try {
            $feature = CategoryFeature::findOrFail($featureObj);
            $feature->delete();
            return $this->successResponse($feature);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $feature,
                Response::HTTP_NOT_FOUND
            );
        }catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    private function rules(){
        return [
            'nombre_caracteristica' => 'required|max:50',
            'codigo_nombre' => 'required|max:20',
            'descripcion' => 'required',
            'categoria_id' => 'required'
        ];
    }
}
