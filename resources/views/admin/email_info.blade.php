<!DOCTYPE html>
<html lang="en">

<head>

    <base href="/public">
    <!-- Required meta tags -->
    @include('admin.css')

    <style type="text/css">
        label{
            display: inline-block;
            width: 150px;
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

                    <h1 style="text-align:center; font-size:25px;">Send Order to {{$order->email}}</h1>

                    <form action="{{url('send_user_email',$order->id)}}" method="POST">

                        @csrf

                        <div style="padding-left: 35%; padding-top:30px">
                            <label>Email Greeting</label>
                            <input style="color: black;" type="text" name="greeting">
                        </div>

                        <div style="padding-left: 35%; padding-top:30px">
                            <label>Email Firstline</label>
                            <input style="color: black;" type="text" name="firstline">
                        </div>

                        <div style="padding-left: 35%; padding-top:30px">
                            <label>Email Body</label>
                            <input style="color: black;" type="text" name="body">
                        </div>

                        <div style="padding-left: 35%; padding-top:30px">
                            <label>Email Button</label>
                            <input style="color: black;" type="text" name="button">
                        </div>

                        <div style="padding-left: 35%; padding-top:30px">
                            <label>Email URL</label>
                            <input style="color: black;" type="text" name="url">
                        </div>

                        <div style="padding-left: 35%; padding-top:30px">
                            <label>Email Lastline</label>
                            <input style="color: black;" type="text" name="lastline">
                        </div>

                        <div style="padding-left: 35%; padding-top:30px">
                            <input style="color: white;" type="submit" name="Send" class="btn btn-primary">
                        </div>

                    </form>


                </div>
            </div>

        </div>
        @include('admin.script')
        <!-- Custom js for this page -->
        <script src="admin/assets/js/dashboard.js"></script>
        <!-- End custom js for this page -->
</body>

</html>