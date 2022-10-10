<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MenuController extends Controller{

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
        //$menus = Menu::with('MenuDetail')->get();
        $menus = Menu::where('snactivo','S')->get();
    
                
        return $this->successResponse($menus);
    }

    /**
     * Create a new Menu
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
        $menu = Menu::create($request->all());
        return $this->successResponse($menu,Response::HTTP_CREATED);
    }

    /**
     * Show a Menu by id
     * @param Menu
     * @return Illuminate\Http\Response
     */
    public function show($menu){

        $menu = Menu::findOrFail($menu);
        return $this->successResponse($menu);
    }

    /**
     * Update the Menu
     * @param request
     * @return Illuminate\Http\Response
     */
    public function update(Request $request,$menu){
        $rules = [
            'nombre'=>'max:50',
            'codigo'=>'max:20',
            'snactivo'=>'in:S,N',
            'logo'=>'max:100'
        ];

        $this->validate($request,$rules);
        $menu = Menu::findOrFail($menu);

        $menu->fill($request->all());
        if($menu->isClean()){
            return $this->errorResponse('At least one value must change'
                ,Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $menu->save();
        return $this->successResponse($menu);
    }

    /**
     * Delete a Menu
     * @param Menu
     * @return Illuminate\Http\Response
     */
    public function delete($menu){

        $menu = Menu::findOrFail($menu);

        // $menu->delete();

        $menu->snactivo='N';
        $menu->save();
        return $this->successResponse($menu);
    }
}
