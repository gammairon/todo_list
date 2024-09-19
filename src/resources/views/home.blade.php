@extends('layouts.app')
@include('components.flash')
@section('content')
<div class="container-custom to-do-list">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default ">
                <div class="panel-heading">To Do List</div>

                <div class="panel-body">
                    <div >
                        <button id="create_todo" type="button" class="btn btn-primary btn-lg">Create New Item</button>
                    </div>
                    <h3>Active Items</h3>
                    <section class="items active-items">
                        @foreach($activeItems as $activeItem)
                            @include('components.todo_list.todo_item', ['item' => $activeItem])
                        @endforeach

                    </section>
                    <h3>Done Items</h3>
                    <section class="items done-items">
                        @foreach($doneItems as $doneItem)
                            @include('components.todo_list.todo_item', ['item' => $doneItem])
                        @endforeach
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="todo_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <form id="todo_create" action="" >
                    <div class="form-group">
                        <label for="title" class="control-label">Title</label>
                        <input type="text" class="form-control" id="title" placeholder="Title" name="title" aria-describedby="title_help">
                        <span id="title_help" class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="5" aria-describedby="description_help"></textarea>
                        <span id="description_help" class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="status" class="control-label">Status</label>
                        <select id="status" name="status" class="form-control" aria-describedby="status_help">
                            @foreach($todoStatuses as $todoStatus)
                                <option value="{{$todoStatus}}">{{$todoStatus}}</option>
                            @endforeach
                        </select>
                        <span id="status_help" class="help-block"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="save_todo" type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endsection
