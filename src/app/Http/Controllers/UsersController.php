<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $emps = $user->newQuery();

        $status = request()->get('status');
        $emps->where('role', 'user');
        
        if($status){
            $emps->where('status', $status);
        }

        $employees = $emps->orderBy('id', 'DESC')->paginate(50);

        return view('employees.index', compact('employees', 'status'));

    }

    public function profile($id = null)
    {
        if(!$id){
            $id = Auth::id();
        }
        return view('employees.profile', ['user' => User::findOrFail($id)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'designation' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required',
            'phone' => 'required|unique:users|max:255',
        ]);

        $user = new User();
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->designation = $request->designation;
        $user->status = $request->status;
        $user->role = 'user';
        if ($files = $request->file('photo')) {
            $destinationPath = 'images/employees/'; // upload path
            $photo = $files->getClientOriginalName();
            $files->move($destinationPath, $photo);
         }else{
            $photo = '';
         }
        $user->photo = $photo;
        
        $user->save();
        
        return redirect()->route('employees-list')->with('status', 'Employee Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->designation = $request->designation;
        $user->status = $request->status;
        if ($files = $request->file('photo')) {
            $destinationPath = 'images/employees/'; // upload path
            $photo = $files->getClientOriginalName();
            $files->move($destinationPath, $photo);
         }else{
            $photo = $request->oldPhoto;
         }
        $user->photo = $photo;
        
        $user->update();
        
        return redirect()->back()->with('status', 'Employee Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->back()->with('status', 'Employee Deleted');
    }

    public function setting()
    {
        return view('employees.setting');
    }
}
