<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        //$categories = Category::with('categoryDetail')->get();
        $categories = Category::where('snactivo','S')->get();
    
                
        return $this->successResponse($categories);
    }

    /**
     * Create a new category
     * @param request
     * @return Illuminate\Http\Response
     */
    public function create(Request $request){
        $rules = [
            'nombre'=>'required|max:50',
            'codigo'=>'required|max:20',
            'snactivo'=>'required|in:S,N',
            'logo'=>'required|max:100'
        ];
        $this->validate($request,$rules);
        $category = Category::create($request->all());
        return $this->successResponse($category,Response::HTTP_CREATED);
    }

    /**
     * Show a category by id
     * @param category
     * @return Illuminate\Http\Response
     */
    public function show($category){

        $category = Category::findOrFail($category);
        return $this->successResponse($category);
    }

    /**
     * Update the category
     * @param request
     * @return Illuminate\Http\Response
     */
    public function update(Request $request,$category){
        $rules = [
            'nombre'=>'max:50',
            'codigo'=>'max:20',
            'snactivo'=>'in:S,N',
            'logo'=>'max:100'
        ];

        $this->validate($request,$rules);
        $category = Category::findOrFail($category);

        $category->fill($request->all());
        if($category->isClean()){
            return $this->errorResponse('At least one value must change'
                ,Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $category->save();
        return $this->successResponse($category);
    }

    /**
     * Delete a category
     * @param category
     * @return Illuminate\Http\Response
     */
    public function delete($category){

        $category = Category::findOrFail($category);

        // $category->delete();

        $category->snactivo='N';
        $category->save();
        return $this->successResponse($category);
    }
}
