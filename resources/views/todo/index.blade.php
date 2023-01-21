<?php /* @var \App\Models\Todo[] $todos */ ?>

@extends('layout.app')

@section('content')
    <div class="container">
        <ul class="todo-list">
            
            @foreach($todos as $todo) 

            @if($todo->parent_id==null)
            <small>{{$todo->created_at->diffForHumans()}}</small>                
                <li class="todo-item">                    
                    <form class="todo-item__form" action="{{route('todos.update', $todo)}}" method="post">
                        @method('PUT')
                        @csrf
                        <input type="checkbox" name="done" {{ $todo->done ? 'checked' : null }}>
                    </form>
                    <div class="todo-item__content">
                        <h3>{{ ucfirst($todo->title) }}</h3>                        
                        <p>{{ $todo->content }}</p>
                    </div>                    
                </li>
         

                    @foreach($todo->childTodos as $child)
                    <small style='margin-left:6%;'>{{$child->created_at->diffForHumans()}}</small>
                    <ul class='todo_item-child-list'>
                            <li class="todo-item-child">
                            <form class="todo-item__form" action="{{route('todos.update', $child)}}" method="post">
                                @method('PUT')
                                @csrf
                                <input type="checkbox" name="done" {{ $child->done ? 'checked' : null }}>
                            </form>
                            <div class="todo-item__content-child">
                                <h3>{{ ucfirst($child->title) }}</h3>
                                <p>{{ $child->content }}</p>
                            </div>                    
                        </li>   
                    </ul>                 
                    @endforeach                    

            @endif
            @endforeach
        </ul>

        @if(Session::has('stored_message'))
            <p class="success">{{ Session::get('stored_message') }}</p>
        @endif

        @if(isset($message_completed_task))
                <p class="success">{{ $message_completed_task['setup'] }}<br />
                {{ $message_completed_task['punchline']}}
                </p>
        @endif

        <h2>Create To-do</h2>

        @if(count($errors) > 0)
            <div class="alert">
                <ul>
                @foreach($errors->all() as $error)
                <li>
                    {{$error}}
                </li>
                @endforeach
                </ul>
            </div>
        @endif

        <form action="{{route('todos.store')}}" method="post" class="create-todo">
            @csrf
            <div class="create-todo__input-group">
                <label for="title">Title</label>
                <input id="title" type="text" name="title">
            </div>

            @if(isset($todo))
            <div class="create-todo__input-group">
                <label for="title">Koppelen aan:</label>            
            <p>{{ $todo::getParentList() }}</p>
            </div>
            @endif
            

            <div class="create-todo__input-group">
                <label for="content">Description</label>
                <textarea id="content" name="content"cols="30" rows="10"></textarea>
            </div>
            <button class="button" type="submit">Save</button>
        </form>
    </div>
@endsection
