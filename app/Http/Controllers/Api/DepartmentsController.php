<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Departments;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $departments = Departments::all();
            $msg = "Departments data not available";
            
            if(count($departments)>0){
                $msg = "Departments data";
            }

            return response()->json([
                    'status'=>true,
                    'message'=>$msg,
                    'data' => [
                            'total' => count($departments),
                            'departments' => $departments
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
                'name' => ['required','unique:departments','max:20']
            ],[
                'name.required' => 'Enter Department name correctly',
                'name.unique' => 'Department name already exists',
            ]);

            $department = Departments::create($request->all());

            return response()->json([
                'success' => true,
                'message' => "Department Created successfully!",
                'post' => $department
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
     * @param  \App\Models\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Departments $departments,$id)
    {
        try{

            $data = $departments->find($id);

            if(!isset($data->id)){
                throw new \Exception("Department not found for update",404);
            }

            $validated = $request->validate([
                'name' => ['required','unique:departments','max:20']
            ],[
                'name.required' => 'Enter Department name correctly',
                'name.unique' => 'Department name already exists',
            ]);
            
            $data->update($request->all());

            return response()->json([
                'success' => true,
                'message' => "Department Updated successfully!",
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
     * @param  \App\Models\Departments  $departments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departments $departments,$id)
    {   
        
        try{

            $data = $departments->find($id);

            if(!isset($data->id)){
                throw new \Exception("Department not found for delete",404);
            }

            $data->delete();

            return response()->json([
                'success' => true,
                'message' => "Department Deleted successfully!",
            ], 200);

        }catch(\Exception|\Throwable $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],isset($e->status) ?$e->status : ($e->getCode()?  $e->getCode() : 500));
        }
    }
}
