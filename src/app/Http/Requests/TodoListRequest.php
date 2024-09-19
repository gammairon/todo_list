<?php

namespace App\Http\Requests;

use App\Enums\TodoListStatus;
use App\Models\TodoList;
use Illuminate\Foundation\Http\FormRequest;

class TodoListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        if ($this->isMethod('put')){
            $todoItem = TodoList::find($this->route('todo_list'));

            return $todoItem && $this->user()->can('update', $todoItem);
        }
        else{
            return true;
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'              => 'required|string|max:255',
            'description'        => 'required|string',
            'status'             => 'required|string|max:20|in:'.implode(',', TodoListStatus::getStatusList()),
        ];
    }
}
