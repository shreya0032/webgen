@extends('admin.layout.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="pull-left">
                    <h4 class="m-t-0 header-title font-weight-bold text-center">Create New Employee</h4>
                </div>

                <div class="pull-right">
                    <a class="btn btn-dark" href="{{ route('employee.index') }}"> Back</a>
                </div>
                
            </div>

            <div class="card-body">

                <form action="{{ route('employee.store') }}" method="POST" id="createEmployeeForm" data-redirecturl="{{ route('employee.index')}}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" placeholder="Name" class="form-control" value="">
                            <span class="text-danger error-text name_error"></span>
                        </div>
            
                        <div class="form-group col-md-12" >
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" placeholder="Email" class="form-control" value="">
                            <span class="text-danger error-text email_error"></span>
                        </div>
            
                        <div class="form-group col-md-12" >
                            <label for="phone">Pnone No</label>
                            <input type="text" name="phone" id="phone" placeholder="Phone Number" class="form-control" value="">
                            <span class="text-danger error-text phone_error"></span>
                        </div>
            
                        <div class="form-group col-md-6">
                            <label for="password">Password</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span toggle="#password" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                                    </div>
                                </div>
                                <input type="password" name="password" id="password" placeholder="Password" class="form-control" value="">
                            </div>
                            
                            <span class="text-danger error-text password_error"></span>
                        </div>
            
                        <div class="form-group col-md-6">
                            <label for="confirmPassword">Confirm Password</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span toggle="#confirmPassword" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                                    </div>
                                </div>
                                <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" class="form-control" value="">
                            </div>
                            
                            <span class="text-danger error-text confirmPassword_error"></span>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="company">Company</label>
                            <select class="custom-select rounded-0" id="company" name="company">
                                <option value=" ">Select Company</option>
                                @foreach($company as $com)
                                    <option value="{{ $com->id }}">{{ $com->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text company_error"></span>
                        </div>  

                        <div class="form-group col-md-12">
                            <label for="roles">Role</label>
                            <select class="custom-select rounded-0" id="roles" name="roles">
                                <option value=" ">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text roles_error"></span>
                        </div>        

                        <div class="form-group col-md-12">
                            <button type="submit" id="submitEmployeeForm" class="btn btn-primary">Submit</button>                            
                        </div>
                </form>
            </div>
        </div>

        
    </div>
</div>



@if(Session::get('error'))
<span style="color:red">{{Session::get('error')}}</span>
@endif


@endsection
