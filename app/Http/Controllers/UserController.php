<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;
use App\Models\StockDetails;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserController extends Controller
{

  
  public function getStockData(Request $request)
    {
    	
    	
    		if ($request->has('stock') && $request->get('stock')!=null) {
                $symbol = $request->get('stock');
		    	$json = file_get_contents('https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol='.$symbol.'&apikey=UFUZA7NNDDHXZKI9');

				$data = json_decode($json,true);
				
				if($data!=null && $data['Global Quote'])
				{
					$data = $data['Global Quote'];
					$data = array_values($data);
					//dd($data);
					
					$stock = new StockDetails();
					$stock->symbol = $data[0];
					$stock->high = $data[2];
					$stock->low = $data[3];
					$stock->price = $data[4];
					$stock->user_id = auth()->user()->id;
					$stock->save();

				}

				return redirect()->back()->with(['data'=>$data]);
				/*print_r($data);
				exit;*/
			}

    }

}