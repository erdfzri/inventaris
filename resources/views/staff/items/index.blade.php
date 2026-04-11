@extends('layouts.app')

@section('page_title', 'Items List')

@section('content')
<div class="card">
    <div style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.125rem; font-weight: 700;">Items Table</h2>
        <p style="font-size: 0.8125rem; color: var(--text-muted);">Data</p>
    </div>

    <div class="table-container" style="border: none;">
        <table style="border: none;">
            <thead>
                <tr style="background: transparent; border-bottom: 1px solid var(--border);">
                    <th style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">#</th>
                    <th style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">Category</th>
                    <th style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal;">Name</th>
                    <th style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal; text-align: center;">Total</th>
                    <th style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal; text-align: center;">Available</th>
                    <th style="padding: 1.25rem 1rem; color: var(--text-main); font-size: 0.875rem; text-transform: none; letter-spacing: normal; text-align: center;">Lending Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 1.25rem 1rem;">{{ $loop->iteration }}</td>
                    <td style="padding: 1.25rem 1rem;">{{ $item->category->name }}</td>
                    <td style="padding: 1.25rem 1rem; font-weight: 500;">{{ $item->name }}</td>
                    <td style="padding: 1.25rem 1rem; text-align: center;">{{ $item->total_stock }}</td>
                    <td style="padding: 1.25rem 1rem; text-align: center; font-weight: 700; position: relative;">
                        <span style="display: inline-block;">{{ $item->available_stock }}</span>
                        @if($item->lending_total > 0)
                        <div style="height: 3px; background: #92400e; width: 60px; margin: 4px auto 0; border-radius: 2px;"></div>
                        @endif
                    </td>
                    <td style="padding: 1.25rem 1rem; text-align: center;">{{ $item->lending_total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
