<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category as CategoryResource;
use App\Models\Category;
use Tymon\JWTAuth\JWTAuth;

/**
 * @resource Category
 *
 * API for category management
 */
class CategoryController extends Controller
{
    protected $jwt;
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(JWTAuth $jwt) {
        $this->jwt = $jwt;
        $this->user = $this->jwt->user();
    }

    /**
     * Index
     *
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Category::get();
        return CategoryResource::collection($items);
    }

    /**
     * Store
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $input = $request->all();
        $input['created_by'] = $this->user->id;

        Category::create($input);
        return response()->json([], 201);
    }

    /**
     * Show
     *
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Category::findOrFail($id);
        return new CategoryResource($item);
    }

    /**
     * Update
     *
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $input = $request->all();
        $input['updated_by'] = $this->user->id;

        Category::findOrFail($id)->update($input);
        return response()->json([]);
    }

    /**
     * Destroy
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Category::findOrFail($id);
        $item->update(['deleted_by' => $this->user->id]);
        $item->delete($id);
        return response()->json([]);
    }
}
