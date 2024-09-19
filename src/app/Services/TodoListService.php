<?php


namespace App\Services;

use App\Models\TodoList;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TodoListService
{

    public function editTodoList($id)
    {
        if ($todoItem = Auth::user()->todoLists()->find($id)){
            return $this->createResponse([
                'todoItem' => $todoItem,
                'find' => 1
            ]);
        }
        else{
            return $this->createResponse([
                'message' => view('components.messages.modal.danger', [
                    'message' => 'Something went wrong. Try again.',
                ])->render(),
                'find' => 0
            ]);
        }
    }

    public function updateTodoList(array $data, $id)
    {
        $todoItem = Auth::user()->todoLists()->find($id);

        if ($todoItem->update($data)){
            return $this->createResponse([
                'message' => view('components.messages.modal.success', [
                    'message' => 'TodoList updated successfully'
                ])->render(),
                'todoItem' => $todoItem
            ]);
        }
        else{
            return $this->createResponse([
                'message' => view('components.messages.modal.danger', [
                    'message' => 'Something went wrong. Try again.'
                ])->render(),
                'todoItem' => 0
            ]);
        }
    }

    public function createTodoList(array $data)
    {
        $todoItem = new TodoList($data);
        Auth::user()->todoLists()->save($todoItem);
        return $this->createResponse([
            'message' => view('components.messages.modal.success', [
                'message' => 'TodoList created successfully'
            ])->render(),
            'todoItem' => view('components.todo_list.todo_item', [
                'item' => $todoItem
            ])->render(),
            'board' => $todoItem->status
        ]);
    }

    public function showTodoList( $id)
    {
        if ($todoItem = Auth::user()->todoLists()->find($id)){
            return $this->createResponse([
                'message' => view('components.messages.modal.show_todo_item', [
                    'todoItem' => $todoItem,
                ])->render()
            ]);
        }
        else{
            return $this->createResponse([
                'message' => view('components.messages.modal.danger', [
                    'message' => 'Something went wrong. Try again.',
                ])->render()
            ]);
        }
    }

    public function deleteTodoList($id)
    {
        if ($todoList = Auth::user()->todoLists()->find($id)){
            $todoList->delete();
            return $this->createResponse([
                'message' => view('components.messages.modal.success', [
                    'message' => 'TodoList deleted successfully'
                ])->render(),
                'id' => $id
            ]);
        }
        else{
            return $this->createResponse([
                'message' => view('components.messages.modal.danger', [
                    'message' => 'TodoList deleted failed. Try again!'
                ])->render(),
                'id' => 0
            ]);
        }
    }

    public function createResponse(array $data)
    {
        return response()->json($data);
    }
}
