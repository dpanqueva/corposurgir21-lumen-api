<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DonationController extends Controller
{

    use ApiResponser;

    public function __construct()
    {
    }

    public function index()
    {
        try {
            return $this->successResponse(Donation::all());
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
            return $this->successResponse(Donation::create($request->all()), Response::HTTP_CREATED);
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

    public function show($donationId)
    {
        try {
            return $this->successResponse(Donation::findOrFail($donationId));
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $donationId,
                Response::HTTP_NOT_FOUND
            );
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(Request $request, $donationId)
    {
        try {
            $this->validate($request, $this->rules());
            $donation = Donation::findOrFail($donationId);
            $donation->fill($request->all());
            if ($donation->isClean()) {
                return $this->errorResponse(
                    'At least one value must change',
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $donation->save();
            return $this->successResponse($donation);
        } catch (ValidationException $ex) {
            return $this->errorResponse(
                $ex->errors(),
                Response::HTTP_BAD_REQUEST
            );
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $donationId,
                Response::HTTP_NOT_FOUND
            );
        }catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function delete($donationId)
    {
        try {
            $donation = Donation::findOrFail($donationId);
            $donation->delete();
            return $this->successResponse($donation);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $donationId,
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
            'banco_entidad' => 'required',
            'tipo_cuenta' => 'required',
            'numero_cuenta' => 'required',
            'logo' => 'required'
        ];
    }
}
