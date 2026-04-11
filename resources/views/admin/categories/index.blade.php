@extends('layouts.app')

@section('page_title', 'Categories Management')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.125rem; font-weight: 700;">Categories Table</h2>
            <p style="font-size: 0.8125rem; color: var(--text-muted);">Add, delete, update</p>
        </div>
        <button onclick="showAddModal()" class="btn" style="background: #10b981; color: white;">
            <i class="fas fa-plus-square"></i> Add
        </button>
    </div>

    <div class="table-container" style="border: none;">
        <table style="border: none;">
            <thead>
                <tr style="background: transparent; border-bottom: 1px solid var(--border);">
                    <th style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">#</th>
                    <th style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">Name</th>
                    <th style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">Division PJ</th>
                    <th style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal; text-align: center;">Total Items</th>
                    <th style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td style="padding: 1.25rem 1rem;">{{ $loop->iteration }}</td>
                    <td style="padding: 1.25rem 1rem; font-weight: 500;">{{ $category->name }}</td>
                    <td style="padding: 1.25rem 1rem;">{{ $category->division_pj }}</td>
                    <td style="padding: 1.25rem 1rem; text-align: center;">{{ $category->items_count ?? $category->items()->count() }}</td>
                    <td style="padding: 1.25rem 1rem; text-align: center;">
                        <div style="display: flex; justify-content: center; gap: 0.5rem;">
                            <button onclick="showEditModal({{ json_encode($category) }})" class="btn" style="background: #6366f1; color: white; padding: 0.5rem 1.5rem;">Edit</button>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category?')" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn" style="background: #ef4444; color: white; padding: 0.5rem 1.5rem;">Delete</button>
                            </form>
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
        <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">Add Category Forms</h2>
        <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 2rem;">Please <span style="color: #db2777;">.fill-all</span> input form with right value.</p>
        
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" style="color: var(--text-main); font-weight: 600;">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Alat Dapur" value="{{ old('name') }}">
                @error('name')
                    <span style="color: var(--danger); font-size: 0.75rem; display: block; margin-top: 0.5rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" style="color: var(--text-main); font-weight: 600;">Division PJ</label>
                <div style="position: relative;">
                    <select name="division_pj" class="form-control select2 @error('division_pj') is-invalid @enderror">
                        <option value="">Select Division PJ</option>
                        <option value="Sarpras" {{ old('division_pj') == 'Sarpras' ? 'selected' : '' }}>Sarpras</option>
                        <option value="Tata Usaha" {{ old('division_pj') == 'Tata Usaha' ? 'selected' : '' }}>Tata Usaha</option>
                        <option value="tefa" {{ old('division_pj') == 'tefa' ? 'selected' : '' }}>tefa</option>
                    </select>
                </div>
                @error('division_pj')
                    <span style="color: var(--danger); font-size: 0.75rem; display: block; margin-top: 0.5rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 3rem;">
                <button type="button" onclick="hideAddModal()" class="btn" style="background: #9ca3af; color: white; padding: 0.75rem 2.5rem;">Cancel</button>
                <button type="submit" class="btn" style="background: #6366f1; color: white; padding: 0.75rem 2.5rem;">Submit</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal-backdrop">
    <div class="modal-content" style="max-width: 800px; padding: 2rem;">
        <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">Edit Category Forms</h2>
        <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 2rem;">Please <span style="color: #db2777;">.fill-all</span> input form with right value.</p>
        
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label" style="color: var(--text-main); font-weight: 600;">Name</label>
                <input type="text" name="name" id="edit_name" class="form-control" placeholder="Alat Dapur">
            </div>

            <div class="form-group">
                <label class="form-label" style="color: var(--text-main); font-weight: 600;">Division PJ</label>
                <select name="division_pj" id="edit_division_pj" class="form-control select2">
                    <option value="Sarpras">Sarpras</option>
                    <option value="Tata Usaha">Tata Usaha</option>
                    <option value="tefa">tefa</option>
                </select>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 3rem;">
                <button type="button" onclick="hideEditModal()" class="btn" style="background: #9ca3af; color: white; padding: 0.75rem 2.5rem;">Cancel</button>
                <button type="submit" class="btn" style="background: #6366f1; color: white; padding: 0.75rem 2.5rem;">Update</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function showAddModal() { $('#addModal').addClass('show'); }
    function hideAddModal() { $('#addModal').removeClass('show'); }
    function showEditModal(category) {
        $('#editForm').attr('action', `/admin/categories/${category.id}`);
        $('#edit_name').val(category.name);
        $('#edit_division_pj').val(category.division_pj).trigger('change');
        $('#editModal').addClass('show');
    }
    function hideEditModal() { $('#editModal').removeClass('show'); }

    // Auto show modal if validation errors exist
    @if($errors->any())
        $(document).ready(function() {
            if("{{ old('_method') }}" == 'PUT') {
                // Determine which category was being edited if possible, or just show add
                showAddModal(); 
            } else {
                showAddModal();
            }
        });
    @endif
</script>
@endpush

<style>
    .form-control.is-invalid {
        border-color: var(--danger) !error;
        box-shadow: 0 0 0 1px var(--danger);
    }
    .btn {
        border-radius: 4px; /* Sharper buttons as in screenshot */
        font-weight: 500;
        cursor: pointer;
    }
</style>
@endsection
