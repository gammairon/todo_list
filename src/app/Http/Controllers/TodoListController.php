<?php

namespace App\Http\Controllers;

use App\Enums\TodoListStatus;
use App\Http\Requests\TodoListRequest;
use App\Models\TodoList;
use App\Services\TodoListService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoListController extends Controller
{

    protected $service;


    public function __construct(TodoListService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->service->createResponse([
            'active' => Auth::user()->todoLists()->status(TodoListStatus::ACTIVE)->orderBy('created_at', 'desc')->get(),
            'done' => Auth::user()->todoLists()->status(TodoListStatus::DONE)->orderBy('created_at', 'desc')->get(),
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TodoListRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoListRequest $request)
    {

        return $this->service->createTodoList($request->except(['api_token']));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->service->showTodoList($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->service->editTodoList($id);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TodoListRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TodoListRequest $request, $id)
    {
        return $this->service->updateTodoList($request->except(['_method']), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        return $this->service->deleteTodoList($id);

    }
}
