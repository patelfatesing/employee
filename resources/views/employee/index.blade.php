@extends('layouts.layout')

@section('title')
    Dashboard
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="pagetitle">

        <a class="r_btn" href="{{ url('employees/create') }}">Create Employee</a>
    </div><!-- End Page Title -->
    <div class="pagetitle">
        <h1>Employees List</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('employees') }}">Home</a></li>
                <li class="breadcrumb-item active">Employees List</li>
            </ol>

        </nav>

    </div><!-- End Page Title -->



    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Employees List</h5>


                        <!-- Table with stripped rows -->
                        <table class="table datatable" id="emp_table">
                            <thead>
                                <tr>
                                    <th>
                                        <b>F</b>irst Name
                                    </th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th data-type="date" data-format="YYYY/DD/MM">Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('#emp_table').DataTable({
                pagelength: 10,
                responsive: true,
                processing: true,
                ordering: true,
                bLengthChange: true,
                serverSide: true,

                "ajax": {
                    "url": '{{ url('employees/get-data') }}',
                    "type": "post",
                    "data": function(d) {},
                },
                aoColumns: [

                    {
                        data: 'first_name'
                    },
                    {
                        data: 'last_name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'phone_number'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'action'
                    }
                    // Define more columns as per your table structure

                ],
                aoColumnDefs: [{
                    bSortable: false,
                    aTargets: []
                }],
                dom: "Bfrtip",
                lengthMenu: [
                    [10, 25, 50],
                    ['10 rows', '25 rows', '50 rows', 'All']
                ],
                buttons: ['pageLength']

            });

        });

        function delect_emp(id) {
            swal("Are You want To Delete", {
                dangerMode: true,
                buttons: true,
            }).then((willDelete) => {
                if (willDelete == true) {

                    $.ajax({
                        method: "POST",
                        url: "{{ 'employees/delete' }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            id: id
                        },
                        success: function(data) {
                            swal("Deleted!", "Your employee has been deleted.", "success");
                            location.reload();
                        }
                    })

                }
            })
        }
    </script>
@endsection
