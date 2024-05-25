<?php

namespace App\Livewire;

use App\Models\Reply;
use Livewire\Component;
//use Illuminate\Foundation\Auth\Access\AuthorizesRequests; No es necesario en laravel 10

class ShowReply extends Component
{
    //use AuthorizesRequests;
    public Reply $reply;

    public $body = '';
    public $is_creating = false;
    public $is_editing = false;

    public function updatedIsCreating(){
        $this->is_editing = false;
        $this->body = '';
    }

    public function updatedIsEditing(){
        $this->authorize('update',$this->reply);
        $this->is_creating = false;
        $this->body = $this->reply->body;
    }

    public function postChild(){
        //validación
        if(!is_null($this->reply->reply_id)) return;
        $this->validate(['body'=>'required']);
        //creación
        auth()->user()->replies()->create([
            'reply_id' => $this->reply->id,
            'thread_id' => $this->reply->thread->id,
            'body' => $this->body
        ]);
        //refrescar
        $this->body = '';
        $this->is_creating = false;
        $this->dispatch('refresh')->self();
    }

    public function updateReply(){
        $this->authorize('update',$this->reply);

        //validación
        $this->validate(['body'=>'required']);
        //update
        $this->reply->update([
            'body' => $this->body
        ]);
        //refrescar
        $this->is_editing = false;
    }

    public function render()
    {
        return view('livewire.show-reply');
    }
}
