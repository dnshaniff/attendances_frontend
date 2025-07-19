@extends('layouts.app')

@section('title', 'Attendances')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h4>Attendances</h4>
    </div>

    <div class="d-flex justify-content-between mb-3">
        <h4>Attendances</h4>
        <div class="d-flex gap-2">
            <select id="filter-department" class="form-select">
                <option value="">All Departments</option>
            </select>
            <input type="date" id="filter-date" class="form-control">
            <button id="btn-filter" class="btn btn-primary">Filter</button>
        </div>
    </div>

    <table id="attendances-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee</th>
                <th>Department</th>
                <th>Clock In</th>
                <th>Clock Out</th>
                <th>Status</th>
            </tr>
        </thead>
    </table>
@endsection

@push('scripts')
    <script>
        const API_URL = "http://localhost:3000/api/attendances";
        const DEPARTMENT_API = "http://localhost:3000/api/departments";

        let table;

        $(document).ready(function() {
            $.get(DEPARTMENT_API, function(res) {
                res.data.forEach(function(dept) {
                    $('#filter-department').append(
                        `<option value="${dept.id}">${dept.department_name}</option>`
                    );
                });
            });

            table = $('#attendances-table').DataTable({
                ajax: {
                    url: API_URL,
                    data: function(d) {
                        d.department_id = $('#filter-department').val();
                        d.date = $('#filter-date').val();
                    },
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'employee.name'
                    },
                    {
                        data: 'employee.department.department_name'
                    },
                    {
                        data: 'clock_in'
                    },
                    {
                        data: 'clock_out'
                    },
                    {
                        data: 'status',
                        render: function(status) {
                            if (!status) return '';

                            const badgeClass = status === 'Late' || status === 'Early Leave' ?
                                'danger' : 'secondary';

                            return `<span class="badge bg-${badgeClass}">${status}</span>`;
                        }
                    }
                ]
            });

            $('#btn-filter').on('click', function() {
                table.ajax.reload();
            });
        });
    </script>
@endpush
