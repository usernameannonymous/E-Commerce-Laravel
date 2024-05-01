<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Comment;
use App\Models\Reply;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use Stripe;

class HomeController extends Controller
{
    //

    private function getAllProducts()
    {
        $product = Product::paginate(3);
        return $product;
    }

    public function index()
    {
        $product = $this->getAllProducts();
        $comment = Comment::orderby('id', 'desc')->get();
        $reply = Reply::all();
        return view('home.userpage', compact('product', 'comment', 'reply'));
    }

    public function redirect()
    {
        $usertype = Auth::user()->usertype;

        if ($usertype === '1') {

            $total_product = Product::all()->count();
            $total_order = Order::all()->count();
            $total_user = User::all()->count();
            $total_price = DB::table('Orders')->sum('price');
            $total_delivered = Order::where('delivery_status', '=', 'Delivered')->get()->count();
            $total_processed = Order::where('delivery_status', '=', 'Processing')->get()->count();

            return view('admin.home', compact(
                'total_product',
                'total_order',
                'total_user',
                'total_price',
                'total_delivered',
                'total_processed'
            ));
        } else {
            $product = $this->getAllProducts();
            $comment = Comment::orderby('id', 'desc')->get();
            $reply = Reply::all();
            return view('home.userpage', compact('product', 'comment', 'reply'));
        }
    }

    public function product_details($id)
    {
        $product = Product::find($id);
        return view('home.product_details', compact('product'));
    }

    public function add_cart(Request $request, $id)
    {

        if (Auth::id()) {

            $user = Auth::user();
            $product = Product::find($id);
            $userid = $user->id;

            $product_exist_id = Cart::where('product_id', '=', $id)
                ->where('user_id', '=', $userid)
                ->get('id')
                ->first();

            if ($product_exist_id) {

                $cart = Cart::findOrFail($product_exist_id->id);

                $quantity = $cart->quantity;
                $cart->quantity = $quantity + $request->quantity;

                if ($product->discount_price) {
                    $cart->price = $product->discount_price * $cart->quantity;
                } else {
                    $cart->price = $product->price * $cart->quantity;
                }
                $cart->save();


                return redirect()->back()->with('message',"Product Added Successfully");
            } else {

                $cart = new Cart();

                $cart->name = $user->name;
                $cart->email = $user->email;
                $cart->phone = $user->phone;
                $cart->address = $user->address;
                $cart->user_id = $user->id;
                $cart->product_title = $product->title;

                if ($product->discount_price) {
                    $cart->price = $product->discount_price * $request->quantity;
                } else {
                    $cart->price = $product->price * $request->quantity;
                }
                $cart->image = $product->image;
                $cart->product_id = $product->id;
                $cart->quantity = $request->quantity;

                $cart->save();

                Alert::success("Product added successfully","Product added to the cart");

                // return redirect()->back()->with('message',"Product Added Successfully");

                return redirect()->back();
            }
        } else {
            return redirect('login');
        }
    }

    public function show_cart()
    {

        if (Auth::id()) {
            $id = Auth::user()->id;
            $cart = Cart::where('user_id', '=', $id)->get();
            return view('home.showcart', compact('cart'));
        } else {
            return redirect('login');
        }
    }

    public function remove_cart($id)
    {

        $cart = Cart::find($id);
        $cart->delete();

        return redirect()->back();
    }

    public function cash_order()
    {

        $user = Auth::user();
        $userid = $user->id;

        $data = Cart::where('user_id', '=', $userid)->get();

        foreach ($data as $data) {
            $order = new Order();
            $order->name = $data->name;
            $order->email = $data->email;
            $order->phone = $data->phone;
            $order->address = $data->address;
            $order->user_id = $data->user_id;
            $order->product_title = $data->product_title;
            $order->price = $data->price;
            $order->quantity = $data->quantity;
            $order->image = $data->image;
            $order->product_id = $data->product_id;
            $order->payment_status = 'Cash On Delivery';
            $order->delivery_status = 'Processing';

            $cart_id = $data->id;
            $cart = Cart::find($cart_id);
            $cart->delete();

            $order->save();
        }

        return redirect()->back()->with('message', 'Order placed successfully');
    }

    public function stripe($totalprice)
    {
        return view('home.stripe', compact('totalprice'));
    }

    public function stripePost(Request $request, $totalprice)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create([
            "amount" => $totalprice * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Test payment from itsolutionstuff.com."
        ]);

        $user = Auth::user();
        $userid = $user->id;

        $data = Cart::where('user_id', '=', $userid)->get();

        foreach ($data as $data) {
            $order = new Order();
            $order->name = $data->name;
            $order->email = $data->email;
            $order->phone = $data->phone;
            $order->address = $data->address;
            $order->user_id = $data->user_id;
            $order->product_title = $data->product_title;
            $order->price = $data->price;
            $order->quantity = $data->quantity;
            $order->image = $data->image;
            $order->product_id = $data->product_id;
            $order->payment_status = ' Paid';
            $order->delivery_status = 'Processing';

            $cart_id = $data->id;
            $cart = Cart::find($cart_id);
            $cart->delete();

            $order->save();
        }

        Session::flash('success', 'Payment successful!');

        return back();
    }

    public function show_order()
    {

        if (Auth::id()) {

            $user_id = Auth::user()->id;
            $order = Order::where('user_id', '=', $user_id)->get();
            return view('home.order', compact('order'));
        } else {
            return redirect('login');
        }
    }

    public function cancel_order($id)
    {

        $order = Order::findOrFail($id);
        $order->delivery_status = 'Order Canceled';
        $order->save();

        return redirect()->back();
    }

    public function add_coment(Request $request)
    {

        if (Auth::id()) {

            $comment = new Comment();
            $comment->name = Auth::user()->name;
            $comment->user_id = Auth::user()->id;
            $comment->comment = $request->comment;

            $comment->save();

            return redirect()->back();
        } else {
            return redirect('login');
        }
    }

    public function add_reply(Request $request)
    {

        if (Auth::id()) {
            $reply = new Reply();
            $reply->name = Auth::user()->name;
            $reply->user_id = Auth::user()->id;
            $reply->comment_id = $request->commentId;
            $reply->reply = $request->reply;

            $reply->save();

            return redirect()->back();
        } else {
            return redirect('login');
        }
    }

    public function product_search(Request $request)
    {

        $search_text = $request->search;
        $comment = Comment::orderby('id', 'desc')->get();
        $reply = Reply::all();
        $product = Product::where('title', 'LIKE', "%$search_text%")
            ->orWhere('category', 'LIKE', "%$search_text%")
            ->paginate(10);

        return view('home.userpage', compact('product', 'comment', 'reply'));
    }

    public function products()
    {

        $comment = Comment::orderby('id', 'desc')->get();
        $reply = Reply::all();
        $product = Product::paginate(10);

        return view('home.all_product', compact('product', 'comment', 'reply'));
    }


    public function search_product(Request $request)
    {
        $search_text = $request->search;
        $comment = Comment::orderby('id', 'desc')->get();
        $reply = Reply::all();
        $product = Product::where('title', 'LIKE', "%$search_text%")
            ->orWhere('category', 'LIKE', "%$search_text%")
            ->paginate(10);

        return view('home.all_product', compact('product', 'comment', 'reply'));
    }
}
