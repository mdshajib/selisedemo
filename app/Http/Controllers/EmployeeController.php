<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Resources\Employee as EmployeeResource;
use App\Http\Controllers\BaseController as BaseController;
use Exception;
use Validator;

class EmployeeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $all_employee = Employee::all();
            if(! count($all_employee) > 0){
                throw new Exception("No employee found");
            }
            return $this->sendResponse(EmployeeResource::collection($all_employee),'all employees');
        }
        catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 'create employee';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return 'Store employee in list';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $employee = Employee::find($id);
            // return response()->json($employee);
            // exit;
            if(! $employee){
                throw new Exception("Employee data not found!");
            }
            if($employee->photo ==''){
                $employee->photo = 'default.jpg';
            }
            // $employee->photo = secure_asset('images/'.$employee->photo);
            $employee->photo = asset('images/'.$employee->photo);
            return $this->sendResponse(new EmployeeResource($employee),'single employee');
        }
        catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return 'edit employee';
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
        return 'update employee data';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $employee = Employee::find($id);
            if(is_null($employee)){
                throw new Exception("Employee delete failed");
            }
            $employee->delete();
            return $this->sendResponse($employee, 'Employee deleted successfully.');
        }
        catch(Exception $e){
            return $this->sendError($e->getMessage());
        }  
    }
}
