@extends('layout')

@section('content')
<div class="container" style="margin-top:20px;">
    <div class="row">
        <div class="alert alert-info" role="alert" style="padding:7px;">
            <p style="margin-bottom: 0;">
                Portfolió bekerülési értéke:
                <span class="font-weight-bold">$</span><span class="font-weight-bold" id="purchase-value">{{ $data['portfolioValue'] }}</span>
            </p>
            <p style="margin-bottom: 0;">
                Osztalék:
                <span class="font-weight-bold">${{ $data['sumPayout'] }}</span>
            </p>
            <p style="margin-bottom: 0;">
                Hozam:
                <span class="font-weight-bold">{{ $data['yield'] }}%</span>
            </p>
        </div>
    </div>

    <div class="row justify-content-md-center">
        @foreach ($data['dividends'] as $dividend)
            <div class="col-3">
                <div class="card" style="margin-bottom:15px;">
                    <div class="card-header">
                        <h4>{{ $dividend['ticker'] }}</h4>
                        <h5>{{ $dividend['company_name'] }}</h5>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Osztalék: <h4>${{ $dividend['payout'] }}</h4></li>
                        <li class="list-group-item">Bekerülési érték: <h5>${{ $dividend['purchase_price_sum'] }}</h5></li>
                        <li class="list-group-item">
                            {{ $dividend['yield'] }}%
                        </li>
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
$('document').ready(function () {
    $('#current-value').change(function () {
        const purchaseValue = parseFloat($('#purchase-value').text());
        const currentValue = parseFloat($(this).val());

        const yield = ((currentValue - purchaseValue) / purchaseValue) * 100;

        $('#yield').text(yield.toFixed(2) + '%');
    });
});
</script>
@endsection
