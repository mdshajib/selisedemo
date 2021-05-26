<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Resources\Employee as EmployeeResource;
use App\Http\Controllers\BaseController as BaseController;
use Exception;
use Validator;
use Input;

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
        try{
            $validator = Validator::make($request->all(), [
                'name'        => 'required',
                'email'       => 'required|email',
                'phone'       => 'required',
                'address'     => 'required',
                'photo'       => 'required',
                'designation' => 'required'
            ]);
            if($validator->fails()){
                throw new Exception($validator->errors());
            }
            $employeeData['name']        = $request->input('name');
            $employeeData['email']       = $request->input('email');
            $employeeData['phone']       = $request->input('phone');
            $employeeData['address']     = $request->input('address');
            $employeeData['photo']       = $request->input('photo');
            $employeeData['designation'] = $request->input('designation');

            $employee = Employee::create($employeeData);
            if(! $employee){
                throw new Exception('Employee data not inserted!!');
            }
            $employee->photo = asset('images/'.$employee->photo);
            return $this->sendResponse(new EmployeeResource($employee),'insert success');
        }
        catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
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
        try{
            $validator = Validator::make($request->all(), [
                'name'        => 'required',
                'email'       => 'required|email',
                'phone'       => 'required',
                'address'     => 'required',
                'designation' => 'required'
            ]);
            if($validator->fails()){
                throw new Exception($validator->errors());
            }
            $employee = Employee::find($id);
            if(! $employee){
                throw new Exception("Employe data not found");
            }
            $employee->name        = $request->input('name');
            $employee->email       = $request->input('email');
            $employee->phone       = $request->input('phone');
            $employee->address     = $request->input('address');
            $employee->designation = $request->input('designation');
            $employee->save();
            return $this->sendResponse(new EmployeeResource($employee),'Employee Updated!!!');
        }
        catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
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
            return $this->sendResponse('', 'Employee deleted successfully.');
        }
        catch(Exception $e){
            return $this->sendError($e->getMessage());
        }  
    }
}
