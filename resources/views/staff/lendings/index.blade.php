@extends('layouts.app')

@section('page_title', 'Lending Management')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.125rem; font-weight: 700;">Lending Table</h2>
            <p style="font-size: 0.8125rem; color: var(--text-muted);">Data of lendings</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('staff.lendings.export') }}" class="btn" style="background: #6366f1; color: white;">
                Export Excel
            </a>
            <button onclick="showAddModal()" class="btn" style="background: #10b981; color: white;">
                <i class="fas fa-plus-square"></i> Add
            </button>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-container" style="border: none;">
        <table style="border: none;">
            <thead>
                <tr style="background: transparent; border-bottom: 1px solid var(--border);">
                    <th style="padding: 1.25rem 0.5rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">#</th>
                    <th style="padding: 1.25rem 0.5rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">Item</th>
                    <th style="padding: 1.25rem 0.5rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">Total</th>
                    <th style="padding: 1.25rem 0.5rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">Name</th>
                    <th style="padding: 1.25rem 0.5rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">Ket.</th>
                    <th style="padding: 1.25rem 0.5rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">Date</th>
                    <th style="padding: 1.25rem 0.5rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">Returned</th>
                    <th style="padding: 1.25rem 0.5rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">Edited By</th>
                    <th style="padding: 1.25rem 0.5rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lendingDetails as $detail)
                <tr>
                    <td style="padding: 1.25rem 0.5rem;">{{ $loop->iteration }}</td>
                    <td style="padding: 1.25rem 0.5rem; font-weight: 500;">{{ $detail->item->name }}</td>
                    <td style="padding: 1.25rem 0.5rem;">{{ $detail->quantity }}</td>
                    <td style="padding: 1.25rem 0.5rem;">{{ $detail->lending->borrower_name }}</td>
                    <td style="padding: 1.25rem 0.5rem;">{{ $detail->lending->notes }}</td>
                    <td style="padding: 1.25rem 0.5rem;">{{ $detail->lending->created_at->format('d F, Y') }}</td>
                    <td style="padding: 1.25rem 0.5rem;">
                        @if($detail->return_date)
                            <span style="border: 1px solid #10b981; color: #10b981; padding: 0.25rem 0.75rem; border-radius: 4px; font-size: 0.75rem;">
                                {{ $detail->return_date->format('d F, Y') }}
                            </span>
                        @else
                            <span style="border: 1px solid #f59e0b; color: #f59e0b; padding: 0.25rem 0.75rem; border-radius: 4px; font-size: 0.75rem;">
                                not returned
                            </span>
                        @endif
                    </td>
                    <td style="padding: 1.25rem 0.5rem; font-weight: 800; font-size: 0.875rem;">{{ $detail->lending->staff->name }}</td>
                    <td style="padding: 1.25rem 0.5rem; text-align: center;">
                        <div style="display: flex; justify-content: center; gap: 0.5rem;">
                            @if(!$detail->return_date)
                            <form action="{{ route('staff.lendings.return', $detail->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn" style="background: #fbbf24; color: white; padding: 0.5rem 1.25rem;">Returned</button>
                            </form>
                            @endif
                            <form action="{{ route('staff.lendings.destroy', $detail->lending->id) }}" method="POST" onsubmit="return confirm('Delete this lending?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn" style="background: #ef4444; color: white; padding: 0.5rem 1.25rem;">Delete</button>
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
<div id="addModal" class="modal-backdrop {{ session('error') || $errors->any() ? 'show' : '' }}">
    <div class="modal-content" style="padding: 1.5rem;" x-data="{ items: {{ json_encode(old('items', [['id' => '', 'total' => '']])) }} }">
        <h2 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 0.25rem;">Lending Form</h2>
        <p style="font-size: 0.8125rem; color: var(--text-muted); margin-bottom: 1rem;">Please <span style="color: #db2777;">.fill-all</span> input form with right value.</p>
        
        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.875rem;">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('staff.lendings.store') }}" method="POST">
            @csrf
            <div class="form-group" style="margin-bottom: 1rem;">
                <label class="form-label" style="color: var(--text-main); font-weight: 600; margin-bottom: 0.25rem; display: block; font-size: 0.875rem;">Name</label>
                <input type="text" name="borrower_name" class="form-control" placeholder="Name" value="{{ old('borrower_name') }}" required style="padding: 0.5rem 0.75rem;">
            </div>

            <template x-for="(item, index) in items" :key="index">
                <div style="display: flex; gap: 0.75rem; margin-bottom: 0.75rem; align-items: flex-end;">
                    <div style="flex: 1;">
                        <label class="form-label" style="color: var(--text-main); font-weight: 600; margin-bottom: 0.25rem; display: block; font-size: 0.875rem;">Items</label>
                        <select :name="'items['+index+'][id]'" class="form-control" required x-model="item.id" style="width: 100%; padding: 0.5rem 0.75rem;">
                            <option value="">Select Items</option>
                            @foreach($items as $i)
                            <option value="{{ $i['id'] }}">{{ $i['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="width: 100px;">
                        <label class="form-label" style="color: var(--text-main); font-weight: 600; margin-bottom: 0.25rem; display: block; font-size: 0.875rem;">Total</label>
                        <input type="number" :name="'items['+index+'][total]'" class="form-control" placeholder="total" required x-model="item.total" style="width: 100%; padding: 0.5rem 0.75rem;">
                    </div>
                    <button type="button" x-show="items.length > 1" @click="items.splice(index, 1)" style="background: none; border: none; color: #ef4444; cursor: pointer; padding-bottom: 0.5rem;">
                        <i class="fas fa-times-circle" style="font-size: 1.125rem;"></i>
                    </button>
                </div>
            </template>

            <button type="button" @click="items.push({id: '', total: ''})" style="background: none; border: none; color: #06b6d4; font-weight: 600; cursor: pointer; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.25rem; padding: 0; font-size: 0.8125rem;">
                <i class="fas fa-chevron-down" style="font-size: 0.625rem;"></i> More
            </button>

            <div class="form-group" style="margin-bottom: 1rem;">
                <label class="form-label" style="color: var(--text-main); font-weight: 600; margin-bottom: 0.25rem; display: block; font-size: 0.875rem;">Ket.</label>
                <textarea name="notes" class="form-control" rows="2" style="height: auto; width: 100%; padding: 0.5rem 0.75rem;">{{ old('notes') }}</textarea>
            </div>

            <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                <button type="submit" class="btn" style="background: #6366f1; color: white; padding: 0.5rem 1.75rem; font-size: 0.875rem; font-weight: 600;">Submit</button>
                <button type="button" onclick="hideAddModal()" class="btn" style="background: #f8fafc; color: #64748b; padding: 0.5rem 1.75rem; border: 1px solid #e2e8f0; font-size: 0.875rem; font-weight: 600;">Cancel</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function showAddModal() { $('#addModal').addClass('show'); }
    function hideAddModal() { $('#addModal').removeClass('show'); }
</script>
@endpush
@endsection
