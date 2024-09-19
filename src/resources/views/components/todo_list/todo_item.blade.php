<div id="item-{{$item->id}}" class="item" data-id="{{$item->id}}">
    <div class="info">
        <h4>{{$item->title}}</h4>
    </div>
    <div class="actions">
        <time>{{$item->created_at}}</time>

        <div class="status {{$item->status}}">{{$item->status}}</div>
        <button type="button" class="btn btn-default view_todo">View</button>
        <button type="button" class="btn btn-success edit_todo">Edit</button>
        <button type="button" class="btn btn-danger delete_todo">Delete</button>
    </div>
</div>
