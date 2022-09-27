<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ApiController extends Controller
{

public function get_stock_details(Request $request)
    {
        dd($request);
        
            return response()->json([
            	"error" => array('File Not Found')
            ],404);
        }
    }

  }