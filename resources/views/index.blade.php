@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                        <table class="table table-bordered table-striped" id="users-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                     {{-- <div>
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th scope="col">ID</th>
                              <th scope="col">Name</th>
                              <th scope="col">Email</th>
                              <th scope="col">Created</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($users as $user)
                                <tr>
                                  <th scope="row">{{ $user->id }}</th>
                                  <td>{{ $user->name }}</td>
                                  <td>{{ $user->email }}</td>
                                  <td>{{ $user->created_at }}</td>
                                </tr>
                            @endforeach
                          </tbody>
                        </table>
                        <div>
                            {{ $users->links() }}
                        </div>

                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    td.details-control {
        background: url(https://datatables.yajrabox.com/images/details_open.png) no-repeat center center;
    }

    tr.shown td.details-control {
        background: url(https://datatables.yajrabox.com/images/details_close.png) no-repeat center center;
    }
</style>

@push('scripts')

<script id="details-template" type="text/x-handlebars-template">
    <table class="table">
        <tr>
            <td>Full name:</td>
            <td>@{{name}}</td>
        </tr>
        <tr>
            <td>Email:</td>
            <td>@{{email}}</td>
        </tr>
        <tr>
            <td>Extra info:</td>
            <td>And any further details here (images etc)...</td>
        </tr>
    </table>
</script>
<script>
$(function() {
    var template = Handlebars.compile($("#details-template").html());

    var table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('users.data') !!}',
        // order: [[ 2, "desc" ]],
        // "columnDefs": [
        //     { "orderable": false, "targets": [3, 4] },
        //     // { "orderable": true, "targets": [1, 2, 3] }
        // ],
        columns: [
             {
                "className":      'details-control',
                "orderable":      false,
                "searchable":     false,
                "data":           null,
                "defaultContent": ''
            },
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'role', name: 'role' },
            { data: 'email', name: 'email' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' }
        ]
    });

    // Add event listener for opening and closing details
    $('#users-table tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( template(row.data()) ).show();
            tr.addClass('shown');
        }
    });
});
</script>
@endpush
