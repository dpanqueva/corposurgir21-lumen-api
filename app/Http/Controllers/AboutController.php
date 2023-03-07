<?php

namespace App\Http\Controllers;

use App\Models\AboutInformation;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AboutController extends Controller
{

    use ApiResponser;

    public function __construct()
    {
    }

    public function index()
    {
        try {
            return $this->successResponse(AboutInformation::all());
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
            return $this->successResponse(AboutInformation::create($request->all()), Response::HTTP_CREATED);
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

    public function show($aboutId)
    {
        try {
            return $this->successResponse(AboutInformation::findOrFail($aboutId));
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $aboutId,
                Response::HTTP_NOT_FOUND
            );
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(Request $request, $aboutId)
    {
        try {
            $this->validate($request, $this->rules());
            $about = AboutInformation::findOrFail($aboutId);
            $about->fill($request->all());
            if ($about->isClean()) {
                return $this->errorResponse(
                    'At least one value must change',
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }
            $about->save();
            return $this->successResponse($about);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $aboutId,
                Response::HTTP_NOT_FOUND
            );
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

    public function delete($aboutId)
    {
        try {
            $about = AboutInformation::findOrFail($aboutId);
            $about->delete();
            return $this->successResponse($about);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $aboutId,
                Response::HTTP_NOT_FOUND
            );
        }catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    private function rules()
    {
        return [
            'titulo' => 'required',
            'descripcion' => 'required',
            'logo' => 'required'
        ];
    }
}
