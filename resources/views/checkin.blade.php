@extends('layouts.app')

@section('title', 'Check In')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h4>Check In</h4>
            <form id="checkin-form">
                <div class="mb-3">
                    <label for="employee_id" class="form-label">Employee</label>
                    <select class="form-select" id="employee_id" required>
                        <option value="">Select employee</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description (if late)</label>
                    <textarea class="form-control" id="description" rows="3" placeholder="Optional if not late..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Check In</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const EMPLOYEES_API = "http://localhost:3000/api/employees";
        const ATTENDANCE_API = "http://localhost:3000/api/attendances";

        $(document).ready(function() {
            $.get(EMPLOYEES_API, function(res) {
                res.data.forEach(emp => {
                    $('#employee_id').append(
                        `<option value="${emp.id}">${emp.name} - ${emp.department.department_name}</option>`
                    );
                });
            });

            $('#checkin-form').on('submit', function(e) {
                e.preventDefault();

                const payload = {
                    employee_id: $('#employee_id').val(),
                    description: $('#description').val()
                };

                $.ajax({
                    url: ATTENDANCE_API,
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(payload),
                    success: function(res) {
                        alert(res.message);
                        $('#checkin-form')[0].reset();
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON?.message || 'Something went wrong');
                    }
                });
            });
        });
    </script>
@endpush
