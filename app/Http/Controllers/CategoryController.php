<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller{

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
     * Return all categories
     * @return Illuminate\Http\Response
     */
    public function index(){
        $categories = Category::where('snactivo','S')->get();
        return $this->successResponse($categories);
    }

    /**
     * Create a new category
     * @param request
     * @return Illuminate\Http\Response
     */
    public function create(Request $request){
        try{
            $rules = [
                'nombre'=>'required|max:50',
                'codigo'=>'required|max:20',
                'descripcion'=>'required',
                'logo'=>'required|max:100'
            ];
            $this->validate($request,$rules);
            $category = Category::create($request->all());
            
            return $this->successResponse($category,Response::HTTP_CREATED);
        }catch (ValidationException $ex ) { 
             return $this->errorResponse($ex->errors()
                ,Response::HTTP_BAD_REQUEST);
        }
        
    }

    /**
     * Show a category by id
     * @param category
     * @return Illuminate\Http\Response
     */
    public function show($category){

        $category = Category::where('codigo',$category)->first();
        return $this->successResponse($category);
    }

      /**
     * Show a category by id
     * @param category
     * @return Illuminate\Http\Response
     */
    public function showDetail($category){

        $category = Category::where('codigo',$category)->with('caracteristicas')->first();
        return $this->successResponse($category);
    }


    /**
     * Update the category
     * @param request
     * @return Illuminate\Http\Response
     */
    public function update(Request $request,$category){
        try{
            $rules = [
                'nombre'=>'required|max:50',
                'codigo'=>'required|max:20',
                'descripcion'=>'required',
                'logo'=>'required|max:100'
            ];

            $this->validate($request,$rules);
            $category = Category::findOrFail($category);

            $category->fill($request->all());
            if($category->isClean()){
                return $this->errorResponse('At least one value must change'
                    ,Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $category->save();
        }catch (ValidationException $ex ) {       
            return $this->errorResponse($ex->errors()
            ,Response::HTTP_BAD_REQUEST);
        }
        return $this->successResponse($category);
    }

    /**
     * Delete a category
     * @param category
     * @return Illuminate\Http\Response
     */
    public function delete($category){
        try{
            $category = Category::findOrFail($category);
            $category->delete();
            return $this->successResponse($category);
        }catch (ValidationException $ex ) {       
            return $this->errorResponse($ex->errors()
            ,Response::HTTP_BAD_REQUEST);
        }catch(ModelNotFoundException $e){
            return $this->errorResponse('Not found data with parameter '.$category 
            ,Response::HTTP_NOT_FOUND);
        }
    }
}
