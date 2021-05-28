<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Resources\Employee as EmployeeResource;
use App\Http\Controllers\BaseController as BaseController;
use Exception;
use Validator;
use Input;
use Intervention\Image\ImageManagerStatic as Image;

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
        try{
            $validator = Validator::make($request->all(), [
                'name'        => 'required',
                'email'       => 'required|email',
                'phone'       => 'required',
                'address'     => 'required',
                'photo'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'designation' => 'required',
                'department'  => 'required',
                'joining_date'=> 'required'
            ]);
            if($validator->fails()){
                throw new Exception($validator->errors());
            }
            $employeeData['name']        = $request->input('name');
            $employeeData['email']       = $request->input('email');
            $employeeData['phone']       = $request->input('phone');
            $employeeData['address']     = $request->input('address');
            $employeeData['designation'] = $request->input('designation');
            $employeeData['department']  = $request->input('department');
            $employeeData['joining_date']= $request->input('joining_date');

            $employee = Employee::where('email',$request->input('email'))
                        ->orWhere('phone',$request->input('phone'))
                        ->first();
            if($employee){
                throw new Exception('Employee already exist with email/phone!!');
            }
            $image       = $request->file('photo');
            $image_name  = time().'.'.$image->extension();
            $destination = public_path('/images');
            Image::make($image)->resize(300, 300)->save($destination.'/'.$image_name);
            $employeeData['photo'] = $image_name;
            $employee = Employee::create($employeeData);
            if(! $employee){
                throw new Exception('Employee data not inserted!!');
            }
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
            if(! $employee){
                throw new Exception("Employee data not found!");
            }
            // $employee->photo = secure_asset('images/'.$employee->photo);
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
        try{
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


    /**
     * Search employee.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchEmployee(Request $request)
    {
        try{
            $keyword = $request->input('keyword');
            $employee = Employee::where('email','like','%'.$keyword.'%')
                        ->orWhere('name','like','%'.$keyword.'%')
                        ->orWhere('phone','like','%'.$keyword.'%')
                        ->orWhere('designation','like','%'.$keyword.'%')
                        ->get();

            if(!count($employee) > 0){
                throw new Exception("No match found!!!");
            }
            return $this->sendResponse(EmployeeResource::collection($employee), 'Match found!!.');
        }
        catch(Exception $e){
            return $this->sendError($e->getMessage());
        }
    }
    
}
