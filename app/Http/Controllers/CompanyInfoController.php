<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class CompanyInfoController extends Controller
{

    use ApiResponser;

    public function __construct()
    {
    }

    public function index()
    {
        try {
            return $this->successResponse(CompanyInfo::all());
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
            return $this->successResponse(CompanyInfo::create($request->all()), Response::HTTP_CREATED);
        } catch (ValidationException $ex) {
            return $this->errorResponse(
                $ex->errors(),
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function show($infoCompanyId)
    {
        try {
            return $this->successResponse(CompanyInfo::findOrFail($infoCompanyId));
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $infoCompanyId,
                Response::HTTP_NOT_FOUND
            );
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function showDetail($infoCompanyId)
    {
        try {
            return $this->successResponse(CompanyInfo::findOrFail($infoCompanyId)->with('caracteristicas')->first());
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $infoCompanyId,
                Response::HTTP_NOT_FOUND
            );
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(Request $request, $companyId)
    {
        try {
            $this->validate($request, $this->rules());
            $infoCompanyId = CompanyInfo::findOrFail($companyId);
            $infoCompanyId->fill($request->all());
            if ($infoCompanyId->isClean()) {
                return $this->errorResponse(
                    'At least one value must change',
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }
            $infoCompanyId->save();
            return $this->successResponse($infoCompanyId);
        } catch (ValidationException $ex) {
            return $this->errorResponse(
                $ex->errors(),
                Response::HTTP_BAD_REQUEST
            );
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $infoCompanyId,
                Response::HTTP_NOT_FOUND
            );
        }
    }

    public function delete($companyId)
    {
        try {
            $infoCompanyId = CompanyInfo::findOrFail($companyId);
            $infoCompanyId->delete();
            return $this->successResponse($infoCompanyId);
        } catch (ValidationException $ex) {
            return $this->errorResponse(
                $ex->errors(),
                Response::HTTP_BAD_REQUEST
            );
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $infoCompanyId,
                Response::HTTP_NOT_FOUND
            );
        }
    }

    private function rules()
    {
        return [
            'nombre_empresa' => 'required',
            'direccion' => 'required',
            'ciudad_pais' => 'required',
            'numero_fijo' => 'required',
            'numero_celular' => 'required',
            'correo' => 'required'
        ];
    }
}
