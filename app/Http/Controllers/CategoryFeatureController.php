<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use App\Models\CategoryFeature;
use Illuminate\Validation\ValidationException;

class CategoryFeatureController extends BaseController
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
     * Return all features
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $categories = CategoryFeature::all();
        return $this->successResponse($categories);
    }

    /**
     * Show a feature by code
     * @param feature
     * @return Illuminate\Http\Response
     */
    public function show($featureId)
    {
        try {
            return $this->successResponse(CategoryFeature::findOrFail($featureId));
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $featureId,
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * Create a new feature
     * @param request
     * @return Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $rules = [
                'nombre_caracteristica' => 'required|max:50',
                'codigo_nombre' => 'required|max:20',
                'descripcion' => 'required',
                'categoria_id' => 'required'
            ];
            $this->validate($request, $rules);
            $category = CategoryFeature::create($request->all());
            return $this->successResponse($category, Response::HTTP_CREATED);
        } catch (ValidationException $ex) {
            return $this->errorResponse(
                $ex->errors(),
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Update the feature
     * @param request
     * @param feature
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $featureId)
    {
        try {
            $rules = [
                'nombre_caracteristica' => 'required|max:50',
                'codigo_nombre' => 'required|max:20',
                'descripcion' => 'required',
                'categoria_id' => 'required'
            ];

            $this->validate($request, $rules);
            $feature = CategoryFeature::findOrFail($featureId);

            $feature->fill($request->all());
            if ($feature->isClean()) {
                return $this->errorResponse(
                    'At least one value must change',
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $feature->save();
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
        }
        return $this->successResponse($feature);
    }

    /**
     * Delete a feature
     * @param feature
     * @return Illuminate\Http\Response
     */
    public function delete($featureObj)
    {
        try {
            $feature = CategoryFeature::findOrFail($featureObj);
            $feature->delete();
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
        }
    }
}
