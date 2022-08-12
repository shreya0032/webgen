<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class EmployeeController extends Controller
{
    
    public function index()
    {
        return view('admin.employee.index');
    }

    
    public function getEmployeeList()
    {

        $userList = DB::table('employee')
        ->join('company', 'company.id', '=', 'employee.company_id')
        ->select('company.name as company_name','employee.*')
        ->get();

        return DataTables::of($userList)
            ->addColumn('action', function ($data) {
                $user = auth()->user();
                $dataArray = [
                    'id' => encrypt($data->id),
                ];

                $btn = '';
                if($user->hasAnyPermission(['Edit'])){
                $btn = '<a href=" ' . route('employee.edit') . '/' . $dataArray['id'] . ' " class="edit btn btn-primary btn-sm mr-3">Edit</a>';               
                }
                if($user->hasAnyPermission(['Delete'])){
                $btn .= '<a href="JavaScript:void(0);" data-action="' . route('employee.delete') . '/' . $dataArray['id'] . '" data-type="delete" class="delete btn btn-danger btn-sm mr-3 deleteuser" title="Delete">Delete</a>';
                }
                return $btn;
            })
            ->addColumn('checkbox', function($data){
                return '<input type="checkbox" name="single_checkboxUser" data-id="'.$data->id.'" />';
                 
            })
            ->rawColumns(['action', 'checkbox'])
            ->make(true);
    }

    public function create()
    {
        $roles = Role::whereNotIn('name', ['super admin'])->get();
        $company = Company::all();
        return view('admin.employee.create', compact('roles', 'company'));
    }

    public function store(Request $request)
    {
        
        $values = $request->all();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:100|regex:/[a-zA-Z0-9\s]+/',
            'email' => 'required|email:rfc,dns|max:100|unique:employee',
            'password' => 'required|min:8',
            'confirmPassword' => 'required|same:password|min:8',
            'company' => 'required',
            'roles' => 'required',
            'phone' => 'required|numeric|'
        ], [
            'confirmPassword.same' => "The confirm password and password doesn't match.",
            "company.required" => 'Please select a company.',
            "roles.required" => 'Please assign a role.'
            // 'phone.required' => 'The phone number is required',
            // 'phone.numeric' => 'Please enter digit.',
            // 'phone.size' => 'The phone number is required',

        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $employee = new Employee;
            $employee->company_id = $values['company'];
            $employee->name = $values['name'];
            $employee->email = $values['email'];
            $employee->password = Hash::make($values['password']);
            $employee->phone = $values['phone'];

            if ($employee->save()) {
                $employee->assignRole($request->roles);
                return response()->json(['status' => 1, 'msg' => 'New Employee added successfully']);
            } else {
                return response()->json(['status' => 0, 'error' => 'Problem occured']);;
            }
        }
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $roles = Role::all();
        $company = Company::all();
        // $permissions = DB::table('permissions')->whereNotIn('name', ['add', 'edit', 'delete', 'details'])->select('id', 'name')->get();        
        // $user = Employee::where('id', $id)->first();

        $user = DB::table('employee')
        ->join('company', 'company.id', '=', 'employee.company_id')
        ->select('company.name as company_name','employee.*')
        ->where('employee.id', $id)
        ->first();
        // dd($user);
        return view('admin.employee.edit', compact('user', 'roles', 'company'));
    }


    public function update(Request $request)
    {
        $roleName = '';
        $values = $request->except('_token','roles');
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:100|regex:/[a-zA-Z0-9\s]+/',
            'email' => 'required|email:rfc,dns|max:100|',
            'phone' => 'required|numeric|'
        ], [
            'confirmPassword.same' => "The confirm password and password doesn't match.",
            "company.required" => 'Please assign a company.',
            "roles.required" => 'Please assign a role.'

        ]);

        if($validator->fails()){
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }else{
            $user = Employee::where('id', $request->id)->first();
            foreach ($user->roles as $user_role) {
                $roleName = $user_role->name;
            }
            

            if($user->hasAnyRole($roleName)){
                
                if ($request->roles != null ){
                    if ($roleName != $request->roles) {
                        $user->removeRole($roleName);
                        $user->assignRole($request->roles);
                        Employee::where('id', $request->id)->update($values);
                        return response()->json(['status' => 1, 'msg' => 'User updated successfully']);
                    
                    }else {
                        Employee::where('id', $request->id)->update($values);
                        return response()->json(['status' => 1, 'msg' => 'User updated successfully']);
                    }
                }else {
                    
                    Employee::where('id', $request->id)->update($values);
                    return response()->json(['status' => 1, 'msg' => 'User updated successfully']);
                }
            }
            else {
                if($request->roles != null ){
                    $user->assignRole($request->roles);
                    return response()->json(['status' => 1, 'msg' => 'Role updated']);
                }else{
                    return response()->json(['status' => 1, 'msg' => 'Role cannot be null']);
                }
                
            }

        }
    }


    public function delete($id)
    { 
        $id = decrypt($id); 
        $user = Employee::find($id)->delete();
        if ($user){
            return response()->json(['status'=>1, 'type' => "success", 'title' => "Delete", 'msg'=>'User delete successsfully']);
        }else{
            return response()->json(['status'=>0, 'msg'=>'User not deleted']);
        }
    }
    public function deleteEmployeeSelected(Request $request)
    {
        $checked_users_id=$request->checked_user;
        $checkedDeleted = Employee::whereIn('id', $checked_users_id)->delete();
        if($checkedDeleted){
            return response()->json(['status'=>1, 'msg'=>'Employees delete successfully']);
        }
        else{
            return response()->json(['status'=>0, 'msg'=>'Employees not deleted']);
            
        }

    } 


    public function userProfile(Request $request)
    {
        
        $values = $request->only('user_name', 'user_email');
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|min:2|max:100|regex:/[a-zA-Z0-9\s]+/',
            'user_email' => 'required|email:rfc,dns',
        ]);
        if($validator->fails()){
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }
        else{
            User::where('id', $request->profile_id)->update(['name' => $values['user_name'], 'email' => $values['user_email']]);
            return response()->json(['status' => 1, 'msg' => 'User Profile updated successfully']);                
        }
        
        
    }

    public function userAvatar(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|mimes:jpg,jpeg,png'
        ],[
            'avatar.required' => 'Please choose a file',
        ]);
            
        if(!$validator->fails())
        {
            $image = $request->file('avatar');
            $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/backend/dist/img/upload/'),$filename);
            if($user->avatar != "default_avatar.jpg"){
                unlink(public_path('assets/backend/dist/img/upload/' . $user->avatar));
                User::where('id', $request->id)->update(['avatar' => $filename]);
            }else{
                User::where('id', $request->id)->update(['avatar' => $filename]);
            }
            return response()->json(['status' => 1, 'msg' => 'User Profile Avatar updated successfully']);
        }else{
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }
    }

    public function getuserProfile($id)
    { 
        $user = User::where('id', $id)->first();
        return response()->json(['status' =>1, 'user' => $user]);
        // $username = $user->name;
        // $useremail = $user->email;
    }

}
