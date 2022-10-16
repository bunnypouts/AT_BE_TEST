<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmployeesAddresses;
use Illuminate\Http\Request;

class EmployeesAddressesController extends Controller
{


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
                'address' => ['required','max:500'],
                'employee' => ['required']
            ],[
                'name.required' => 'Enter Employee Address correctly',
                'employee.required' => 'Select Employee ID correctly',
            ]);

            $employee = EmployeesAddresses::create($request->all());

            return response()->json([
                'success' => true,
                'message' => "Employee Address Created successfully!",
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
     * @param  \App\Models\EmployeesAddresses  $employeesAddresses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeesAddresses $employeesAddresses,$id)
    {
        
        try{

            $data = $employeesAddresses->find($id);

            if(!isset($data->id)){
                throw new \Exception("Employee Address not found for update",404);
            }

            $validated = $request->validate([
                'address' => ['required','max:500']
            ],[
                'address.required' => 'Enter Employee address correctly',
            ]);
            
            $data->update($request->all());

            return response()->json([
                'success' => true,
                'message' => "Employee Address Updated successfully!",
                'post' => $data
            ], 200);

        }catch(\Exception|\Throwable $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],isset($e->status) ?$e->status : ($e->getCode()?  $e->getCode() : 500));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmployeesAddresses  $employeesAddresses
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeesAddresses $employeesAddresses,$id)
    {
        
        try{

            $data = $employeesAddresses->find($id);

            if(!isset($data->id)){
                throw new \Exception("Employee Address not found for delete",404);
            }

            $data->delete();

            return response()->json([
                'success' => true,
                'message' => "Employee Address deleted successfully!",
                'post' => $data
            ], 200);

        }catch(\Exception|\Throwable $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],isset($e->status) ?$e->status : ($e->getCode()?  $e->getCode() : 500));
        }
    }
}
