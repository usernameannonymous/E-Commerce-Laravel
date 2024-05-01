<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="images/favicon.png" type="">
    <title>Famms - Fashion HTML Template</title>
    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="home/css/bootstrap.css" />
    <!-- font awesome style -->
    <link href="home/css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="home/css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="home/css/responsive.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>

    <style type="text/css">
        .center {
            margin: auto;
            width: 80%;
            text-align: center;
            padding: 30px;
        }

        .cart_deg {
            margin: auto;
            width: 50%;
            text-align: center;
            padding: 30px;
            font-size: 50px;
        }

        table,
        th,
        td {
            border: 1px solid grey;
        }

        th {
            width: 500px;
            background-color: skyblue;
        }

        a:hover {
            transform: scale(1.2);
        }

        .img_deg {
            height: 100px;
            width: 100px;
            margin: auto;
        }

        .total_deg {
            font-size: 20px;
            padding: 40px;
        }

        .payment_deg {
            margin: 10px;
        }

        .payment_deg:hover {
            background-color: green;
        }
    </style>
</head>

<body>
    <div class="hero_area">
        @include('sweetalert::alert')
        <!-- header section strats -->
        @include('home.header')
        <!-- end header section -->

        @if(session()->has('message'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
            {{session()->get('message')}}
        </div>
        @endif


        <div class="center">
            <table>
                <tr>
                    <th class="th_teg">Product Title</th>
                    <th class="th_teg">Product Quantity</th>
                    <th class="th_teg">Price</th>
                    <th class="th_teg">Image</th>
                    <th class="th_teg">Action</th>
                </tr>

                <?php $totalprice = 0; ?>

                @foreach($cart as $cart)
                <tr>
                    <td>{{$cart->product_title}}</td>
                    <td>{{$cart->quantity}}</td>
                    <td>${{$cart->price}}</td>
                    <td>
                        <img class="img_deg" src="/product/{{$cart->image}}">
                    </td>
                    <td>
                        <!-- <a href="{{url('remove_cart',$cart->id)}}" class="btn btn-danger" onclick="confirmation(event)">Remove Product</a> -->

                        <a href="{{url('remove_cart',$cart->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure to delete this item?')">Remove Product</a>
                    </td>
                </tr>

                <?php

                //  $totalprice += ($cart->price * $cart->quantity)
                $totalprice += ($cart->price)

                ?>
                @endforeach
            </table>

            <div>
                <h1 class="total_deg">Total Price: ${{$totalprice}}</h1>
            </div>

            <div>
                <h1>Proceed to Order</h1>
                <a href="{{url('cash_order')}}" class="btn btn-primary payment_deg">Cash on Delivery</a>
                <a href="{{url('stripe',$totalprice)}}" class="btn btn-primary payment_deg">Pay using Card</a>
            </div>
        </div>

        <div class="cpy_">
            <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>

                Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>

            </p>
        </div>
        <!-- jQery -->
        <script src="home/js/jquery-3.4.1.min.js"></script>
        <!-- popper js -->
        <script src="home/js/popper.min.js"></script>
        <!-- bootstrap js -->
        <script src="home/js/bootstrap.js"></script>
        <!-- custom js -->
        <script src="home/js/custom.js"></script>

        <script>
            function confirmation(ev) {
                ev.preventDefault();
                var urlToRedirect = ev.currentTarget.getAttribute('href');
                console.log(urlToRedirect);

                swal({
                    title: "Are you sure tocancel the product?",
                    text: "You will not be able to revert this!",
                    icon: "danger",
                    buttons: True,
                    dangerMode: True
                }).then((willCanel)=>{
                    if(willCanel){
                        window.location.href = urlToRedirect;
                    }
            });
            }
        </script>
</body>

</html>