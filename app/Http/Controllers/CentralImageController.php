<?php

namespace App\Http\Controllers;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

use App\Models\CentralImage;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CentralImageController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
    }

    public function index()
    {
        try {
            return $this->successResponse(CentralImage::all());
        } catch (Exception $ex) {
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
            $images = CentralImage::create($request->all());
            return $this->successResponse($images, Response::HTTP_CREATED);
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

    public function show($images)
    {
        try {
            return $this->successResponse(CentralImage::findOrFail($images));
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $images,
                Response::HTTP_NOT_FOUND
            );
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(Request $request, $images)
    {
        try {
            $this->validate($request, $this->rules());
            $images = CentralImage::findOrFail($images);
            $images->fill($request->all());
            if ($images->isClean()) {
                return $this->errorResponse(
                    'At least one value must change',
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }
            $images->save();
            return $this->successResponse($images);
        } catch (ValidationException $ex) {
            return $this->errorResponse(
                $ex->errors(),
                Response::HTTP_BAD_REQUEST
            );
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $images,
                Response::HTTP_NOT_FOUND
            );
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function delete($images)
    {
        try {

            $images = CentralImage::findOrFail($images);
            $images->delete();
            return $this->successResponse($images);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $images,
                Response::HTTP_NOT_FOUND
            );
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function rules()
    {
        return [
            'nombre' => 'required|max:50',
            'codigo' => 'required|max:20',
            'snactivo' => 'required|in:S,N',
            'logo' => 'required|max:100'
        ];
    }
}
