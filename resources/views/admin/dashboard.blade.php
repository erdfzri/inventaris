@extends('layouts.app')

@section('page_title', 'Admin Dashboard')

@section('content')

<div style="display: center; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
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
