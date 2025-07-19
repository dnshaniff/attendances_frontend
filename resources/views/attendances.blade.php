@extends('layouts.app')

@section('title', 'Attendances')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h4>Attendances</h4>
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

        $(document).ready(function() {
            $('#attendances-table').DataTable({
                ajax: {
                    url: API_URL,
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
        });
    </script>
@endpush
