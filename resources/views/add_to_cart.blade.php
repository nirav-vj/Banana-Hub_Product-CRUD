<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping Cart</title>
    <link rel="icon" type="image/png"
        href="https://icons.iconarchive.com/icons/alecive/flatwoken/512/Apps-Google-Drive-Forms-icon.png">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(120deg, #7eccfd, #ff9292);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .cart-container {
            width: 80%;
            max-width: 1000px;
            background-color: #FFFFFF;
            padding: 40px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 1);
            text-align: center;
        }
        .cart-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 40px;
            margin-top: 15px;
        }
        .cart-item img {
            width: 480px;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
            transition: transform 0.6s;
        }
        .cart-item img:hover {
            transform: scale(1.05);
        }
        .cart-item h1 {
            color: #018C43;
            font: italic small-caps bold 32px Georgia, serif;
            margin-bottom: 10px;
            text-align: center;
        }
        .cart-item h2 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #333;
        }
        .cart-item h2 span {
            color: #00A526;
            font-weight: bold;
        }
        .total-price {
            margin-top: 30px;
            font-size: 28px;
            font-weight: bold;
            color: #018C43;
        }
        .cancel {
            font-size: 17px;
            font-weight: bold;
            color: #018C43;
            background-color: #FFFFFF;
            border: 3px solid #018C43;
        }
        button {
            background-color: #018C43;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease-in-out;
        }
        button:hover {
            color: black;
        }
        @media (max-width: 768px) {
            .cart-container {
                padding: 20px;
            }
            .cart-item img {
                width: 220px;
            }
            .cart-item h1 {
                font-size: 24px;
            }
            .cart-item h2 {
                font-size: 20px;
            }
            .total-price {
                font-size: 24px;
            }
            button {
                font-size: 14px;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="cart-container">
        @php $totalPrice = 0; @endphp
        @foreach ($carts as $cart)
            <div>
                @if ($cart->product->count() == 0)
                    <a href="{{ url('/home') }}">
                        <button
                            style="position: absolute; top:65px; background-color: #018C43; color: white; border:none; height:40px; width:80px; left:11%; border-radius: 10px; font-size: 16px;">BACK</button>
                    </a>
                @endif
            </div>
            <div style="font-size: 20px;">
                @if ($cart->product->count() == 0)
                    <h1>Your Cart Is Currently Empty.</h1>
                @endif
            </div>
            @foreach ($cart->product as $key => $product)
                <div class="cart-item">
                    <img src="{{ asset('images/' . $product->file) }}" alt="Product Image">
                    <h1>{{ $product->type_of_banana_Chips }}</h1>
                    <h2>Price: ₹<span id="show-total-product-price-{{ $key }}">{{ $product->price }}</span></h2>
                    <input type="hidden" class="product-price-class" data-base-price="{{ $product->price }}"
                        value="{{ $product->price }}" id="product-total-price-{{ $key }}">
                    <div class="quantity">
                        <button onclick="updateQuantity({{ $key }}, -1)"
                            style="background-color: #018C43; border: none; height: 25px; width: 25px; text-align: center; border-radius: 0; padding: 0; display: inline-flex; align-items: center; justify-content: center;">-</button>
                        <input type="text" id="quantity-increment-{{ $key }}" value="1" readonly
                            style="width: 47px; text-align: center; border: 1px solid lightgrey; height: 21px; border-radius: 3px;">
                        <button onclick="updateQuantity({{ $key }}, 1)"
                            style="background-color: #018C43; border: none; height: 25px; width: 25px; text-align: center; border-radius: 0; padding: 0; display: inline-flex; align-items: center; justify-content: center;">+</button>
                    </div>
                    <br>
                    <div style="display: flex; gap: 5px; justify-content: center; padding: 0; margin-right: 23px;">
                        <a href="{{ route('payment', ['amount' => $product->price]) }}"><button>BUY IT NOW</button></a>
                        <a href="{{ url('/home/add-to-cart/delete/') }}/{{ $product->id }}"><button>REMOVE</button></a>
                    </div>
                    @php $totalPrice += $product->price; @endphp
                </div>
            @endforeach
        @endforeach
        @if (isset($product->id))
            <div class="total-price">
                <h2>Total Price: ₹<span id="total-product-price">{{ $totalPrice }}</span></h2>
                <button style="width: 40%; height: 50px;">BUY</button><br>
            </div>
        @endif
        <div>
            @if (isset($product->id))
                <a href="{{ url('/home') }}">
                    <button class="cancel"
                        style="width: 40%; text-align: center; justify-content: center; margin-top: 10px;">CONTINUE
                        SHOPPING</button>
                </a>
            @endif
        </div>
    </div>
    <script>
        function updateQuantity(key, change) {
            const quantityInput = document.getElementById(`quantity-increment-${key}`);
            const productPriceInput = document.getElementById(`product-total-price-${key}`);
            const productPriceDisplay = document.getElementById(`show-total-product-price-${key}`);
            const totalProductPrice = document.getElementById(`total-product-price`);
            const allProductPrices = document.querySelectorAll(".product-price-class");

            let quantity = parseInt(quantityInput.value) + change;
            if (quantity < 1) quantity = 1;
            quantityInput.value = quantity;
            
            const basePrice = parseInt(productPriceInput.getAttribute("data-base-price"));
            const updatedPrice = basePrice * quantity;
            productPriceInput.value = updatedPrice;
            productPriceDisplay.textContent = updatedPrice;
            let totalPrice = 0;
            allProductPrices.forEach((priceInput) => {
                totalPrice += parseInt(priceInput.value);
            });
            totalProductPrice.textContent = totalPrice;
        }
    </script>
</body>
</html>