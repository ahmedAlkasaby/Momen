<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\MainController;

class WishlistController extends MainController
{
    /**
     * Handle the incoming request.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setClass('wishlists');
    }
    public function index()
    {
        $wishlists = Wishlist::paginate($this->perPage);
        return view("admin.wishlists.index", compact('wishlists'));
    }
}
