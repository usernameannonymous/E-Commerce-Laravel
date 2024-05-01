<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    @include('admin.css')
    <style type="text/css">
        .center {
            margin: auto;
            width: 85%;
            border: 2px solid white;
            text-align: center;
            margin-top: 40px;
        }

        .font_size {
            text-align: center;
            font-size: 40px;
            padding-top: 20px;
        }

        .img_size {
            width: 120px;
            height: 120px;
        }

        .th_color {
            background: green;
        }

        .th_deg {
            padding: 20px;

        }

        .hover:hover {
            transform: scale(1.2);
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        @include('admin.sidebar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            @include('admin.header')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">

                    @if(session()->has('message'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                        {{session()->get('message')}}
                    </div>
                    @endif
                    <h2 class="font_size">All Products</h2>
                    <table class="center">
                        <tr class="th_color">
                            <th class="th_deg">Product title</th>
                            <th class="th_deg">Description</th>
                            <th class="th_deg">Quantity</th>
                            <th class="th_deg">Category</th>
                            <th class="th_deg">Price</th>
                            <th class="th_deg">Discount Price</th>
                            <th class="th_deg">Product Image</th>
                            <th class="th_deg">Delete</th>
                            <th class="th_deg">Edit</th>
                        </tr>

                        @foreach($product as $product)
                        <tr>
                            <td>{{$product->title}}</td>
                            <td>{{$product->description}}</td>
                            <td>{{$product->quantity}}</td>
                            <td>{{$product->category}}</td>
                            <td>{{$product->price}}</td>
                            <td>{{$product->discount_price}}</td>
                            <td>
                                <img class="img_size" src="/product/{{$product->image}}" alt="">
                            </td>
                            <td>
                                <a href="{{url('/delete_product',$product->id)}}" class="btn btn-danger hover " onclick="return confirm('Are you sure to dele the product?')">Delete</a>
                            </td>
                            <td>
                                <a href="{{url('/update_product',$product->id)}}" class="btn btn-success hover">Edit</a>
                            </td>
                        </tr>
                        @endforeach

                    </table>
                </div>
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        @include('admin.script')
        <!-- Custom js for this page -->
        <script src="admin/assets/js/dashboard.js"></script>
        <!-- End custom js for this page -->
</body>

</html>