@extends('admin.layout.app')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="m-t-0 header-title font-weight-bold text-center">Update Company </h4>
                <a class= 'btn btn-dark' href="{{ route('company.index') }}" role="button">Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('company.update') }}" method="POST" id="updateCompanyForm" data-redirecturl="{{ route('company.index')}}">
                   
                    @csrf
                    <input type="hidden" name="id" value="{{ $company->id }}">
                    
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control" name="name" value="{{ $company->name }}">
                        <span class="text-danger error-text name_error"></span>
                    </div>


                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" class="form-control" name="email" value="{{ $company->email }}">
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

                    <div class="form-group">
                        <label for="website">Website</label>
                        <input type="text" id="website" class="form-control" name="website" value="{{ $company->website }}">
                        <span class="text-danger error-text website_error"></span>
                    </div>

                    <div class="form-group">
                        <button type="submit" id="submitCompanyUpdateForm" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>

            <!-- /.card-body -->
        </div>

    </div>
    <!-- /.col -->
</div>

@endsection


