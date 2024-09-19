<?php

namespace App\Http\Controllers;

use App\Enums\TodoListStatus;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('home', [
            'activeItems' => Auth::user()->todoLists()->status(TodoListStatus::ACTIVE)->orderBy('created_at', 'desc')->get(),
            'doneItems' => Auth::user()->todoLists()->status(TodoListStatus::DONE)->orderBy('created_at', 'desc')->get(),
            'todoStatuses' => TodoListStatus::getStatusList()
        ]);
    }
}
