<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="icon" type="image"
        href="https://icons.iconarchive.com/icons/alecive/flatwoken/512/Apps-Google-Drive-Forms-icon.png">
    <title>Our Product</title>
    <style>
        .hader {
            text-align: center;
            display: flex;
            gap: 25px;
            justify-content: center;
            color: #018C43;
            font-size: 25px;
            font-family: sans-serif;
        }

        .image-group {
            justify-content: space-around;
            display: flex;
        }

        .buy-button {
            background-color: #018C43;
            color: white;
            border: none;
            width: 70px;
            height: 30px;
            margin-top: 20px;
            border-radius: 5px
        }

        button:hover {
            color: black;
        }

        .image {
            height: 400px;
            border-radius: 50px;
            margin-top: 70px;
            border: 6px solid rgb(255, 208, 0);
        }

        .product-section-heading {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #image:hover {
            transition: transform 0.9s;
            transform: scale(1.03);
        }

        .search {
            background-color: #018C43;
            color: white;
            border: 2px dashed #018C43;
            height: 35px;
            border-radius: 3px;
        }


        .buy {
            background-color: #018C43;
            color: white;
            border: none;
            width: 120px;
            height: 30px;
            margin-top: 12px;
            border-radius: 5px
        }

        li.class1 {
            display: inline-block;
        }

        .class3 {
            display: none;
            position: absolute;
            background: linear-gradient(120deg, #acddfc, #fcb9b9);
            border-radius: 5%;
            justify-content: center;
            text-align: center;
            margin-left: -1%;
        }


         li a,.class2 {
            display: inline-block;
            color: rgb(7, 7, 7);
        }
        .class3 a {
            color: rgb(5, 5, 5);
            padding: 12px 16px;
            display: block;
            text-align: center;
            text-decoration: none;
            
        }
        .class3 a:hover {
            background-color:rgba(252, 232, 232, 0.733);
            border-radius: 5%;
            justify-content: center;
        }
        .class1:hover .class3 {
            display: block;
        }

        @media (max-width:1440px) {
            .snacks-product-card {
                grid-template-columns: auto auto auto auto !important;
            }
        }

        @media (max-width:1024px) {
            .snacks-product-card {
                grid-template-columns: auto auto auto !important;
            }
        }

        @media (max-width:768px) {
            .snacks-product-card {
                grid-template-columns: auto auto !important;
                justify-content: center;
                text-align: center;
                margin-left: 25%;
            }
        }

        @media (max-width:425px) {
            .snacks-product-card {
                text-align: center;
                grid-template-columns: auto !important;
                justify-content: center;
                text-align: center;
                margin-left: 100%;
            }
        }
    </style>
</head>

<body style=" background: linear-gradient(120deg, #7eccfd, #ff9292);">

    <div class="product-section-heading" style="gap: 20%">
        <form action="{{ url('/search') }}" method="post">
            @csrf
            <div style="margin-left: 0px;">
                <input type="search" name="search"
                    style="height: 35px;border: none;border-radius: 3px;font-size: 15px" placeholder="Search..">
                <input type="submit" value="SEARCH" class="search">
            </div>

        </form>

        <div class="hader">
            <h1>OUR </h1>
            <h1>PRODUCTS</h1>
        </div>

        <div style="padding-right:100px ; display: flex ;gap: 0px;margin-left:50px" class="offcanvas offcanvas-end"
            id="demo">
            <a href="/create"
                style="margin-top:16.5%;color: #018c43 ;border:2px dashed #018C43 ;height: 28px; font-size: 25px;width: 30px;"
                class="logo"><i class="fa-solid fa-plus" style="margin-left: 4px;"></i></a>

            <ol>
                <li style="list-style-type: none;" class="class1">
                        <a href="/home" class="class2"
                            style=" color:#018c43 ;border:2px solid #018C43 ; font-size: 25px;border-radius: 34px;width: 35px;text-align: center;height: 33px;"
                            class="logo"><i class="fa-regular fa-user" style="margin-top: 2.5px; "
                                class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#demo"></i>
                        </a>

                        <div class="class3">
                            <a href="{{ url('/user') }}" target="_self">Profile</a>
                            <a href="{{ url('/checkout') }}" target="_self">Logout</a>
                        </div>

                </li>
            </ol>

        </div>

    </div>

    <div id="user-bar">

    </div>


    <div class="image-group snacks-product-card"
        style="display:grid;grid-template-columns: auto auto auto auto ;gap: 10px; text-align: center">

        @isset($products)
            @foreach ($products as $product)
                <div style="text-align: center ;">
                    <div>
                        <a href="{{ url('/home/product') }}/{{ $product->id }}">
                            <img id="image" class="image"src={{ asset('images/' . $product->file) }}
                                alt="image not found"></a>
                    </div>
                    <div>
                        <h2>{{ $product->type_of_banana_Chips }} </h2>
                    </div>
                    <div>
                        <h2 style="color: rgb(97, 97, 97)">₹ {{ $product->price }}</h2>
                    </div>
                    {{--  <div style="display: flex;justify-content: center;gap: 15px">
                    <a href="{{ url('/home/edit/') }}/{{ $product->id }}"><button
                            class="buy-button">EDIT</button></a>
                    <a href="{{ url('/home/delete') }}/{{ $product->id }}"><button
                            class="buy-button">DELETE</button></a>
                        </div>  --}}
                    <div>
                        <a href="{{ url('/home/product') }}/{{ $product->id }}"><button
                                class="buy">BUY</button></a>

                    </div>
                </div>
            @endforeach
        @endisset
    </div>
</body>

</html>
