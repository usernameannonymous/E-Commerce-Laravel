<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->

    <base href="/public">
    @include('admin.css')

    <style type="text/css">
        .div_center {
            text-align: center;
            padding-top: 40px;
        }

        .font_size {
            font-size: 40px;
            padding-bottom: 40px;
        }

        .text_color {
            color: black;
            padding-bottom: 20px;
        }

        label {
            display: inline-block;
            width: 200px;
        }

        .div_design {
            padding-bottom: 20px;
        }

        .img_size {
            width: 120px;
            height: 120px;
            margin: auto;
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
                    <div class="alert alert-success fade-out ">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                        {{session()->get('message')}}
                    </div>
                    @endif
                    <div class="div_center">
                        <h1 class="font_size">Update Product</h1>

                        <form action="{{url('/update_product_confirm',$product->id)}}" method="post" enctype="multipart/form-data">

                            @csrf

                            <div class="div_design">
                                <label>Product Title:</label>
                                <input class="text_color" type="text" name="title" value="{{$product->title}}" placeholder="Write a title" required>
                            </div>

                            <div class="div_design">
                                <label>Product Description:</label>
                                <input class="text_color" type="text" name="description" value="{{$product->description}}" placeholder="Write a Description" required>
                            </div>

                            <div class="div_design">
                                <label>Product Price:</label>
                                <input class="text_color" type="number" name="price" value="{{$product->price}}" placeholder="Write a price" required>
                            </div>

                            <div class="div_design">
                                <label>Discount Price:</label>
                                <input class="text_color" type="number" name="dis_price" value="{{$product->discount_price}}" placeholder="Write a discount">
                            </div>

                            <div class="div_design">
                                <label>Product Quantity:</label>
                                <input class="text_color" type="number" min="0" name="quantity" value="{{$product->quantity}}" placeholder="Write a quantity" required>
                            </div>

                            <div class="div_design">
                                <label>Product Category:</label>
                                <select name="category" class="text_color" required>

                                    <option value="{{$product->category}}" selected="">{{$product->category}}</option>

                                    @foreach($category as $category)
                                    <option value="{{$category->category_name}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="div_design">
                                <label>Product Image:</label>
                                <img class="img_size" src="/product/{{$product->image}}" alt="">
                            </div>

                            <div class="div_design">
                                <label>Change Product Image:</label>
                                <input type="file" name="image">
                            </div>

                            <div class="div_design">
                                <button type="submit" value="Add a product" class="btn btn-primary">Update product</button>
                            </div>

                        </form>

                    </div>
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