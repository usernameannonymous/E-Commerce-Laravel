<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Notifications\SendEmailNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function view_category()
    {

        if (Auth::id()) {
            $data = Category::all();
            return view('admin.category', compact('data'));
        }

        else{
            return redirect('login');
        }
    }

    public function add_category(Request $request)
    {

        $data = new Category();

        $data->category_name = $request->category;
        $data->save();

        return redirect()->back()->with('message', 'Category Added Successfully'); // return to the same page
    }

    public function delete_category($id)
    {

        $data = Category::find($id);
        $data->delete();

        return redirect()->back()->with('message', 'Category Deleted Successfully');
    }

    public function view_product()
    {

        $category = Category::all();
        return view('admin.product', compact('category'));
    }

    public function add_product(Request $request)
    {

        $product = new Product();

        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category = $request->category;
        $product->discount_price = $request->dis_price;

        //saving the image
        $image = $request->image;
        $imagename = time() . '.' . $image->getClientOriginalExtension(); //makes the name unique
        $request->image->move('product', $imagename);
        $product->image = $imagename;

        $product->save();

        return redirect()->back()->with('message', 'Product added successfully');
    }

    public function show_product()
    {

        $product = Product::all();
        return view('admin.show_product', compact('product'));
    }

    public function delete_product($id)
    {

        $product = Product::find($id);
        $product->delete();

        return redirect()->back()->with('message', 'Product deleted suucessfully');
    }

    public function update_product($id)
    {
        $product = Product::find($id);
        $category = Category::all();
        return view('admin.update_product', compact('product', 'category'));
    }

    public function update_product_confirm(Request $request, $id)
    {

        $product = Product::find($id);

        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category = $request->category;
        $product->discount_price = $request->dis_price;

        //saving the image
        $image = $request->image;

        if ($image) {
            $imagename = time() . '.' . $image->getClientOriginalExtension(); //makes the name unique
            $request->image->move('product', $imagename);
            $product->image = $imagename;
        }

        $product->save();

        return redirect()->back()->with('message', 'Product updated successfully');
    }

    public function order()
    {

        $order = Order::all();
        return view('admin.order', compact('order'));
    }

    public function delivered($id)
    {

        $order = Order::find($id);
        $order->delivery_status = "Delivered";
        $order->payment_status = "Paid";

        $order->save();

        return redirect()->back();
    }

    public function print_pdf($id)
    {

        $order = Order::findOrFail($id);

        $pdf = PDF::loadView('admin.pdf', compact('order'));
        return $pdf->download('Order_Details.pdf');
    }

    public function send_email($id)
    {

        $order = Order::findOrFail($id);

        return view('admin.email_info', compact('order'));
    }

    public function send_user_email(Request $request, $id)
    {

        $order = Order::findOrFail($id);

        $details = [
            'greeting' => $request->greeting,
            'firstline' => $request->firstline,
            'body' => $request->body,
            'button' => $request->button,
            'url' => $request->url,
            'lastline' => $request->lastline,
        ];

        Notification::send($order, new SendEmailNotification($details));

        return redirect()->back();
    }

    public function searchdata(Request $request)
    {

        $searchText = $request->search;

        // $order = Order::where('name','LIKE',"%$searchText%")->get();

        $order = Order::where('name', 'LIKE', "%$searchText%")
            ->orWhere('phone', 'LIKE', "%$searchText%")
            ->orWhere('product_title', 'LIKE', "%$searchText%")->get();

        return view('admin.order', compact('order'));
    }
}
