<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /* for host */
//        $this->app->bind('path.public', function() {
//            return realpath(base_path().'/../public_html');
//        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //compose all the views....
        Schema::defaultStringLength(191);
        view()->composer('*', function ($view) {
            $block_main_menu = array();
            $block_profile_menu = array(
                'change_password' => array('title' => 'تغییر کلمه عبور', 'href' => '', 'icon-type' => 'icon', 'name' => 'md md-vpn-key', 'row-type' => 'single', 'access' => array(0)),
                'setting' => array('title' => 'تنظیمات', 'href' => '/setting', 'icon-type' => 'icon', 'name' => 'md ion-ios7-cog', 'row-type' => 'single', 'access' => array(0)),
            );
            if (isset(Auth::user()->roleid)) {
                $permissions = \App\Permission::where('roleid', Auth::user()->roleid)->where('show', true)->pluck('tabid')->toArray();
                $block_main_menu = \App\Menu::with('item_menu')->get();
                /* remove menu if user dont have permission */
                foreach ($block_main_menu as $key => $item_menu) {
                    if ($item_menu->tabid) {
                        if (!in_array($item_menu->tabid, $permissions)) {
                            /* remove level 1 menu */
                            unset($block_main_menu[$key]);
                        }
                    } else {
                        foreach ($item_menu->item_menu as $subkey => $subitem_menu) {
                            if ($subitem_menu->tabid) {
                                if (!in_array($subitem_menu->tabid, $permissions)) {
                                    /* remove level 2 menu */
                                    unset($block_main_menu[$key]->item_menu[$subkey]);
                                }
                            }
                        }
                    }
                }
            }

            //...with this variable
            View::share('menu', array('main_menu' => $block_main_menu, 'profile' => $block_profile_menu));
        });
    }
}
