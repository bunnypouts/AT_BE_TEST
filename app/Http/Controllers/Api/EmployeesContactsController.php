<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmployeesContacts;
use Illuminate\Http\Request;

class EmployeesContactsController extends Controller
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
                'contact' => ['required','regex:/[0-9]{10}/','max:500'],
                'employee' => ['required']
            ],[
                'name.required' => 'Enter Employee Contact correctly',
                'employee.required' => 'Select Employee ID correctly',
                'contact.regex' => 'Enter Valid Employee Contact number',
            ]);

            $employee = EmployeesContacts::create($request->all());

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
     * @param  \App\Models\EmployeesContacts  $employeesContacts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeesContacts $employeesContacts, $id)
    {
        
        try{

            $data = $employeesContacts->find($id);

            if(!isset($data->id)){
                throw new \Exception("Employee Contact not found for update",404);
            }

            $validated = $request->validate([
                'contact' => ['required','regex:/[0-9]{10}/','max:10']
            ],[
                'contact.required' => 'Enter Employee Contact correctly',
                'contact.regex' => 'Enter Valid Employee Contact number',
            ]);
            
            $data->update($request->all());

            return response()->json([
                'success' => true,
                'message' => "Employee Contact Updated successfully!",
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
     * @param  \App\Models\EmployeesContacts  $employeesContacts
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeesContacts $employeesContacts, $id)
    {
        
        try{

            $data = $employeesContacts->find($id);

            if(!isset($data->id)){
                throw new \Exception("Employee Contact not found for delete",404);
            }

            $data->delete();

            return response()->json([
                'success' => true,
                'message' => "Employee Contact deleted successfully!",
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
