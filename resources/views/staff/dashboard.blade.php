@extends('layouts.app')

@section('page_title', 'Operator Dashboard')

@section('content')
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card animate-fade-in" style="border-bottom: 4px solid var(--primary);">
        <div style="font-size: 0.875rem; color: var(--text-muted); font-weight: 600;">MY LENDINGS RECORDED</div>
        <div style="font-size: 2rem; font-weight: 800; margin: 0.5rem 0;">{{ \App\Models\Lending::where('staff_id', auth()->id())->count() }}</div>
        <div style="font-size: 0.75rem;"><i class="fas fa-history"></i> Total since start</div>
    </div>
    <div class="card animate-fade-in" style="border-bottom: 4px solid var(--secondary); animation-delay: 0.1s;">
        <div style="font-size: 0.875rem; color: var(--text-muted); font-weight: 600;">ACTIVE LENDINGS</div>
        <div style="font-size: 2rem; font-weight: 800; margin: 0.5rem 0;">{{ \App\Models\LendingDetail::whereHas('lending', fn($q) => $q->where('staff_id', auth()->id()))->whereNull('return_date')->count() }}</div>
        <div style="font-size: 0.75rem;"><i class="fas fa-clock"></i> Currently pending return</div>
    </div>
    <div class="card animate-fade-in" style="border-bottom: 4px solid var(--accent); animation-delay: 0.2s;">
        <div style="font-size: 0.875rem; color: var(--text-muted); font-weight: 600;">AVAILABLE ITEMS</div>
        <div style="font-size: 2rem; font-weight: 800; margin: 0.5rem 0;">{{ \App\Models\Item::all()->sum('available_stock') }}</div>
        <div style="font-size: 0.75rem;"><i class="fas fa-box"></i> Ready to lend</div>
    </div>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3>Your Recent Lending Transactions</h3>
        <a href="{{ route('staff.lendings.index') }}" class="btn btn-primary btn-sm">New Lending</a>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Borrower</th>
                    <th>Items</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\Lending::with('details.item')->where('staff_id', auth()->id())->latest()->take(10)->get() as $lending)
                    <tr>
                        <td style="font-weight: 600;">{{ $lending->borrower_name }}</td>
                        <td>
                            @foreach($lending->details as $detail)
                                <div style="font-size: 0.75rem;">{{ $detail->quantity }}x {{ $detail->item->name }}</div>
                            @endforeach
                        </td>
                        <td>{{ $lending->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($lending->details->whereNull('return_date')->isEmpty())
                                <span style="background: rgba(16, 185, 129, 0.1); color: var(--secondary); padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">Returned</span>
                            @else
                                <span style="background: rgba(245, 158, 11, 0.1); color: var(--accent); padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">Active</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
