@extends('admin.layouts.main')
@section('content')
    <!-- Modal user form -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="userForm" method="POST" action="">
                @csrf
                <input type="hidden" name="_method" id="form_method" value="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userModalLabel">Add New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form fields -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="displayname" class="form-label">Display Name</label>
                            <input type="text" class="form-control" id="displayname" name="displayname">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3" id="password-group">
                            <label id="label-password" for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                @foreach (\App\Models\User::getRoleOptions() as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('role', $user->role ?? '') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="modalSubmitBtn">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="deleteUserForm">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="confirmDeleteLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this user?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Mass Delete Confirmation Modal -->
    <div class="modal fade" id="confirmMassDeleteModal" tabindex="-1" aria-labelledby="confirmMassDeleteLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.users.massDestroy') }}" id="massDeleteUserForm">
                @csrf
                @method('POST')
                <input type="hidden" name="ids" id="massDeleteUserIds">

                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="confirmDeleteLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to mass delete these users?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <div class="container mt-4">

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold text-primary">{{ $title }}</h4>


            <div class="d-flex gap-2">
                <a href="#" id="btnAddNew" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New
                </a>
                <button type="button" id="btnDeleteSelected" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i> Delete Selected
                </button>
            </div>
        </div>


        <table id="users-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Display name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Actions</th> <!-- cột cho nút edit/delete -->
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td><input type="checkbox" class="user-checkbox" value="{{ $user->id }}"></td>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->displayname ?? $user->username . '#' . $user->id }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->getRoleName() }}</td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning btn-edit-user" data-id="{{ $user->id }}"
                                title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>


                            <button type="button" class="btn btn-sm btn-danger btn-delete-user"
                                data-id="{{ $user->id }}"
                                data-action="{{ route('admin.users.destroy', $user->id) }}" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#users-table').DataTable({
                // Tùy chỉnh nếu cần
                paging: true,
                searching: true,
                ordering: true,
                order: [
                    [0, 'asc']
                ],
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var userModal = new bootstrap.Modal(document.getElementById('userModal'));

            // Khi nhấn "Add New"
            document.getElementById('btnAddNew').addEventListener('click', function(e) {
                e.preventDefault();
                clearForm();
                document.getElementById('userModalLabel').innerText = 'Add New User';
                document.getElementById('userForm').action = "{{ route('admin.users.store') }}";
                document.getElementById('form_method').value = 'POST';
                document.getElementById('label-password').innerText = 'Password';
                document.getElementById('password-group').style.display =
                    'block'; // show password khi tạo mới
                userModal.show();
            });


            document.getElementById('btnDeleteSelected').addEventListener('click', function() {
                let selected = Array.from(document.querySelectorAll('.user-checkbox:checked'))
                    .map(cb => cb.value);

                if (selected.length === 0) {
                    toastr.warning('Please select at least one user to delete.', null, {
                        timeOut: 5000,
                        extendedTimeOut: 2000,
                        closeButton: true,
                        escapeHtml: false
                    });
                    return;
                }

                document.getElementById('massDeleteUserIds').value = selected.join(',');


                const deleteModal = new bootstrap.Modal(document.getElementById(
                    'confirmMassDeleteModal'));
                deleteModal.show();
            });

            document.getElementById('checkAll').addEventListener('change', function() {
                const checked = this.checked;
                document.querySelectorAll('.user-checkbox').forEach(cb => cb.checked = checked);
            });
            // Khi nhấn nút Edit
            document.querySelectorAll('.btn-edit-user').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    clearForm();
                    document.getElementById('userModalLabel').innerText = 'Edit User';
                    document.getElementById('label-password').innerText = 'New Password';

                    var userId = this.getAttribute('data-id');
                    var urlEdit = "{{ url('admin/users') }}/get/" + userId;
                    var urlUpdate = "{{ url('admin/users') }}/update/" + userId;

                    // Load dữ liệu user qua ajax (GET)
                    fetch(urlEdit)
                        .then(response => response.json())
                        .then(data => {
                            // điền dữ liệu vào form
                            document.getElementById('username').value = data.username;
                            document.getElementById('displayname').value = data.displayname;
                            document.getElementById('email').value = data.email;
                            document.getElementById('role').value = data.role;
                            // password ẩn khi edit
                            // document.getElementById('password-group').style.display = 'none';
                            document.getElementById('password').required = false;
                        })
                        .catch(err => {
                            alert('Failed to load user data.');
                            console.error(err);
                        });

                    document.getElementById('userForm').action = urlUpdate;
                    document.getElementById('form_method').value = 'PUT';
                    userModal.show();
                });
            });
            document.querySelectorAll('.btn-delete-user').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
                    const actionUrl = this.getAttribute('data-action');

                    const form = document.getElementById('deleteUserForm');
                    form.action = actionUrl;

                    const deleteModal = new bootstrap.Modal(document.getElementById(
                        'confirmDeleteModal'));
                    deleteModal.show();
                });
            });

            function clearForm() {
                document.getElementById('userForm').reset();
                // Xóa lỗi validation nếu có
                // Ví dụ: $('.is-invalid').removeClass('is-invalid');
            }
        });
    </script>
@endsection
