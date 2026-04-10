@extends('layouts.app')

@section('page_title', 'Items Management')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.125rem; font-weight: 700;">Items Table</h2>
            <p style="font-size: 0.8125rem; color: var(--text-muted);">Add, delete, update <span style="color: #db2777;">.items</span></p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('admin.items.export') }}" class="btn" style="background: #6366f1; color: white;">
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
                    <th style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">#</th>
                    <th style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">Category</th>
                    <th style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">Name</th>
                    <th style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal; text-align: center;">Total</th>
                    <th style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal; text-align: center;">Repair</th>
                    <th style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal; text-align: center;">Lending</th>
                    <th style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td style="padding: 1.25rem 1rem;">{{ $loop->iteration }}</td>
                    <td style="padding: 1.25rem 1rem;">{{ $item->category->name }}</td>
                    <td style="padding: 1.25rem 1rem; font-weight: 500;">{{ $item->name }}</td>
                    <td style="padding: 1.25rem 1rem; text-align: center;">{{ $item->total_stock }}</td>
                    <td style="padding: 1.25rem 1rem; text-align: center;">{{ $item->repair_stock }}</td>
                    <td style="padding: 1.25rem 1rem; text-align: center;">
                        @if($item->lending_total > 0)
                            <a href="{{ route('admin.items.lendings', $item->id) }}" style="color: #6366f1; text-decoration: underline; font-weight: 600;">{{ $item->lending_total }}</a>
                        @else
                            0
                        @endif
                    </td>
                    <td style="padding: 1.25rem 1rem; text-align: center;">
                        <button onclick="showEditModal({{ json_encode($item) }})" class="btn" style="background: #6366f1; color: white; padding: 0.5rem 1.5rem;">Edit</button>
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
        <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">Add Item Forms</h2>
        <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 2rem;">Please <span style="color: #db2777;">.fill-all</span> input form with right value.</p>
        
        <form action="{{ route('admin.items.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control select2" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Item Name</label>
                <input type="text" name="name" class="form-control" required placeholder="Projector Epson">
            </div>
            <div class="form-group">
                <label class="form-label">Total Stock</label>
                <input type="number" name="total_stock" class="form-control" required min="1">
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
        <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">Edit Item Forms</h2>
        <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 2rem;">Please <span style="color: #db2777;">.fill-all</span> input form with right value.</p>
        
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Category</label>
                <select name="category_id" id="edit_category_id" class="form-control select2" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Item Name</label>
                <input type="text" name="name" id="edit_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Total Stock</label>
                <input type="number" name="total_stock" id="edit_total_stock" class="form-control" required min="1">
            </div>
            <div style="background: #f8fafc; padding: 1.5rem; border-radius: var(--radius); border: 1px dashed var(--border); margin-top: 1rem;">
                <label class="form-label" style="font-size: 0.75rem;">REPORT NEW BROKEN ITEMS (Currently: <span id="current_repair">0</span>)</label>
                <input type="number" name="new_broke_item" class="form-control" min="0" value="0">
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
    function showEditModal(item) {
        $('#editForm').attr('action', `/admin/items/${item.id}`);
        $('#edit_category_id').val(item.category_id).trigger('change');
        $('#edit_name').val(item.name);
        $('#edit_total_stock').val(item.total_stock);
        $('#current_repair').text(item.repair_stock);
        $('#editModal').addClass('show');
    }
    function hideEditModal() { $('#editModal').removeClass('show'); }
    
    function showLendingDetails(itemId) {
        alert("Details for lending item #" + itemId);
    }
</script>
@endpush
@endsection
