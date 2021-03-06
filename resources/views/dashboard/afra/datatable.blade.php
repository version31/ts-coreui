@extends('dashboard.base')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>{{ __('Users') }}</div>
                        <div class="card-body">
                            <div class="row">
                                @can($crud->permission('delete'))
                                    <a href="{{$crud->route('create')}}" class="btn btn-primary m-2">Add
                                        New</a>
                                @endcan
                            </div>

                            <table class="table table-bordered data-table" id="laravel_datatable">
                                <thead>
                                <tr>
                                    @foreach($crud->columns as $column)
                                        <th>{{$column['name']}}</th>
                                    @endforeach
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#laravel_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{$crud->route('datatable')}}",
                    method: "GET"
                },
                columns: {!! $crud->getDatatableColumns() !!}
            });
        });
    </script>


    <script>
        $('#laravel_datatable').on('click', '.btn-danger[data-remote]', function (e) {
            var choice = confirm('آیا مطمئن هستید؟');
            if (choice !== true) {
                return false;
            }
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');
            // confirm then
            $.ajax({
                url: url,
                type: 'DELETE',
                dataType: 'json',
                data: {method: '_DELETE', submit: true}
            }).always(function (data) {
                $('#laravel_datatable').DataTable().draw(false);
            });
        });
    </script>

@endsection


@section('css')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

