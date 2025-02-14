<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>processing...</h1>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "{{ env('RAZORPAY_KEY') }}", 
            "amount": "{{ $amount }}",
            "currency": "INR",
            "name": "Demo Corp",
            "description": "Test Transaction",
            "callback_url":"http://127.0.0.1:8000/home",
            "handler":function(response){
                var payid = response.razorpay_payment_id;
                alert('Payment Success : ' + payid); 
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
    </script>
</body>

</html>