<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {        
        $todos = Todo::with('childTodos')->whereNull('parent_id')->get();
        
        return view('todo.index', [
             'todos' => $todos
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3',
            'content' => 'required|min:20',
        ]);

        Todo::create([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'parent_id' => $request->input('parent_id'),
        ]);

        Session::flash('stored_message', 'Todo toegevoegd!');
        Session::flash('alert-class', 'alert-success'); 

        return redirect()->route('home');
    }    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {                        
        
        $result = $todo->update([ 'done' => ($request->get('done') === 'on') ]);        
        if($result) {
            $count_not_completed = Todo::where('parent_id',$todo->parent_id)
            ->where('done', '0')
            ->count();
            
            $parent=Todo::where('id', '=', $todo->parent_id);                
            if($count_not_completed == 0) {                                
                $parent->update(['done' => 'on']);
                $message_completed_task = response(json_decode(file_get_contents('https://official-joke-api.appspot.com/random_joke'), true));
            } else {
                $parent->update(['done' => '0']);
            }
        }
                
        return response($result, $result ? 200 : 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    
        if (invtal($id) > 0) {
            if (Todo::where('id', $id)->delete()) {
                Session::flash('stored_message', 'Todo verwijderd!');
                return redirect('/');
            }
        }
    }

}
