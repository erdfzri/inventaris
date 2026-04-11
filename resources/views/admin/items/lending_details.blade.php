@extends('layouts.app')

@section('page_title', 'Item Lending Details')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.125rem; font-weight: 700;">Lending Details: {{ $item->name }}</h2>
            <p style="font-size: 0.8125rem; color: var(--text-muted);">History of <span style="color: #db2777;">.lendings</span> for this item</p>
        </div>
        <a href="{{ route('admin.items.index') }}" class="btn" style="background: #e2e8f0; color: #475569;">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="table-container" style="border: none;">
        <table style="border: none;">
            <thead>
                <tr style="background: transparent; border-bottom: 1px solid var(--border);">
                    <th style="padding: 1.25rem 0.5rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">#</th>
                    <th style="padding: 1.25rem 0.5rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">Borrower</th>
                    <th style="padding: 1.25rem 0.5rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">Total</th>
                    <th style="padding: 1.25rem 0.5rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">Date</th>
                    <th style="padding: 1.25rem 0.5rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">Returned</th>
                    <th style="padding: 1.25rem 0.5rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">Edited By</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lendingDetails as $detail)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 1.25rem 0.5rem;">{{ $loop->iteration }}</td>
                    <td style="padding: 1.25rem 0.5rem; font-weight: 500;">{{ $detail->lending->borrower_name }}</td>
                    <td style="padding: 1.25rem 0.5rem;">{{ $detail->quantity }}</td>
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
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
