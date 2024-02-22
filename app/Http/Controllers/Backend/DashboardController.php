<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use GuzzleHttp\Client;

class DashboardController extends Controller
{
    public $user;




    public function index()
    {
     
        return view('backend.pages.dashboard.index');
    }
}
