<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ThreadController extends Controller
{
    use AuthorizesRequests;
    public function edit(Thread $thread){
        $this->authorize('update', $thread);
        $categories = Category::get();
        return view('thread.edit', compact('categories', 'thread'));
    }


    public function update(Request $request,Thread $thread){
        $this->authorize('update', $thread);
        //Validación
        $request->validate([
            'category_id'=>'required',
            'title'=>'required',
            'body'=>'required'
        ]);
        //Update
        $thread->update($request->all());

        return redirect()->route('thread', $thread);
    }

    public function create(Thread $thread){
        $categories = Category::get();
        return view('thread.create', compact('categories', 'thread'));
    }


    public function store(Request $request){
        //Validación
        $request->validate([
            'category_id'=>'required',
            'title'=>'required',
            'body'=>'required'
        ]);
        //Update
        auth()->user()->threads()->create($request->all());

        return redirect()->route('threads');
    }
}
