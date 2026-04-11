@extends('layouts.app')

@section('page_title', ucfirst($role) . ' Accounts Management')

@section('content')
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h2 style="font-size: 1.125rem; font-weight: 700;">{{ ucfirst($role) }} Accounts Table</h2>
                <p style="font-size: 0.8125rem; color: var(--text-muted);">Add, delete, update <span
                        style="color: #db2777;">.{{ $role }}-accounts</span></p>
                <p style="font-size: 0.75rem; color: #db2777; font-weight: 600; margin-top: 0.25rem;">p.s password 4
                    character of email and nomor.</p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('admin.users.export', $role) }}" class="btn" style="background: #6366f1; color: white;">
                    Export Excel
                </a>
                <button onclick="showAddModal()" class="btn" style="background: #10b981; color: white;">
                    <i class="fas fa-plus-square"></i> Add
                </button>
            </div>
        </div>

        <div class="table-container" style="border: none;">
            <table style="border: none;">
                <thead>
                    <tr style="background: transparent; border-bottom: 1px solid var(--border);">
                        <th
                            style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">
                            #</th>
                        <th
                            style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">
                            Name</th>
                        <th
                            style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">
                            Email</th>
                        <th
                            style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal; text-align: center;">
                            Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td style="padding: 1.25rem 1rem;">{{ $loop->iteration }}</td>
                            <td style="padding: 1.25rem 1rem; font-weight: 500;">{{ $user->name }}</td>
                            <td style="padding: 1.25rem 1rem;">{{ $user->email }}</td>
                            <td style="padding: 1.25rem 1rem; text-align: center;">
                                <div style="display: flex; justify-content: center; gap: 0.5rem;">
                                    <button onclick="showEditModal({{ json_encode($user) }})" class="btn"
                                        style="background: #6366f1; color: white; padding: 0.5rem 1.5rem;">Edit</button>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this user?')" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn"
                                            style="background: #ef4444; color: white; padding: 0.5rem 1.5rem;">Delete</button>
                                    </form>
                                    @if($role === 'staff')
                                        <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn"
                                                style="background: #f59e0b; color: white; padding: 0.5rem 1.5rem;">Reset
                                                Password</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addModal" class="modal-backdrop">
        <div class="modal-content" style="max-width: 800px; padding: 2rem;">
            <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">Add Account Forms</h2>
            <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 2rem;">Please <span
                    style="color: #db2777;">.fill-all</span> input form with right value.</p>

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <input type="hidden" name="role" value="{{ $role }}">
                <div class="form-group">
                    <label class="form-label" style="color: var(--text-main); font-weight: 600;">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="nama" value="{{ old('name') }}">
                    @error('name')<span style="color: var(--danger); font-size: 0.75rem;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" style="color: var(--text-main); font-weight: 600;">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="email" value="{{ old('email') }}">
                    @error('email')<span style="color: var(--danger); font-size: 0.75rem;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" style="color: var(--text-main); font-weight: 600;">Role</label>
                    <select name="role_select" class="form-control" disabled>
                        <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="staff" {{ $role == 'staff' ? 'selected' : '' }}>Staff</option>
                    </select>
                    @error('role')<span style="color: var(--danger); font-size: 0.75rem;">{{ $message }}</span>@enderror
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 3rem;">
                    <button type="button" onclick="hideAddModal()" class="btn"
                        style="background: #9ca3af; color: white; padding: 0.75rem 2.5rem;">Cancel</button>
                    <button type="submit" class="btn"
                        style="background: #6366f1; color: white; padding: 0.75rem 2.5rem;">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal-backdrop">
        <div class="modal-content" style="max-width: 800px; padding: 2rem;">
            <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">Edit Account Forms</h2>
            <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 2rem;">Please <span
                    style="color: #db2777;">.fill-all</span> input form with right value.</p>

            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label" style="color: var(--text-main); font-weight: 600;">Name</label>
                    <input type="text" name="name" id="edit_name" class="form-control" placeholder="admin wikrama">
                </div>

                <div class="form-group">
                    <label class="form-label" style="color: var(--text-main); font-weight: 600;">Email</label>
                    <input type="email" name="email" id="edit_email" class="form-control" placeholder="admin@gmail.com">
                </div>

                <div class="form-group">
                    <label class="form-label" style="color: var(--text-main); font-weight: 600;">New Password <span
                            style="color: var(--accent); font-weight: 400; font-size: 0.75rem;">optional</span></label>
                    <input type="password" name="new_password" class="form-control">
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 3rem;">
                    <button type="button" onclick="hideEditModal()" class="btn"
                        style="background: #9ca3af; color: white; padding: 0.75rem 2.5rem;">Cancel</button>
                    <button type="submit" class="btn"
                        style="background: #6366f1; color: white; padding: 0.75rem 2.5rem;">Submit</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function showAddModal() { $('#addModal').addClass('show'); }
            function hideAddModal() { $('#addModal').removeClass('show'); }
            function showEditModal(user) {
                $('#editForm').attr('action', `/admin/users/${user.id}`);
                $('#edit_name').val(user.name);
                $('#edit_email').val(user.email);
                $('#editModal').addClass('show');
            }
            function hideEditModal() { $('#editModal').removeClass('show'); }

            @if($errors->any())
                $(document).ready(function () { showAddModal(); });
            @endif
        </script>
    @endpush
@endsection