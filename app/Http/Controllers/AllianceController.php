<?php

namespace App\Http\Controllers;

use App\Models\Alliance;
use App\Traits\ApiResponser;
use App\Services\CacheService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AllianceController extends Controller
{
    use ApiResponser;
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function index()
    {
        try {
            $cacheKey = 'alliances:all';
            $alliances = $this->cacheService->remember(
                $cacheKey,
                function () {
                    return Alliance::all();
                },
                null,
                'alliances'
            );
            return $this->successResponse($alliances);
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
            if ($request->hasFile('img_file')) {
                $fileName = $this->uploadImage($request->file('img_file'));
                $alliance = $request->all();
                $alliance['ruta_imagen'] = env('BASE_PATH_IMG_FRONT') . $fileName;
                $this->cacheService->invalidateType('alliances');
                return $this->successResponse(Alliance::create($alliance), Response::HTTP_CREATED);
            } else {
                return $this->errorResponse(
                    'Error processing image, not found file',
                    Response::HTTP_BAD_REQUEST
                );
            }
        } catch (ValidationException $ex) {
            return $this->errorResponse(
                $ex->errors(),
                Response::HTTP_BAD_REQUEST
            );
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred' . $ex,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function show($allianceId)
    {
        try {
            $cacheKey = "alliances:show:{$allianceId}";
            $alliances = $this->cacheService->remember(
                $cacheKey,
                function () use ($allianceId) {
                    return Alliance::findOrFail($allianceId);
                },
                null,
                'alliances'
            );
            return $this->successResponse($alliances);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $allianceId,
                Response::HTTP_NOT_FOUND
            );
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function showDetail($name)
    {
        try {
            $cacheKey = "alliances:show:{$name}";
            $alliances = $this->cacheService->remember(
                $cacheKey,
                function () use ($name) {
                    return Alliance::where('nombre', $name)->with('caracteristicas')->first();
                },
                null,
                'alliances'
            );
            return $this->successResponse($alliances);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $name,
                Response::HTTP_NOT_FOUND
            );
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(Request $request, $allianceId)
    {
        try {
            $this->validate($request, $this->rules());
            $alliances = Alliance::findOrFail($allianceId);
            $alliances->fill($request->all());
            if ($alliances->isClean()) {
                return $this->errorResponse(
                    'At least one value must change',
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }
            $alliances->save();
            $this->forgetCache($allianceId);
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
                'An unexpected error has occurred' . $ex,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function delete($allianceId)
    {
        try {
            $alliances = Alliance::findOrFail($allianceId);
            $this->deleteImage($alliances->ruta_imagen);
            $alliances->delete();
            $this->forgetCache($allianceId);
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

    public function updateImage(Request $request, $allianceId)
    {
        try {
            if (!empty($request->file('img_file'))) {
                $fileName = $this->uploadImage($request->file('img_file'));
                $alliance = $request->all();
                $alliances = Alliance::findOrFail($allianceId);
                $this->deleteImage($alliances->ruta_imagen);
                $alliances->ruta_imagen = env('BASE_PATH_IMG_FRONT') . $fileName;
                $alliances->save();
                $this->forgetCache($allianceId);
                return $this->successResponse($alliances);
            }
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse(
                'Not found data with parameter ' . $allianceId,
                Response::HTTP_NOT_FOUND
            );
        } catch (Exception $ex) {
            return $this->errorResponse(
                'An unexpected error has occurred' . $ex,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    private function uploadImage($file)
    {
        try {
            $path = env('BASE_PATH_IMG_SERV');
            $fileName = $file->getClientOriginalName();
            $file->move($path, $fileName);
            return $fileName;
        } catch (Exception $ex) {
            return $this->errorResponse(
                'Error processing image',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    private function deleteImage($file)
    {
        try {
            $pathFront = env('BASE_PATH_IMG_FRONT');
            $nameFile = str_replace($pathFront, "", $file);
            $pathServ = env('BASE_PATH_IMG_SERV');
            unlink($pathServ . $nameFile);
        } catch (Exception $ex) {
            return $this->errorResponse(
                'Error deleting image',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    private function rules()
    {
        return [
            'nombre' => 'required|max:50',
            'descripcion' => 'required',
            'ruta_imagen' => 'required',
            'pagina_web' => 'required',
            'direccion' => 'required',
            'barrio' => 'required'
        ];
    }

    private function forgetCache($id)
    {
        $this->cacheService->forget("alliances:show:$id");
        $this->cacheService->forget('alliances:all');
        $this->cacheService->invalidateType('alliances');
    }
}
