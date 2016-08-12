<?php

namespace App\Http\Controllers;

use App\Events\TaskToggled;
use App\Events\TaskDeleted;
use App\Events\TaskCreated;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Task;
use App\User;
use Notification;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Task::with('user')->get();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
				//	Validate the incoming data
        $this->validate($request, ['title'=>'required|string']);

				//	Create the task
				$task = Task::create(['user_id'=>auth()->user()->id, 'title'=>$request->title, 'completed'=>false]);

				//	Send notification to all users
				Notification::send(User::all(), new \App\Notifications\TaskCreated($task));

				//	Broadcast the new task to other users
				event(new TaskCreated($task));

				//	Return the task to the client
				return $task;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, Task $task)
    {
        $task->update($request->all());

				event(new TaskToggled($task));

				return $task;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Task $task)
    {
        $task->delete();

				event(new TaskDeleted($task->id));

    }
}
