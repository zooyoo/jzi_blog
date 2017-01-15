<?php

namespace App\Http\Controllers;

use App\Task;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    protected $tasks;

    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');
        $this->tasks = $tasks;
    }

    public function index(Request $request){
        /*$tasks = Task::where('user_id', $request->user()->id)->get();

        return view('task.index', [
            'tasks' => $tasks,
        ]);*/

        return view('task.index', [
           'task' => $this->tasks->forUser($request->user()),
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect('/tasks');
    }

    public function destroy(Request $request, Task $task){
        $this->authorize('destroy', $task);
        $task->delete();
        return redirect('/tasks');
    }
}
