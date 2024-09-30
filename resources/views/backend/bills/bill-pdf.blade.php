<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Invoice') }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif; /* Ensures Arabic characters display */
            direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}; /* Set text direction */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>{{ __('Invoice') }}</h1>
        <p>{{ __('Billing Date:') }} {{ $bill->due_date }}</p>
    </div>

    <div class="customer-info">
        <p>{{ __('Customer Name:') }} {{ $bill->customerSubscription->customer->name }}</p>
        <p>{{ __('Bill ID:') }} {{ $bill->id }}</p>
        <p>{{ __('Subscription Plan:') }} {{ $bill->subscriptionPlan->name }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>{{ __('Description') }}</th>
                <th>{{ __('Amount') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ __('Subscription Plan:') }} {{ $bill->subscriptionPlan->name }}</td>
                <td>{{ $bill->amount }}</td>
            </tr>
            <tr>
                <td>{{ __(' Ads (Normal):') }} {{ $bill->remaining_ads_normal }}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ __(' Ads (Commercial):') }} {{ $bill->remaining_ads_commercial }}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ __(' Ads (Popup):') }} {{ $bill->remaining_ads_popup }}</td>
                <td></td>
            </tr>
            <tr>
                <td>{{ __(' Ads (Banners):') }} {{ $bill->remaining_ads_banners }}</td>
                <td></td>
            </tr>
            <tr>
                <td><strong>{{ __('Grand Total') }}</strong></td>
                <td><strong>{{ $bill->amount }}</strong></td>
            </tr>
        </tbody>
    </table>

    <footer>
        <p>{{ __('Thank you for your business!') }}</p>
    </footer>
</body>
</html>
