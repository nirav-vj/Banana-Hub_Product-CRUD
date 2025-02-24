<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image"
        href="https://icons.iconarchive.com/icons/alecive/flatwoken/512/Apps-Google-Drive-Forms-icon.png">
    <title>User Profile</title>

    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(120deg, #7eccfd, #ff9292);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Profile Card Container */
        .profile-card {
            background: linear-gradient(130deg, #bfe2faa1, #f8dede00);
            border: 30px inset #ffffffd7;
            border-radius: 115px;
            padding: 40px;
            text-align: center;
            width: 380px;
            box-shadow: 0 30px 20px rgba(0, 0, 0, 0.2);
        }

        /* User Logo Circle */
        .logo {
            background-color: #f0f4f8;
            color: black;
            font-size: 35px;
            width: 65px;
            height: 65px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto;
            border: 2px solid #018c43;
        }

        /* Name and Email Styling */
        .profile-card h3 {
            margin: 10px 0;
            font-size: 20px;
        }

        .profile-card h3.name {
            color: #2c3e50;
            font-weight: bold;
            margin-top: 35px;
            color: #018c43;
        }

        .profile-card h3.email {
            color: #34495e;
            font-style: italic;
            color: #018c43;

        }

        /* Fallback Message */
        .fallback-message {
            color: #e74c3c;
            font-size: 30px;
            font-weight: bold;
            text-align: center;
        }

        .check-out {
            background-color: #018C43;
            color: white;
            border: 2px dashed #018C43;
            height: 35px;
            border-radius: 3px;
            margin-top: 20px;
            box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
        }

        button:hover {
            color: black;
        }

        .xmark {
            background: none;
            border: none;
            color: #018C43;
            font-size: 25px;
            position: absolute;
            margin-left: 145px;
            margin-top: -52px;
        }
    </style>
</head>

<body>
    @if (isset($users))
        <div class="profile-card">
            <div class="logo">
                <div
                    style="position: relative; width: 60px; height: 60px; border-radius: 30px; overflow: hidden; display: inline-block;">
                    @if (!empty($users->file))
                        <img src="{{ asset('images/' . $users->file) }}" alt="User Image"
                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 30px;">
                            <h1>{{$users->file}}</h1>
                    @else
                        <i class="fa-regular fa-user"
                            style="font-size: 30px; color: #018C43; line-height: 60px; text-align: center; width: 60px; height: 60px;  border-radius: 30px;"></i>
                    @endif
                </div>
                <div>
                    <a href="{{ url('/home') }}"><button class="xmark"><i class="fa-solid fa-xmark"></i></button></a>
                </div>
            </div>


            <h3 class="name" style="font: italic small-caps bold 30px/20px Georgia, serif;"> {{ $users->name }}</h3>
            <h3 class="email">{{ $users->email }}</h3><br>


            <form action="/user/picture" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="text-align: center; font: italic small-caps bold 20px/20px Georgia, serif;">
                    <label for="file" style="font-weight: bold; color: #018c43; margin-right: 10px;">Choose
                        Avatar:</label>
                    <input type="file" id="file" name="file" accept="image/*"
                        style="border: 1px solid #ccc; padding: 7px; border-radius: 5px;">
                </div>
                <button type="submit" class="check-out"
                    style="margin-top: 15px;width: 113px;font-size: 15px;">SUBMIT</button>
            </form>


            <div>
                <a href="/password"><button class="check-out">CHANGE PASSWORD</button></a>
            </div>

        </div>
    @else
        <p class="fallback-message">No user data available.</p>
    @endif
</body>

</html>
