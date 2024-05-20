<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use App\Models\Order;

class ShippingCostCalculate extends Model
{
    use HasFactory;

    public static function getEasyParsals($send_code, $send_state, $send_country, $cartcode){

		//dd($send_code, $send_state, $send_country, $cartcode);
        // calculate total weight
        $total_weight = Cart::where('code', $cartcode)->where('shippingfree', 'N')->sum('weight');
		$country = Country::where('id', $send_country)->limit(1)->first();
		if($send_country == '136'){
			$state1 = State::where('id', $send_state)->limit(1)->first();
			$state = $state1->code;
		}
		else{
			$state = $send_state;
		}
		
       
		if(env('EASY_PARSAL_MODE') == 'LIVE'){
			$api = env('EASY_PARSAL_LIVE_API');
			$urllink = 'https://connect.easyparcel.my/?ac=';
		}
		else{
			$api = env('EASY_PARSAL_SANDBOX_API');
			$urllink = 'https://demo.connect.easyparcel.my/?ac=';

		}
		
		$domain = $urllink;
		$action = "EPRateCheckingBulk";
			$postparam = array(
				'api'	=> $api,
				'bulk'	=> array(
					array(
						'pick_code'	=> '13700',
						'pick_state'	=> 'png',
						'pick_country'	=> 'MY',
						'send_code'	=>  $send_code,
						'send_state'	=> $state,
						'send_country'	=> $country->code,
						'weight'	=> $total_weight,
						'width'	=> '0',
						'length'	=> '0',
						'height'	=> '0',
						'date_coll'	=> date('Y-m-d'),
					),
				),
				'exclude_fields'	=> array(
					'rates.*.pickup_point',
				)
			);

			$url = $domain.$action;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postparam));
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			ob_start(); 
			$return = curl_exec($ch);
			ob_end_clean();
			curl_close($ch);
			$array1 =  json_decode($return);
			// dd($array1);
            // $pointid = $array1->result[0]->pgeon_point->Sender_point[0]->point_id;
            $pointid = 'Null';
            //dd($array1->result[0]->pgeon_point->Sender_point[0]->point_id);
           
           $data ='';
            foreach($array1->result[0]->rates as $item){
				if($country->code == 'MY'){
					// DHL= EP-CR0C pos Raju = EP-CR0A
					if($item->courier_id == 'EP-CR0C' || $item->courier_id == 'EP-CR0A'){
						$data .= "
						
						<option value='".$item->service_id."?".$item->shipment_price."?".$item->courier_name."?".$item->delivery."?".$item->courier_logo."?".$pointid."'>".$item->service_name."@MYR".$item->shipment_price."</option>";
						 }
					
				}
				elseif($country->code =='SG'){
					// if($item->courier_id == 'EP-CR0AL'){
						$data .= "
						
						<option value='".$item->service_id."?".$item->shipment_price."?".$item->courier_name."?".$item->delivery."?".$item->courier_logo."?".$pointid."'>".$item->service_name."@MYR".$item->shipment_price."</option>";
						//  }
				}
				else{
					
						$data .= "
						
						<option value='".$item->service_id."?".$item->shipment_price."?".$item->courier_name."?".$item->delivery."?".$item->courier_logo."?".$pointid."'>".$item->service_name."@MYR".$item->shipment_price."</option>";
						
				}
            }
            return $data;
			// dd($json);
    }

public static function getManageOrder($request){
	 // dd($request->all());
	
	// calculate total weight
		$order = Order::where('id', $request->orderid)->limit(1)->first();
        $total_weight = Cart::where('code', $order->code)->sum('weight');
		$receiver_country = Country::where('name', $request->country)->limit(1)->first();
		if($request->country == '136'){
			$state1 = State::where('name', $request->state)->limit(1)->first();
			$state = $state1->code;
		}
		else{
			$state = $request->state;
		}
		
		$receiver_name = $request->name;
		$receiver_address = $request->address;
		$receiver_address1 = $request->address1;
		$receiver_postalcode = $request->postalcode;
		$receiver_mobile = $request->mobile;
		$receiver_email = $request->email;
		if(env('EASY_PARSAL_MODE') == 'LIVE'){
			$api = env('EASY_PARSAL_LIVE_API');
			$urllink = 'https://connect.easyparcel.my/?ac=';
		}
		else{
			$api = env('EASY_PARSAL_SANDBOX_API');
			$urllink = 'https://demo.connect.easyparcel.my/?ac=';

		}
		
		$domain = $urllink;

$action = "EPSubmitOrderBulk";
$postparam = array(
'api'	=> $api,
'bulk'	=> array(
array(
'weight'	=> $total_weight,
'width'	=> '1',
'length'	=> '1',
'height'	=> '1',
'content'	=> 'Parcel',
'value'	=> $order->grandtotal,
'service_id'	=> $order->service_id,
'pick_point'	=> '',
'pick_name'	=> 'Ramya',
'pick_company'	=> 'Ritz Enchantress Sdn Bhd',
'pick_contact'	=> '0123742084',
'pick_mobile'	=> '0124366912',
'pick_addr1'	=> 'The CEO, Bukit Jambul, 11950 Bayan Lepas',
'pick_addr2'	=> 'Pulau Pinang, Malaysia',
'pick_addr3'	=> '',
'pick_addr4'	=> '',
'pick_city'	=> 'Bayan Lepas',
'pick_state'	=> 'png',
'pick_code'	=> '11950',
'pick_country'	=> 'MY',
'send_point'	=> '',
'send_name'	=> $receiver_name,
'send_company'	=> '',
'send_contact'	=> $receiver_mobile,
'send_mobile'	=> $receiver_mobile,
'send_addr1'	=> $receiver_address,
'send_addr2'	=> $receiver_address1,
'send_addr3'	=> '',
'send_addr4'	=> '',
'send_city'	=> $order->receiver_city,
'send_state'	=> $state,
'send_code'	=> $receiver_postalcode,
'send_country'	=> $receiver_country->code,
'collect_date'	=> $request->collectiondate,
'sms'	=> '0',
'send_email'	=> $receiver_email,
'hs_code'	=> 'yshs_code',
'REQ_ID'	=> 'shipping#'.$order->id,
'reference'	=> $order->code.'-'.$order->id,
),
),
);

$url = $domain.$action;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postparam));
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

ob_start(); 
$return = curl_exec($ch);
ob_end_clean();
curl_close($ch);

$json = json_decode($return);
return $json;
}
	public static function MakeAPayment($order_number){
		if(env('EASY_PARSAL_MODE') == 'LIVE'){
			$api = env('EASY_PARSAL_LIVE_API');
			$urllink = 'https://connect.easyparcel.my/?ac=';
		}
		else{
			$api = env('EASY_PARSAL_SANDBOX_API');
			$urllink = 'https://demo.connect.easyparcel.my/?ac=';

		}
		
		$domain = $urllink;

		$action = "EPPayOrderBulk";
		$postparam = array(
		'api'	=> $api,
		'bulk'	=> array(
		array(
		'order_no'	=> $order_number,
		),
		),
		);

		$url = $domain.$action;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postparam));
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		ob_start(); 
		$return = curl_exec($ch);
		ob_end_clean();
		curl_close($ch);

		$json2= json_decode($return);
		//dd($json2->result[0]);
		return $json2;
	}
}
