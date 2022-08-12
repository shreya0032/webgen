@extends('admin.layout.app')
@section('content')


<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-header">

                <h4 class="m-t-0 header-title font-weight-bold text-center">Employee List</h4>
            </div>
            <div class="card-body">

                @if(auth()->user()->can('Add'))
                <div class="pull-right">
                    <a class="btn btn-dark" href="{{ route('employee.create') }}"><i
                            class="ion-plus-circled"></i> Create New Employee </a>
                </div>
                @endif
                @if(auth()->user()->can('Details'))
                <div class="mt-4">
                    <table id="employeelist"
                        class="table tableStyle table-bordered table-bordered dt-responsive nowrap" cellspacing="0"
                        width="100%">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="all_checkboxUser"></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Company</th>
                                <th>Action 
                                    @if(auth()->user()->can('Delete'))
                                   <button class="btn btn-sm btn-danger d-none" id="deleteAllUser" data-url="{{ route('employee.delete.selected') }}">Delete All</button>
                                   @endif
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>
                </div>
                @endif
            </div>

            <!-- /.card-body -->
        </div>

    </div>
    <!-- /.col -->
</div>


@endsection
