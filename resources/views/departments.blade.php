@extends('layouts.app')

@section('title', 'Departments')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h4>Departments</h4>
        <button class="btn btn-success" id="btn-add">Add Department</button>
    </div>

    <table id="departments-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Department Name</th>
                <th>Max Clock-In</th>
                <th>Max Clock-Out</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="department-form" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Add Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="department_id">
                    <div class="mb-3">
                        <label for="department_name" class="form-label">Department Name</label>
                        <input type="text" class="form-control" id="department_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="max_clock_in_time" class="form-label">Max Clock-In Time</label>
                        <input type="time" class="form-control" id="max_clock_in_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="max_clock_out_time" class="form-label">Max Clock-Out Time</label>
                        <input type="time" class="form-control" id="max_clock_out_time" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const API_URL = "http://localhost:3000/api/departments";

        let table, modal;

        $(document).ready(function() {
            modal = new bootstrap.Modal(document.getElementById('departmentModal'));

            table = $('#departments-table').DataTable({
                ajax: {
                    url: API_URL,
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'department_name'
                    },
                    {
                        data: 'max_clock_in_time'
                    },
                    {
                        data: 'max_clock_out_time'
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `
                        <button class="btn btn-sm btn-warning btn-edit" data-id="${data.id}">Edit</button>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="${data.id}">Delete</button>
                    `;
                        }
                    }
                ]
            });

            $('#btn-add').on('click', function() {
                $('#modalLabel').text('Add Department');
                $('#department-form')[0].reset();
                $('#department_id').val('');
                modal.show();
            });

            $('#departments-table').on('click', '.btn-edit', function() {
                const id = $(this).data('id');
                $.get(`${API_URL}/${id}`, function(res) {
                    $('#modalLabel').text('Edit Department');
                    $('#department_id').val(res.data.id);
                    $('#department_name').val(res.data.department_name);
                    $('#max_clock_in_time').val(res.data.max_clock_in_time.slice(0, 5));
                    $('#max_clock_out_time').val(res.data.max_clock_out_time.slice(0, 5));
                    modal.show();
                });
            });

            $('#departments-table').on('click', '.btn-delete', function() {
                const id = $(this).data('id');
                if (confirm('Are you sure you want to delete this department?')) {
                    $.ajax({
                        url: `${API_URL}/${id}`,
                        type: 'DELETE',
                        success: function() {
                            table.ajax.reload();
                            alert('Department deleted successfully');
                        }
                    });
                }
            });

            $('#department-form').on('submit', function(e) {
                e.preventDefault();

                const id = $('#department_id').val();
                const payload = {
                    department_name: $('#department_name').val(),
                    max_clock_in_time: $('#max_clock_in_time').val(),
                    max_clock_out_time: $('#max_clock_out_time').val(),
                };

                const method = id ? 'PATCH' : 'POST';
                const url = id ? `${API_URL}/${id}` : API_URL;

                $.ajax({
                    url: url,
                    method: method,
                    contentType: 'application/json',
                    data: JSON.stringify(payload),
                    success: function() {
                        modal.hide();
                        table.ajax.reload();
                        alert(`Department ${id ? 'updated' : 'created'} successfully`);
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>
@endpush
