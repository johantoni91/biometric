<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDO;

class PaginationController extends Controller
{
    function pagination($view, $link)
    {
        return view($view, [
            'data' => $view,
            'view' => $link
        ]);
    }
}
