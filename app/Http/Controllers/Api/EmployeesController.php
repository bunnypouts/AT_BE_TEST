<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employees;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $employees = Employees::all();
            $msg = "Employees data not available";
            
            if(count($employees)>0){
                $msg = "Employees data";
            }

            return response()->json([
                    'status'=>true,
                    'message'=>$msg,
                    'data' => [
                            'total' => count($employees),
                            'employees' => $employees
                        ]
                    ],200);

        }catch(\Exception|\Throwable $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try{

            $validated = $request->validate([
                'name' => ['required','max:50'],
                'email' => ['required','unique:employees','regex:/^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/','max:150'],
                'department' => ['required']
            ],[
                'name.required' => 'Enter Employee name correctly',
                'email.unique' => 'Employee email already exists',
                'email.regex' => 'Employee email invalid',
            ]);

            $employee = Employees::create($request->all());

            return response()->json([
                'success' => true,
                'message' => "Employee Created successfully!",
                'post' => $employee
            ], 200);
            
        }catch(\Exception|\Throwable $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],isset($e->status) ?$e->status : 500);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employees $employees,$id)
    {
        try{

            $data = $employees->find($id);

            if(!isset($data->id)){
                throw new \Exception("Employee not found for update",404);
            }

            $validated = $request->validate([
                'name' => ['max:50'],
                'email' => ['unique:employees','regex:/^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/','max:150'],
                'department' => ['max:7']
            ],[
                'name.required' => 'Enter Employee name correctly',
                'email.unique' => 'Employee email already exists',
                'email.regex' => 'Employee email invalid',
            ]);
            
            $data->update($request->all());

            return response()->json([
                'success' => true,
                'message' => "Employee Updated successfully!",
                'post' => $data
            ], 200);

        }catch(\Exception|\Throwable $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],isset($e->status) ? $e->status : ($e->getCode()?  $e->getCode() : 500));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employees $employees,$id)
    {
         
        try{

            $data = $employees->find($id);

            if(!isset($data->id)){
                throw new \Exception("Employee not found for delete",404);
            }

            $data->delete();

            return response()->json([
                'success' => true,
                'message' => "Employee Deleted successfully!",
            ], 200);

        }catch(\Exception|\Throwable $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],isset($e->status) ?$e->status : ($e->getCode()?  $e->getCode() : 500));
        }
    }
}
