@extends('layouts.app')

@section('title', 'Check Out')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h4>Check Out</h4>
            <form id="checkout-form">
                <div class="mb-3">
                    <label for="employee_id" class="form-label">Employee</label>
                    <select class="form-select" id="employee_id" required>
                        <option value="">Select employee</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Reason (if early leave)</label>
                    <textarea id="description" class="form-control" rows="3" placeholder="Optional unless required"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Check Out</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const EMPLOYEES_API = 'http://localhost:3000/api/employees';
        const ATTENDANCE_API = 'http://localhost:3000/api/attendances';

        $(document).ready(function() {
            $.get(EMPLOYEES_API, function(res) {
                res.data.forEach(emp => {
                    $('#employee_id').append(
                        `<option value="${emp.id}">${emp.name} (${emp.department.department_name})</option>`
                    );
                });
            });

            $('#checkout-form').on('submit', function(e) {
                e.preventDefault();

                const employeeId = $('#employee_id').val();
                const description = $('#description').val();

                $.ajax({
                    url: `${ATTENDANCE_API}/${employeeId}`,
                    type: 'PUT',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        description
                    }),
                    success: function(res) {
                        alert(res.message);
                        $('#checkout-form')[0].reset();
                    },
                    error: function(xhr) {
                        const msg = xhr.responseJSON?.message || 'An error occurred';
                        alert('Error: ' + msg);
                    }
                });
            });
        });
    </script>
@endpush
