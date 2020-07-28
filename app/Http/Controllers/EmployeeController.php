<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
     public function __construct(){
         $this->middleware('auth');
     }
    public function index()
    {
        $employee= Employee::all();
        return view('employee',compact('employee'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return ("create ");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
         
                    $request->validate([
                    'first_name'=>'required|Max 5',
                    'middle_name'=>'required',
                    'last_name'=>'required',
                    'desiganation'=>'required',
                    'date_of_joining'=>'required:date_format:Y-M-D',

                     ]);
                     $employees =new Employee;
                     $employees->first_name=$request->first_name;
                     $employees->middle_name=$request->middle_name;
                     $employees->last_name=$request->last_name;
                     $employees->desiganation=$request->desiganation;
                     $employees->date_of_joining=$request->date_of_joining;
                     $employees->save();
                     $request->session()->flash('message','Employee Created Successfully');
                     return response()->json(['success'=>true,'result'=>'Employee Create Successfully','Employee'=>$employees]);
    
                

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {

     $request->validate([
            'first_name'=>'required',
            'middle_name'=>'required',
            'last_name'=>'required',
            'desiganation'=>'required',
            'date_of_joining'=>'required:date_format:y-m-d',
             ]);
              $employee->fill($request->except('actionType'));
        $employee->save();
            $request->session()->flash('message','Employee Updated Successfully');
        return response()->json(['success'=>true,'result'=>'Employee update Successfully','Employee'=>$employee]);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Employee $employee)
    {
          
            $employee->delete($employee->id);
            $request->session()->flash('message','Employee Deleted  Successfully');
            return redirect('/employee');
          
    }
}
