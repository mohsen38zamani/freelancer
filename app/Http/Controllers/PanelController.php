<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\PublicClass\PublicControllerFunction;

class PanelController extends Controller
{
    protected $controllerFunction;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        if(Auth::user()->roleid != 1) return Redirect::route('home');

        $this->controllerFunction = new PublicControllerFunction();
        $users = \App\User_profile::all()->count();
//        $invoice = \App\Invoice::all()->count();
//        $product = \App\Product::all()->count();
//        $customer = \App\Customer::all()->count();

        /* ---- color >>> white,danger,muted,primary,warning,success,info,inverse,pink,purple,dark,bluedark ----*/
        $block_info = array(
            'dashboard' => array('title' => 'Today', 'count' => date('Y-m-d'), 'percent' => 100, 'color' => 'danger', 'icon' => 'fa fa-calendar', 'access' => array(1, 2)),
            'user_profile' => array('title' => 'User', 'count' => $users, 'percent' => 100, 'color' => 'success', 'icon' => 'fa fa-user', 'access' => array(1, 2)),
//            'product' => array('title' => 'محصولات', 'count' => $product, 'percent' => 100, 'color' => 'pink', 'icon' => 'fa fa-cube', 'access' => array(1, 2)),
//            'invoice' => array('title' => 'فاکتورها', 'count' => $invoice, 'percent' => 100, 'color' => 'primary', 'icon' => 'fa fa-shopping-cart', 'access' => array(1, 2)),
//            'customer' => array('title' => 'مشتریان', 'count' => $customer, 'percent' => 100, 'color' => 'warning', 'icon' => 'fa fa-user-secret', 'access' => array(1, 2)),
        );

        return view('panel.dashboard', array('block_info' => $block_info));
    }
}
