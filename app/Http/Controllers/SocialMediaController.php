<?php

namespace App\Http\Controllers;

use App\Models\SocialNetworkCompany;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SocialMediaController extends Controller
{

    use ApiResponser;

    public function __construct()
    {
    }

    public function index()
    {
        try {
            return $this->successResponse(SocialNetworkCompany::all());
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
            return $this->successResponse(SocialNetworkCompany::create($request->all()), Response::HTTP_CREATED);
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

    public function show($socialMediaId)
    {
        try {
            return $this->successResponse(SocialNetworkCompany::findOrFail($socialMediaId));
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $socialMediaId,
                Response::HTTP_NOT_FOUND
            );
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(Request $request, $socialMediaId)
    {
        try {
            $this->validate($request, $this->rules());
            $socialMedia = SocialNetworkCompany::findOrFail($socialMediaId);
            $socialMedia->fill($request->all());
            if ($socialMedia->isClean()) {
                return $this->errorResponse(
                    'At least one value must change',
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $socialMedia->save();
            return $this->successResponse($socialMedia);
        } catch (ValidationException $ex) {
            return $this->errorResponse(
                $ex->errors(),
                Response::HTTP_BAD_REQUEST
            );
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $socialMediaId,
                Response::HTTP_NOT_FOUND
            );
        }catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function delete($socialMediaId)
    {
        try {
            $socialMedia = SocialNetworkCompany::findOrFail($socialMediaId);
            $socialMedia->delete();
            return $this->successResponse($socialMedia);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $socialMediaId,
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
            'nombre' => 'required',
            'url_red_social' => 'required',
            'logo' => 'required',
            'info_empresa_id' => 'required'
        ];
    }
}
