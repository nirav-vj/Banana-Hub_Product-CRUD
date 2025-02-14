<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Processing</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            text-align: center;
            margin: 20px;
            background: linear-gradient(to right, #e0eafc, #cfdef3);
        }

        .receipt {
            display: none;
            border: none;
            padding: 30px;
            margin-top: 20px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            background: #fff;
            width: 30%;
            margin: auto;
            margin-top: 16%;

        }

        .details {
            margin: 15px 0;
            font-size: 18px;
            color: #34495e;
            text-align: left;
        }

        .details strong {
            color: #e74c3c;
        }

        .detail-entry {
            margin: 5px 0;
            padding: 5px;
            border-radius: 5px;
            background-color: #f7f9fc;
        }
    </style>
</head>

<body>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "{{ env('RAZORPAY_KEY') }}",
            "amount": "{{ $amount }}",
            "currency": "INR",
            "name": "Demo Corp",
            "description": "Test Transaction",
            "callback_url": "http://127.0.0.1:8000/home",
            "handler": function(response) {
                var payid = response.razorpay_payment_id;
                var amountPaid = options.amount / 100;
                {{--  var productName = "{{ $productName }}";
                var productPrice = "{{ $productPrice }}";  --}}


                generateReceipt(payid, amountPaid, "Razorpay Payment", "Nirav Vaja");
            },
            "image": "https://example.com/your_logo",
            "order_id": "{{ $orderId }}",
            "prefill": {
                "name": "Nirav Vaja",
                "email": "nirav.vaja@example.com",
                "contact": "9000090000"
            },
            "notes": {
                "address": "Razorpay Corporate Office"
            },
            "theme": {
                "color": "#3399cc"
            }
        };

        var rzp1 = new Razorpay(options);
        rzp1.open();

        function generateReceipt(paymentId, amount, description, customerName) {

            document.body.innerHTML += `  
                <div class="receipt" id="receipt">  
                    <h2>Payment Receipt</h2>  
                    <div class="details"><strong>Customer Name:</strong> ${customerName}</div>  
                    {{--  <div class="details"><strong>Purchased Product:</strong> ${productName} - ₹${productPrice}</div>  --}}
                    <div class="details"><strong>Payment ID:</strong> ${paymentId}</div>  
                    <div class="details"><strong>Description:</strong> ${description}</div>  
                    <div class="details"><strong>Date & Time:</strong> ${new Date().toLocaleString('en-IN', { hour12: true })}</div>
                    <div class="details"><strong>Status:</strong> Payment Successful</div>  
                    <div style = "border-top: 3px solid;"></div>
                    <div style = "display:flex;gap:65%;">
                        <div class="details">  <strong>Amount Paid:</strong></div>
                        <div style = "margin-top: 16px;">₹${amount.toFixed(2)}</div>
                    </div>
                </div>`;

            document.getElementById('receipt').style.display = 'block';
        }
    </script>
</body>

</html>
