@extends('admin.layout.app')

@section('content')
{{-- <div class="row">
  <div class="">
      <div class="bg-warning">
          <div class="inner">
              <h3>
                  User Details
              </h3>

              <p>{{ $para }}</p>
</div>

</div>
</div>
</div> --}}
{{-- {{ dd($user) }} --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="m-t-0 header-title font-weight-bold text-center">User Details</h4>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped">
                    @foreach ($user as $key => $emp)
                   
                        @if ($key =='password' || $key =='created_at' || $key =='updated_at' || $key =='company_id')
                            @continue
                        @endif
                        <tr>
                            <th>{{ $key }}</th>
                            <td>{{ $emp }}</td>
                        </tr>
                    @endforeach
                    
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
</div>
</div>
@endsection
