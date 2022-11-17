<?php

namespace App\BogPay;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Inertia\Inertia;



class BogPaymentController extends Controller
{
    //
    private $bog_pay;

    private $client_id = '14722';

    private $secret_key = '4cffd65bc65f529cec4f7fcfb25d4d98';



    public function __construct(){
        $this->bog_pay = new BogPay($this->client_id, $this->secret_key);



        //dd($this->rate);
    }


    public function make_order($order_id,$total){

        $locale = 0;
        if(app()->getLocale() !== 'ge') $locale = 1;

        $response = $this->bog_pay->make_order(
            1,
            'https://bunkeri1.ge/' . app()->getLocale() . '/payments/bog/status?order_id='.$order_id,
            [['currency_code' => 'GEL', 'value' => $total]],
            0,
            [],
            $locale,
            $order_id,
            false
        );
        $data = $response->getContents();

        //dd($data);

        $data = json_decode($data,true);

        Order::where('id', '=', $order_id)->update(['transaction_id' => $data['order_id'],'payment_hash'=> $data['payment_hash']]);
        //dd($data);
        return Inertia::location($data['links'][1]['href']);
    }


}
