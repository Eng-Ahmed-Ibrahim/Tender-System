@php
    $amountofBills = \App\Models\Bill::all();
    $profit = 0; 
    foreach ($amountofBills as $anount ) {
        $profit += $amount->amount;
    }

@endphp



<div class="col-lg-3">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title"><i class="fas fa-ad me-2"></i> Profits</h3>
            <p>{{ $profit }}</p>
        </div>
    </div>
</div>

