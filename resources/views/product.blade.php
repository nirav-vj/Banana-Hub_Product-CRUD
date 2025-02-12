<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image"
        href="https://icons.iconarchive.com/icons/alecive/flatwoken/512/Apps-Google-Drive-Forms-icon.png">
    <style>
        body {
            background: linear-gradient(120deg, #7eccfd, #ff9292);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 98vh;
            font-family: Arial, sans-serif;
            position: relative;
        }

        .container {
            display: flex;
            align-items: center;
            background: linear-gradient(120deg, #b8e1fa, #fdc1c1);
            padding: 20px;
            border-radius: 100px;
            width: 80%;
            height: 62%;
            max-width: 1200px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
            {{--  background-color: rgba(255, 255, 255, 0.85);  --}}
        }

        .cart {
            position: absolute;
            top: 7%;
            right: 10%;
            background-color: #018C43;
            color: white;
            height: 50px;
            width: 50px;
            border-radius: 30%;
            justify-content: center;
            align-items: center;
            font-size: 30px;
        }

        .image-container {
            flex: 1;
            height: 93%;
            display: flex;
            justify-content: center;
        }

        .image-container img {
            max-width: 95%;
            height: auto;
            border-radius: 50px;
        }

        #images:hover {
            transition: transform 0.9s;
            transform: scale(1.05);
        }

        .sub-img:hover {
            transition: transform 0.9s;
            transform: scale(1.1);
        }

        .text-container {
            flex: 1;
            padding: 20px;
            text-align: left;
        }

        .text-container h1 {
            color: #018C43;
            font: italic small-caps bold 35px/1.2 Georgia, serif;
            margin-bottom: 20px;
            text-align: center;
        }

        .text-container .price {
            color: black;
            font: italic small-caps bold 35px/1.2 Georgia, serif;
            margin-bottom: 20px;
            text-align: center;
        }

        .text-container .add-to-cart,
        .text-container .buy {
            background-color: #018C43;
            color: white;
            border: none;
            width: 150px;
            height: 40px;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px 0;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .text-container .quantity {}

        .text-container .buy {
            background-color: #018C43;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                height: auto;
            }

            .text-container {
                text-align: center;
            }

            .image-container img {
                max-width: 80%;
                margin-bottom: 10px;
            }
        }

        @media (max-width: 480px) {
            .text-container h1 {
                font-size: 24px;
            }

            .text-container .price {
                font-size: 24px;
            }

            .text-container .add-to-cart,
            .text-container .buy {
                width: 100%;
                height: 50px;
            }

            .cart {
                top: 10px;
                right: 10px;
            }
        }
    </style>
</head>

<body>
    <div>
        <a href="/home/cart" class="cart"><span style="position: relative;top:10px;left: 8.5px"><i
                    class="fa-solid fa-cart-shopping"></i></span>
            <span
                style="position: absolute;margin-left: 6px;margin-top: -10px;
                        font-size: 20px;
                        background-color: red;
                        border-radius: 50px;
                        width: 25px;
                        text-align: center;
                        height: 23px;">{{ $number->product->count() }}</span></a>
    </div>
    <div>
        <a href="{{ url('/home') }}"><button
                style="position: absolute;top:65px;background-color: #018C43;color: white;
                                                    border:none;height:40px;width:80px;left:11%;border-radius: 10px;
                                                    font-size: 16px;">BACK</button></a>
    </div>
    <div class="container">
        <div class="image-container" id="images">
            <img src="{{ asset('images/' . $data->file) }}" alt="Product Image">
        </div>

        <div class="text-container">
            <h1>{{ $data->type_of_banana_Chips }}</h1>

            <p style="text-align: center;"><span style="border-bottom:1px solid black;">(BANANHUB)</span></p>

            <h5 class="price">₹ {{ $data->price }}</h5><br>

            <a href="/home/add-to-cart/product/{{ $data->id }}" style="text-decoration: none"><button
                    class="add-to-cart">ADD-TO-CART</button></a>

            <a href="/product/payment/{{ $data->id }}" style="text-decoration: none"><button
                    class="buy">BUY</button></a><br><br>

            <p style="text-align: center;">Multiple secure payment options available</p>

            <div style="display: flex;gap:10px;flex-wrap: wrap;justify-content: center;height: 50px;">
                <img class="sub-img"
                    style="height: 50px;border: 3px solid rgba(0, 153, 255, 0.267);border-radius: 17px;object-fit: cover;"
                    src="https://cdn.amote.app/assets/badges/visa_1_color_card.svg" alt="Img Not Found">
                <img class="sub-img"
                    style="height: 50px;border: 3px solid rgba(0, 153, 255, 0.267);border-radius: 17px;object-fit: cover;"
                    src="https://cdn.amote.app/assets/badges/mastercard_color_card.svg" alt="Img Not Found">
                <img class="sub-img"
                    style="height: 50px;border: 3px solid rgba(0, 153, 255, 0.267);border-radius: 17px;object-fit: cover;"
                    src="https://cdn.amote.app/assets/badges/googlepay_color_card.svg" alt="Img Not Found">
                <img class="sub-img"
                    style="height: 50px;width: 70px;border: 3px solid rgba(0, 153, 255, 0.267);border-radius: 17px;"
                    src="https://media.assettype.com/digitalterminal/2024-02/bcb8486b-67ee-407b-a75c-9d430f389f53/Amazon_Pay_Logo_png.jpg?w=1200&h=675&auto=format%2Ccompress&fit=max&enlarge=true"
                    alt="Img Not Found">
                <img class="sub-img"
                    style="height: 50px;border: 3px solid rgba(0, 153, 255, 0.267);border-radius: 17px;object-fit: cover;"
                    src="https://cdn.amote.app/assets/badges/rupay_color_card.svg" alt="Img Not Found">
            </div>
        </div>
    </div>
</body>

</html>
