@extends('layouts.app')

@section('title', 'Employees')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h4>Employees</h4>
        <button class="btn btn-success" id="btn-add">Add Employee</button>
    </div>

    <table id="employees-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="employee-form" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Add Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="employee_id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="department_id" class="form-label">Department</label>
                        <select class="form-select" id="department_id" required>
                            <option value="">-- Choose Department --</option>
                        </select>
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
        const API_URL = "http://localhost:3000/api/employees";
        const DEPT_API = "http://localhost:3000/api/departments";

        let table, modal;

        $(document).ready(function() {
            modal = new bootstrap.Modal(document.getElementById('employeeModal'));

            table = $('#employees-table').DataTable({
                ajax: {
                    url: API_URL,
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'address'
                    },
                    {
                        data: 'department.department_name'
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

            function loadDepartments(selectedId = null) {
                $.get(DEPT_API, function(res) {
                    const select = $('#department_id');
                    select.empty().append(`<option value="">-- Choose Department --</option>`);
                    res.data.forEach(dept => {
                        const selected = dept.id == selectedId ? 'selected' : '';
                        select.append(
                            `<option value="${dept.id}" ${selected}>${dept.department_name}</option>`
                            );
                    });
                });
            }

            $('#btn-add').on('click', function() {
                $('#modalLabel').text('Add Employee');
                $('#employee-form')[0].reset();
                $('#employee_id').val('');
                loadDepartments();
                modal.show();
            });

            $('#employees-table').on('click', '.btn-edit', function() {
                const id = $(this).data('id');
                $.get(`${API_URL}/${id}`, function(res) {
                    const emp = res.data;
                    $('#modalLabel').text('Edit Employee');
                    $('#employee_id').val(emp.id);
                    $('#name').val(emp.name);
                    $('#address').val(emp.address);
                    loadDepartments(emp.department_id);
                    modal.show();
                });
            });

            $('#employees-table').on('click', '.btn-delete', function() {
                const id = $(this).data('id');
                if (confirm('Are you sure you want to delete this employee?')) {
                    $.ajax({
                        url: `${API_URL}/${id}`,
                        type: 'DELETE',
                        success: function() {
                            table.ajax.reload();
                            alert('Employee deleted successfully');
                        }
                    });
                }
            });

            $('#employee-form').on('submit', function(e) {
                e.preventDefault();

                const id = $('#employee_id').val();
                const payload = {
                    name: $('#name').val(),
                    address: $('#address').val(),
                    department_id: $('#department_id').val(),
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
                        alert(`Employee ${id ? 'updated' : 'created'} successfully`);
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>
@endpush
