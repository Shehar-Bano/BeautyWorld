<!DOCTYPE html>
<html lang="en">
    @include('view.head')
<head>
    <meta charset="UTF-8">
    <title>Order Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.5; margin: 20px; }
        .container { max-width: 600px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; border-radius: 8px; }
        .header, .footer { text-align: center; margin-bottom: 15px; }
        .details p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .item-header { background-color: #f9f9f9; }
        .print-button { margin-top: 20px; text-align: center; }
    </style>
</head>
<body>
    <div id="printableArea" class="container">
        <div class="header">
            <h2>Order Receipt</h2>
        </div>
        <div class="details">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
            <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
            <p><strong>Date:</strong> {{ $order->date }}</p>
            
        </div>
        <table>
            <thead>
                <tr>
                   
                    <th>Item</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderServices as $orderService)
                    @if ($orderService->service)
                        <tr class="item-header">
                           
                            <td>{{ $orderService->service->name }}</td>
                            <td>{{ number_format($orderService->service->price) }} Rs/-</td>
                        </tr>
                    @endif
                    @if ($orderService->deal)
                        <tr class="item-header">
                           
                            <td>
                                {{ $orderService->deal->name }}
                                <ul>
                                    @foreach ($orderService->deal->dealService as $dealService)
                                        <li>
                                            {{ $dealService->service->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ number_format($orderService->deal->dis_price) }} Rs/-</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            
        </table>
        <div class="footer">
            <p><strong>Total Payment:</strong> {{ number_format($order->total_payment) }} Rs/-</p>
            <p>Thank you for your order!</p>
        </div>
    </div>

    <div class="print-button">
        <button  class="btn  btn-outline-info"  onclick="printReceipt()">Print Receipt</button>
    </div>

    <script>
        function printReceipt() {
            var printContents = document.getElementById('printableArea').innerHTML;
            var originalContents = document.body.innerHTML;

            // Temporarily replace the page content with the content to print
            document.body.innerHTML = printContents;
            window.print();

            // Restore the original page content after printing
            document.body.innerHTML = originalContents;
            window.location.replace('{{ route('cart.index', ['success' => 'Receipt printed successfully']) }}');
        }
    </script>
</body>
</html>
