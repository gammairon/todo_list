<div class="show_todo_item flash">
    <h4 class="text-center">{{$todoItem->title}}</h4>
    <p>{{$todoItem->description}}</p>
    <p class="text-center"><span class="status {{$todoItem->status}}">{{$todoItem->status}}</span></p>
    <p class="text-center">{{$todoItem->created_at}}</p>
</div>

