@extends('layouts.app')

@section('page_title', 'Admin Dashboard')

@section('content')
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="card animate-fade-in" style="border-bottom: 4px solid var(--primary);">
        <div style="font-size: 0.875rem; color: var(--text-muted); font-weight: 600;">TOTAL ITEMS</div>
        <div style="font-size: 2rem; font-weight: 800; margin: 0.5rem 0;">{{ \App\Models\Item::count() }}</div>
        <div style="font-size: 0.75rem; color: var(--secondary);"><i class="fas fa-arrow-up"></i> Registered items</div>
    </div>
    <div class="card animate-fade-in" style="border-bottom: 4px solid var(--secondary); animation-delay: 0.1s;">
        <div style="font-size: 0.875rem; color: var(--text-muted); font-weight: 600;">ACTIVE LENDINGS</div>
        <div style="font-size: 2rem; font-weight: 800; margin: 0.5rem 0;">{{ \App\Models\LendingDetail::whereNull('return_date')->count() }}</div>
        <div style="font-size: 0.75rem;"><i class="fas fa-clock"></i> Currently borrowed</div>
    </div>
    <div class="card animate-fade-in" style="border-bottom: 4px solid var(--danger); animation-delay: 0.2s;">
        <div style="font-size: 0.875rem; color: var(--text-muted); font-weight: 600;">BROKEN ITEMS</div>
        <div style="font-size: 2rem; font-weight: 800; margin: 0.5rem 0;">{{ \App\Models\Item::sum('repair_stock') }}</div>
        <div style="font-size: 0.75rem; color: var(--danger);"><i class="fas fa-tools"></i> Need repair</div>
    </div>
    <div class="card animate-fade-in" style="border-bottom: 4px solid var(--accent); animation-delay: 0.3s;">
        <div style="font-size: 0.875rem; color: var(--text-muted); font-weight: 600;">TOTAL STAFF</div>
        <div style="font-size: 2rem; font-weight: 800; margin: 0.5rem 0;">{{ \App\Models\User::where('role', 'staff')->count() }}</div>
        <div style="font-size: 0.75rem;"><i class="fas fa-user-friends"></i> Active operators</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
    <div class="card">
        <h3 style="margin-bottom: 1.5rem;">Recent Activities</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Borrower</th>
                        <th>Item</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\Lending::with('details.item')->latest()->take(5)->get() as $lending)
                        @foreach($lending->details as $detail)
                        <tr>
                            <td>{{ $lending->borrower_name }}</td>
                            <td>{{ $detail->item->name }}</td>
                            <td>{{ $lending->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($detail->return_date)
                                    <span style="color: var(--secondary); font-weight: 600;"><i class="fas fa-check"></i> Returned</span>
                                @else
                                    <span style="color: var(--accent); font-weight: 600;"><i class="fas fa-hourglass-half"></i> Borrowed</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <h3 style="margin-bottom: 1.5rem;">Inventory Split</h3>
        <div style="height: 250px; display: flex; align-items: center; justify-content: center; color: var(--text-muted);">
            <canvas id="itemChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('itemChart');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Good', 'Broken'],
            datasets: [{
                data: [{{ \App\Models\Item::sum('total_stock') - \App\Models\Item::sum('repair_stock') }}, {{ \App\Models\Item::sum('repair_stock') }}],
                backgroundColor: ['#4f46e5', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            cutout: '70%',
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endpush
