<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    @include('admin.css')

    <style>
        .title_deg {
            text-align: center;
            font-size: 25px;
            font-weight: bold;
            padding-bottom: 50px;
        }

        .table_deg {
            margin: auto;
            width: 100%;
            border: 2px solid white;
            text-align: center;
        }

        .th_deg {
            background-color: skyblue;
        }

        .img_size {
            height: 100px;
            width: 200px;
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
                    <h1 class="title_deg">All Orders</h1>


                    <div style="padding-left:400px; padding-bottom:30px">
                        <form action="{{url('search')}}" method="get">

                            @csrf
                            <input action="" name="search" style="color:black" placeholder="Search" />
                            <input type="submit" class="btn btn-outline-primary" value="Search">
                        </form>
                    </div>

                    <table class="table_deg">
                        <tr class="th_deg">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Product Title</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Payment Status</th>
                            <th>Delivery Status</th>
                            <th>Image</th>
                            <th>Delivered</th>
                            <th>Download PDF</th>
                            <th>Send Email</th>
                        </tr>
                        @forelse($order as $order)
                        <tr class="">
                            <td>{{$order->name}}</td>
                            <td>{{$order->email}}</td>
                            <td>{{$order->address}}</td>
                            <td>{{$order->phone}}</td>
                            <td>{{$order->product_title}}</td>
                            <td>{{$order->quantity}}</td>
                            <td>{{$order->price}}</td>
                            <td>{{$order->payment_status}}</td>
                            <td>{{$order->delivery_status}}</td>
                            <td>
                                <img class="img_size" src="/product/{{$order->image}}" alt="">
                            </td>
                            <td>
                                @if($order->delivery_status=="Processing")
                                <a href="{{url('delivered',$order->id)}}" onclick="return confirm('Are you sure this product is delivered?')" class="btn btn-primary">Delivered</a>

                                @else
                                <p>Delivered</p>
                                @endif
                            </td>
                            <td>
                                <a href="{{url('print_pdf',$order->id)}}" class="btn btn-primary">PDF</a>
                            </td>
                            <td>
                                <a href="{{url('send_email',$order->id)}}" class="btn btn-primary">Email</a>
                            </td>
                        </tr>

                        @empty

                        <div>
                            <td colspan="16">
                                <p>No Data Found</p>
                            </td>
                        </div>

                        @endforelse
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