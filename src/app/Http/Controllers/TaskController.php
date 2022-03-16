<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Task $task)
    {
        $list = $task->newQuery();
        $status = request()->get('status');
        if(Auth::user()-> role == 'user'){
            $employee = Auth::id();
        }else{
            $employee = request()->get('employee');
        }
        $created_at = request()->get('created_at');
        $due_date = request()->get('due_date');
        
        if($status){
            $list->where('status', $status);
        }
        
        if($employee){
            $list->where('employee_id', $employee);
        }
        
        if($created_at){
            $list->where('created_at', $created_at);
        }
        
        if($due_date){
            $list->where('due_date', $due_date);
        }
        
        $tasks = $list->orderBy('id', 'DESC')->paginate(60);

        $employees = User::orderBy('id', 'DESC')->where('role', 'user')->where('status', 2)->get();

        return view('task.task',[
                                    'tasks' => $tasks, 
                                    'employees' => $employees,
                                    'status' => $status,
                                    'employee' => $employee,
                                    'created_at' => $created_at,
                                    'due_date' => $due_date,
                                ]);
    }

    public function updateStatus($id, $status)
    {
        $task = Task::findOrFail($id);
        if (auth::user()->role == 'admin') {
            if($status == 'review'){
                $task->status = 4;
            }
            if($status == 'completed'){
                $task->status = 5;
                $task->completed_at = date('Y-m-d H:i:s');
            }
        }
        if (auth::user()->role == 'user') {
            if($status == 'started'){
                $task->status = 2;
                $task->started_at = date('Y-m-d H:i:s');
            }
            if($status == 'submitted'){
                $task->status = 3;
                $task->submitted_at = date('Y-m-d H:i:s');
            }
        }
        
        $task->update();

        return redirect()->route('tasks')->with('status', 'Status Updated');

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
        $task = new Task();

        $task->title = $request->title;
        $task->description = $request->description;
        $task->employee_id = $request->employee_id;
        $task->due_date = $request->due_date;
        $task->uploaded_file = $request->uploaded_file;
        $task->uploaded_at = $request->uploaded_at;
        $task->submitted_at = $request->submitted_at;
        
        $task->save();

        return redirect()->route('tasks')->with('status', 'Task Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $task->title = $request->title;
        $task->description = $request->description;
        $task->due_date = $request->due_date;
        
        $task->update();

        return redirect()->route('tasks')->with('status', 'Task Updated');

    }

    public function uploadFile(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        if ($files = $request->file('uploaded_file')) {
            $destinationPath = 'media/'; // upload path
            $uploaded = $files->getClientOriginalName();
            $files->move($destinationPath, $uploaded);
         }
         $task->uploaded_file = $uploaded;
         $task->uploaded_at = date('Y-m-d H:i:s');
         $task->update();

         return redirect()->route('tasks')->with('status', 'File Uploaded');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::findOrFail($id)->delete();

        return redirect()->route('tasks')->with('status', 'Task Deleted');
    }
}
