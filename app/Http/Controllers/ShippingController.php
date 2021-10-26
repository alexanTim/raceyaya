<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class ShippingController extends Controller
{
    // enable or disable 
    public function enable_disable(Request $f)
    {      
        $event_id = (int) $f->input('event_id');
        $is_shop_enable = ( $f->input('enable') == 'true' ) ? 1 : 0;

        /*
         * TBL ORGANIZER EVENT 
         */
        DB::table('tbl_organizer_event')
            ->where('user_id', Auth::user()->id)
            ->where('id', $event_id)->update([
                'is_shipping_enable' => $is_shop_enable
            ]);

        $html = array('Shipping status updated');

        return response()->json( $html );
    }
}
