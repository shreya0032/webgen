<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class CompanyController extends Controller
{
    public function index()
    {
        return view('admin.company.index');
    }

    public function getCompanyList()
    {
        
        $companyList = Company::orderBy('id', 'asc')->get();
        return DataTables::of($companyList)
            ->addColumn('action', function ($data) {
                $user = auth()->user();
                $dataArray = [
                    'id' => encrypt($data->id),
                ];
                $btn = '';
                if($user->hasAnyPermission(['Edit'])){
                    $btn = '<a href=" ' . route('company.edit') . '/' . $dataArray['id'] . ' " class="edit btn btn-primary btn-sm mr-3">Edit</a>';
                }
                
                if($user->hasAnyPermission(['Delete'])){
                    $btn .= '<a href="JavaScript:void(0);" data-action="' . route('company.delete') . '/' . $dataArray['id'] . '" data-type="delete" class="delete btn btn-danger btn-sm mr-3 deletecompany" title="Delete">Delete</a>';
                }
                
                return $btn;
            })
            ->addColumn('logo', function($data){
                $url = asset('assets/backend/dist/img/company/'.$data->logo);
                return $url;
            })
            ->addColumn('checkbox', function ($data) {
                return '<input type="checkbox" name="single_checkboxUser" data-id="' . $data->id . '" />';
            })
            ->rawColumns(['action', 'imlogoage'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.company.create');
    }

    public function store(Request $request)
    {
        $values = $request->all();
        // dd($values);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:100|regex:/[a-zA-Z0-9\s]+/',
            'email' => 'nullable|email:rfc,dns|max:100|unique:company',
            'logo' => 'mimes:jpg,jpeg,png|dimensions:min_width=100,min_height=100',
            'website' => 'nullable|unique:company'
        ]);

        if (!$validator->fails()) {
            $company = new Company;

            if ($request->hasFile('logo')) {
                $image = $request->file('logo');
                $filename = $image->getClientOriginalExtension();
                // dd($filename);
                // $storagePath = Storage::disk('public')->put('company/',$image.$filename);
                // Storage::disk('local')->getDefaultDriver();
                // $path = Storage::disk('public')->put('company/',$image->getClientOriginalExtension(),$image->get());
                $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/backend/dist/img/company/'), $filename);
                $company->logo = $filename;
            } else {
                $company->logo = 'default_avatar.jpg';
            }

            $company->name = $values['name'];
            $company->email = $values['email'];
            $company->website = $values['website'];
            $company->save();
            return response()->json(['status' => 1, 'msg' => 'New Company is added successfully']);
        } else {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $company = Company::where('id', $id)->first();
        return view('admin.company.edit', compact('company'));
    }


    public function update(Request $request)
    {

        $values = $request->only('name', 'email', 'website');
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:100|regex:/[a-zA-Z0-9\s]+/',
            'email' => 'nullable|email:rfc,dns|max:100',
            'logo' => 'mimes:jpg,jpeg,png|dimensions:min_width=100,min_height=100',
            'website' => 'nullable|unique:company'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            // dd('ok');
            $company = Company::where('id', $request->id)->first();
            // Company::where('id', $request->id)->update($values);
            // if ($request->hasFile('logo')) {
            //     dd('ok');
            // }else{
            //     dd('nok');
            // }

            // return true;
            if ($request->hasFile('logo')) {
                $image = $request->file('logo');
                $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/backend/dist/img/upload/'), $filename);
                if ($company->logo != "default_avatar.jpg") {
                    unlink(public_path('assets/backend/dist/img/upload/' . $company->logo));
                    Company::where('id', $request->id)->update(['logo' => $filename]);
                }else{
                    Company::where('id', $request->id)->update(['logo' => $filename]);
                } 
            }
            Company::where('id', $request->id)->update($values);
            return response()->json(['status' => 1, 'msg' => 'Company updated successfully']);


           

        }
    }


    public function delete($id){

        $id = decrypt($id); 
        $company = Company::find($id)->delete();
        if ($company){
            return response()->json(['status'=>1, 'type' => "success", 'title' => "Delete", 'msg'=>'Company delete successsfully']);
        }else{
            return response()->json(['status'=>0, 'msg'=>'Company not deleted']);
        }
    }
}
