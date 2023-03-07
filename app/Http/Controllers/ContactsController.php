<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContactsController extends Controller
{

    use ApiResponser;

    public function __construct()
    {
    }

    public function index()
    {
        try {
            return $this->successResponse(Contact::all());
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
            $contact = Contact::create($request->all());
            $mail = $this->sendEmail($contact);
            return $this->successResponse($contact, Response::HTTP_CREATED);
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

    public function show($ContactId)
    {
        try {
            return $this->successResponse(Contact::findOrFail($ContactId));
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $ContactId,
                Response::HTTP_NOT_FOUND
            );
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(Request $request, $ContactId)
    {
        try {
            $this->validate($request, $this->rules());
            $Contact = Contact::findOrFail($ContactId);
            $Contact->fill($request->all());
            if ($Contact->isClean()) {
                return $this->errorResponse(
                    'At least one value must change',
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $Contact->save();
            return $this->successResponse($Contact);
        } catch (ValidationException $ex) {
            return $this->errorResponse(
                $ex->errors(),
                Response::HTTP_BAD_REQUEST
            );
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $ContactId,
                Response::HTTP_NOT_FOUND
            );
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function delete($ContactId)
    {
        try {
            $Contact = Contact::findOrFail($ContactId);
            $Contact->delete();
            return $this->successResponse($Contact);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $ContactId,
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
            'correo' => 'required|email',
            'numero_contacto' => 'required',
            'tipo_contacto' => 'required',
            'mensaje' => 'required'
        ];
    }

    private function sendEmail($contact)
    {
        try {

            $to      = 'servicioalcliente@corposurgir21.org';
            $subject = $contact->tipo_contacto;
            $message = $contact->mensaje . "\r\n";
            $message .= "Número de contacto: " . $contact->numero_contacto . "\r\n";
            $message .= "Correo de contacto: " . $contact->correo . "\r\n";
            $headers = 'From: noreply@corposurgir21.org' . "\r\n" .
                'Reply-To: noreply@corposurgir21.org' . "\r\n" .
                'X-Mailer: PHP/' . phpversion() . "\r\n" .
                'Content-type: text/html; charset=utf-8';

            return mail($to, $subject, $message, $headers);
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred sending email: ' . $ex,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
