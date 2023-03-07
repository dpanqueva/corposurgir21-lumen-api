<?php

namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CompanyInfoController extends Controller
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
     * Return all CompanyInfos
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        //$companyInfoss = CompanyInfo::with('CompanyInfoDetail')->get();
        $companyInfos = CompanyInfo::all();


        return $this->successResponse($companyInfos);
    }

    /**
     * Create a new CompanyInfo
     * @param request
     * @return Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $rules = [
                'nombre_empresa' => 'required',
                'direccion' => 'required',
                'ciudad_pais' => 'required',
                'numero_fijo' => 'required',
                'numero_celular' => 'required',
                'correo' => 'required'
            ];
            $this->validate($request, $rules);
            $companyInfos = CompanyInfo::create($request->all());
        } catch (ValidationException $ex) {
            return $this->errorResponse(
                $ex->errors(),
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->successResponse($companyInfos, Response::HTTP_CREATED);
    }

    /**
     * Show a CompanyInfo by id
     * @param CompanyInfo
     * @return Illuminate\Http\Response
     */
    public function show($infoCompanyId)
    {

        $infoCompanyId = CompanyInfo::findOrFail($infoCompanyId);
        return $this->successResponse($infoCompanyId);
    }

    /**
     * Show a category by id
     * @param socialNet
     * @return Illuminate\Http\Response
     */
    public function showDetail($infoCompanyId)
    {
        $infoCompanyId = CompanyInfo::findOrFail($infoCompanyId)->with('caracteristicas')->first();
        return $this->successResponse($infoCompanyId);
    }

    /**
     * Update the CompanyInfo
     * @param request
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $companyId)
    {
        try {
            $rules = [
                'nombre_empresa' => 'required',
                'direccion' => 'required',
                'ciudad_pais' => 'required',
                'numero_fijo' => 'required',
                'numero_celular' => 'required',
                'correo' => 'required'
            ];

            $this->validate($request, $rules);
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

    /**
     * Delete a CompanyInfo
     * @param CompanyInfo
     * @return Illuminate\Http\Response
     */
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
}
