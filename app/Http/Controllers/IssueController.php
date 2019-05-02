<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Issue as IssueResource;
use App\Models\Issue;
use Tymon\JWTAuth\JWTAuth;

/**
 * @resource Issue
 *
 * API for issue management
 */
class IssueController extends Controller
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
        $items = Issue::get();
        return IssueResource::collection($items);
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
            'category_id' => 'required|exists:categories,id|integer',
            'label_id' => 'sometimes|required|exists:labels,id|integer',
            'user_id' => 'sometimes|required|exists:users,id|integer',
            'name' => 'required',
        ]);

        $input = $request->all();
        $input['created_by'] = $this->user->id;

        $item = Issue::create($input);
        $item->labels()->sync($input['label_id']);
        $item->assignees()->sync($input['user_id']);
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
        $item = Issue::findOrFail($id);
        return new IssueResource($item);
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
            'category_id' => 'required|exists:categories,id|integer',
            'label_id' => 'sometimes|required|exists:labels,id|integer',
            'user_id' => 'sometimes|required|exists:users,id|integer',
            'name' => 'required',
        ]);

        $input = $request->all();
        $input['updated_by'] = $this->user->id;

        $item = Issue::findOrFail($id);
        $item->update($input);
        $item->labels()->sync($input['label_id']);
        $item->assignees()->sync($input['user_id']);
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
        $item = Issue::findOrFail($id);
        $item->update(['deleted_by' => $this->user->id]);
        $item->delete($id);
        return response()->json([]);
    }
}
