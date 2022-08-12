@extends('admin.layout.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="pull-left">
                    <h4 class="m-t-0 header-title font-weight-bold text-center">Create New Company</h4>
                </div>

                <div class="pull-right">
                    <a class="btn btn-dark" href="{{ route('company.index') }}">Back</a>
                </div>
                
            </div>

            <div class="card-body">

                <form action="{{ route('company.store') }}" method="POST" id="storeCompanyForm" data-redirecturl="{{ route('company.index')}}" enctype="multipart/form-data">
                    @csrf
                    {{-- <div class="row"> --}}
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
            
                        <div class="form-group col-md-12">
                            <label for="exampleInputFile">Logo</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile" name="logo">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                              </div>
                            </div>

                            <span class="text-danger error-text logo_error"></span>
                        </div>
            
                        <div class="form-group col-md-12" >
                            <label for="website">Website</label>
                            <input type="text" name="website" id="website" placeholder="Website" class="form-control" value="">
                            <span class="text-danger error-text website_error"></span>
                        </div>

                        <div class="form-group col-md-12">
                            <button type="submit" id="submitCompanyForm" class="btn btn-primary">Submit</button>                            
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
