@extends('layouts.app')

@section('page_title', 'Operator Users')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.25rem;">Staff & Operator Accounts</h2>
            <p style="font-size: 0.875rem; color: var(--text-muted);">Manage inventory operators</p>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('admin.users.export', 'staff') }}" class="btn btn-secondary">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <button onclick="showAddModal()" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Staff
            </button>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th style="width: 250px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-weight: 600;">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                    <td style="text-align: right; display: flex; justify-content: flex-end; gap: 0.5rem;">
                        <button onclick="showEditModal({{ json_encode($user) }})" class="btn" style="background: rgba(79, 70, 229, 0.1); color: var(--primary); padding: 0.5rem;" title="Edit"><i class="fas fa-edit"></i></button>
                        
                        <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn" style="background: rgba(245, 158, 11, 0.1); color: var(--accent); padding: 0.5rem;" title="Reset Password"><i class="fas fa-key"></i></button>
                        </form>

                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user?')" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn" style="background: rgba(239, 68, 68, 0.1); color: var(--danger); padding: 0.5rem;" title="Delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div id="addModal" class="modal-backdrop">
    <div class="modal-content">
        <h2 style="margin-bottom: 1.5rem;">Add Staff Account</h2>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <input type="hidden" name="role" value="staff">
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" required placeholder="John Doe">
            </div>
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required placeholder="john@staff.id">
            </div>
            <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 1rem;">
                <i class="fas fa-info-circle"></i> Password will be auto-generated based on the required rules.
            </p>
            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                <button type="button" onclick="hideAddModal()" class="btn" style="flex: 1; background: var(--border);">Cancel</button>
                <button type="submit" class="btn btn-primary" style="flex: 2;">Create Account</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal-backdrop">
    <div class="modal-content">
        <h2 style="margin-bottom: 1.5rem;">Edit Staff Account</h2>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" id="edit_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" id="edit_email" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">New Password (Optional)</label>
                <input type="password" name="new_password" class="form-control" placeholder="Leave blank to keep current">
            </div>
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="button" onclick="hideEditModal()" class="btn" style="flex: 1; background: var(--border);">Cancel</button>
                <button type="submit" class="btn btn-primary" style="flex: 2;">Update Account</button>
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
</script>
@endpush
@endsection
