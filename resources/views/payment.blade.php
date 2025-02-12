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
            "name": "Hello Corp",
            "description": "Test Transaction",
            "handler":function(response){
                var payid = response.razorpay_payment_id;
                alert('Payment Success : ' + payid); 
            },
            "image": "https://example.com/your_logo",
            "order_id": "{{ $orderId }}",
            "callback_url": "https://eneqd3r9zrjok.x.pipedream.net/",
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