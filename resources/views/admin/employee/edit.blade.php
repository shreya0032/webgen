@extends('admin.layout.app')
@section('content')
{{-- {{ dd($user->getRoles()) }} --}}

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="m-t-0 header-title font-weight-bold text-center">Update Employee </h4>
                <a class= 'btn btn-dark' href="{{ route('employee.index') }}" role="button">Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('employee.update') }}" method="POST" id="updateEmployeeForm" data-redirecturl="{{ route('employee.index')}}">
                   
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control" name="name" value="{{ $user->name }}">
                        <span class="text-danger error-text name_error"></span>

                    </div>


                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" class="form-control" name="email" value="{{ $user->email }}">
                        <span class="text-danger error-text email_error"></span>
                    </div>

                    <div class="form-group col-md-12" >
                        <label for="phone">Phone No</label>
                        <input type="text" name="phone" id="phone" placeholder="Phone Number" class="form-control" value="{{ $user->phone }}">
                        <span class="text-danger error-text phone_error"></span>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="company">Company</label>
                        <select class="custom-select rounded-0" id="company" name="company_id">
                            <option value=" ">Select Company</option>
                            @foreach($company as $com)
                                <option
                                @if (isset($user->company_name))
                                @if($user->company_name == $com->name)
                                    selected style="background-color: #007bff"
                                @endif value="{{ $com->id }}">{{ $com->name }}</option>
                                    
                                @endif
                            @endforeach
                        </select>
                        <span class="text-danger error-text company_error"></span>
                    </div> 

                    {{-- <div class="form-group">
                        <label for="roles">Role Assign</label>
                        <select id="roles" name="roles" autocomplete="roles-name"
                            class="form-select">
                            <option value="">Choose a role</option>
                            @foreach($roles as $role)
                                @if ($role->name != "super admin")
                                    <option 
                                    @if( isset($user->roles[0]))
                                        @if($user->roles[0]->id == $role->id)
                                        selected style="background-color: #007bff"
                                        @endif
                                    @endif
                                    value="{{ $role->name }}"                                     
                                    >{{ $role->name }}</option>
                                @endif
                                
                            @endforeach
                        </select><br> 
                        <span class="text-danger error-text roles_error"></span>
                    </div> --}}

                   
                    <div class="form-group col-md-12">
                        <label for="roles">Role</label>
                        <select id="roles" name="roles" autocomplete="roles-name"
                            class="custom-select rounded-0">
                            <option value="">Choose a role</option>
                            @foreach($roles as $role)
                                @if ($role->name != "super admin")
                                    <option 
                                    @if( isset($user->roles[0]))
                                        @if($user->roles[0]->id == $role->id)
                                        selected style="background-color: #007bff"
                                        @endif
                                    @endif
                                    value="{{ $role->name }}"                                     
                                    >{{ $role->name }}</option>
                                @endif
                                
                            @endforeach
                        </select>
                        <span class="text-danger error-text roles_error"></span>
                    </div>

                    <div class="form-group">
                        <button type="submit" id="UpdateEmployeeForm" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>

            <!-- /.card-body -->
        </div>

    </div>
    <!-- /.col -->
</div>

@endsection


