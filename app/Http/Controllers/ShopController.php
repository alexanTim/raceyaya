<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{ 
    // enable or disable 
    public function enable_disable(Request $f)
    {      
        $event_id = (int) $f->input('event_id');
        $is_shop_enable = ( $f->input('enable') == 'true' ) ? 1 : 0;

        DB::table('tbl_organizer_event')->where('user_id', Auth::user()->id)->where('id', $event_id)->update([
            'is_shop_enable' => $is_shop_enable
        ]);

        $html = array('Shop status updated');
        return response()->json( $html );
    }

    public function updateColor(){
        $colorid = $_POST['id'];
        $session_id = $_POST['session_id'];

        DB::table('tbl_shop_color')
            ->where('id', $_POST['id'] )      
            ->where('user_id', Auth::user()->id )                          
            ->update([
                'color_name' => $_POST['color_name']
            ]);
    }
    public function removeentry(Request $cc){

        try{
            // remove the shop color 
            DB::table('tbl_shop_color')
            ->where('id', $_GET['id'] )      
            ->where('user_id', Auth::user()->id )
            ->where('item_session_id' , $cc->input('item_session_id'))                          
            ->where('session_id' , $cc->input('session_id') )->delete();

            // remove the size as well
            DB::table('tbl_shop_sizes')
                ->where('color_id', $_GET['id'] )->delete();

        } catch (\Exception $e) {

            return $e->getMessage();
        }
      

        $get_result  = DB::table('tbl_shop_color')
        ->where('user_id', Auth::user()->id )   
        ->where('item_session_id' , $cc->input('item_session_id'))                            
        ->where('session_id' , $cc->input('session_id') )->get();
            $html = '';
            if( count($get_result) > 0)
            {
                foreach($get_result as $v){
                    $nosize = 0;
                    $pink_no_size = '';
                    $getcolor  = DB::table('tbl_shop_sizes')
                    ->where('tbl_shop_sizes.color_id',$v->id ) 
                    ->get();

                        if(count($getcolor)==0){
                            $nosize = 1;
                            $pink_no_size = ' pink_no_size';
                        }  
                    $html .='<div  x-no-size="'.$nosize.'" xcolor="'.$v->color_name.'" class="wrapper_item'.$pink_no_size.'" xid="'. $v->id .'" style="background: #eee;padding: 9px;">
                                <input type="text" xid="'. $v->id .'" value="'.$v->color_name.'" xcolor="'.$v->color_name.'" class="color_name_element  form-control" style="cursor:pointer;font-size:12px;display: inline-block;width: 75%;border: ;"> 
                                <span xid="'. $v->id .'" xcolor="'.$v->color_name.'" class="fa fa-trash"></span> <span><i style="display:none;" class="fa fa-spinner fa-spin spinner_xid_'. $v->id .'""></i></span>
                            </div>';
                }
                $status = 1;
            }  else{
                // walay sulod then update status to = 0
                $status = 0;
            } 

            return response()->json( array('status'=>$status,'html'=>$html));

    }

    /**
     *  cREATE NEW COLOR or variant name
     */
    public function insertColorattribute()
    {   
        $lastID = '';        
        if(isset($_GET['id'])){
        } else 
        {
            $get_result  = DB::table('tbl_product_variant')
                        ->where('user_id', Auth::user()->id )
                        ->where( 'variant_name' ,  $_POST['color'])
                        ->where( 'item_session_id' ,  $_POST['item_session_id'])
                        ->where('session_id' ,  $_POST['session_id'] )->get();                        
            
            if( count($get_result) > 0){
                return response()->json( array('html'=>'No duplicate'));
            }else{
                        /*
                            DB::table('tbl_shop_color')->insert([
                            'color_name'  =>  $cc->input('color'),
                            'session_id'  =>  $cc->input('session_id'),
                            'event_id'    =>  $cc->input('event_id'),
                            'product_id'  =>  $cc->input('product_id'),
                            'user_id'     =>  Auth::user()->id ,
                            'item_session_id' => $cc->input('item_session_id')        
                            ]);
                        */
                                                            
                        DB::table('tbl_product_variant')->insert([
                                        'variant_name'    =>   $_POST['color'],
                                        'session_id'      =>   $_POST['session_id'],                              
                                        'product_id'      =>   $_POST['product_id'],
                                        'user_id'         =>   Auth::user()->id ,
                                        'item_session_id' =>   $_POST['item_session_id']        
                                    ]);

                        $lastID  = DB::getPdo()->lastInsertId();
                        
                        $get_result  = DB::table('tbl_product_variant')                                       
                                        ->where('tbl_product_variant.user_id', Auth::user()->id )  
                                        ->where('tbl_product_variant.item_session_id' ,  $_POST['item_session_id'] )                        
                                        ->where('tbl_product_variant.session_id' ,  $_POST['session_id'] )->get();
                        
                        $html = '';

                        if( count($get_result) > 0)
                        {                              
                            /*$count = 0;  

                            foreach($get_result as $v)
                            {                            
                                if($count==0){
                                // $html .='<span style="color:#222;display: block;font-size: 13px;background: #ddd;padding: 12px;">Click color name to add size and qty</span>';
                                }
                                /*
                                    $nosize = 0;
                                    $pink_no_size = '';
                                    $getcolor  = DB::table('tbl_shop_sizes')
                                                ->where('tbl_shop_sizes.color_id',$v->id ) 
                                                ->get();
                                    if(count($getcolor)==0){
                                        $nosize = 1;
                                        $pink_no_size = ' pink_no_size';
                                    } 
                                $html .='<tr><td>'.$v->variant_name.'</td><td><div  xvariant_name="'.$v->variant_name.'" class="wrapper_item" xid="'. $v->id .'" style="background: #eee;padding: 9px;">
                                            <input type="text" xid="'. $v->id .'" value="'.''.'" xvariant_name="'.$v->variant_name.'" class="color_name_element  form-control" style="cursor:pointer;font-size:12px;display: inline-block;width: 75%;border: ;"> 
                                            <span style="display:none;" xid="'. $v->id .'" xvariant_name="'.$v->variant_name.'" class="fa fa-trash"> </span><span><i style="display:none;" class="fa fa-spinner fa-spin spinner_xid_'. $v->id .'""></i></span>
                                        </div></td></tr>';
                                $count++; 
                            }*/
                            
                            $html ='<tr><td>'.$_POST['color'].'</td><td><div  xvariant_name="'. $_POST['color'] .'" class="wrapper_item" xid="'. $lastID .'" style="background: #eee;padding: 9px;">
                                        <input type="text" xid="'. $lastID .'" value="'.''.'" name="variant['. $lastID.']['.str_replace(" ",'_',$_POST['color']).']" xvariant_name="'.$_POST['color'].'" class="color_name_element  form-control variant_option" style="cursor:pointer;font-size:12px;display: inline-block;width: 75%;border: ;"> 
                                        <span style="display:none;" xid="'. $lastID .'" xvariant_name="'.$_POST['color'].'" class="fa fa-trash"> </span><span><i style="display:none;" class="fa fa-spinner fa-spin spinner_xid_'. $lastID .'""></i></span>
                                        </div></td></tr>';                            
                        }
                        return response()->json( array('lastid'=>$lastID,'html'=>$html));
                }
        }
    }

    public function getshopProductAttribute(){

    }

    public function updateColorattribute(){

    }

    public function getSizeQuantity(){
        $color_id = $_GET['id'];
        $session_id = $_GET['session_id'];
        $html = '';

        $color_result = DB::table('tbl_shop_sizes')->where('color_id',$color_id)->get();

        $is_empty = 1;
        if( count($color_result) > 0){
            $count = 0;
            $size  = '';
            $qty   = '';
            $is_empty = 0;
            foreach($color_result as $v)
            {
                if($count==0){
                    $size ='<i style="font-size:12px;">Size Name</i>';
                    $qty ='<i style="font-size:12px;">Qty</i>';
                    $style = 'padding-top: 11px;padding-left: 9px;position: relative;top: 22px;';
                }else{
                    $size ='';
                    $qty  ='';
                    $style = 'padding-top: 11px;padding-left: 9px;position: relative;top: 0px;';
                }

                $html .= '<div class="row" style="margin:12px; width:100% ; display:flex">
                                <div class="size_div" style="width:40%">   
                                     '.$size.'                                                                    
                                    <input type="text" style="background:#fff;width: 100%;"
                                     name="input_size[]" maxlength ="15" xinput="size"  value="'.$v->size_name.'" class="input_size form-control">                         
                                </div>
                                <div style="width:29%;" class="qty_div">   
                                     '.$qty.'                                              
                                    <input type="text" xinput="qty" value="'.$v->qty.'"  name="input_qty[]" style="background:#fff;" class="qty form-control">
                                </div>
                            <div class=""> 
                                <span x-id="'.$v->id.'"  x-color-id="'.$color_id.'" style="'.$style.'" class="fa fa-trash _remove_element_"></span>    
                            </div>
                     </div>';
                    $count++;
            }

            $html .='<div class="row inset_append  mb-4" style="margin-left:15px;">
                        <div class="" xuse="color:hover:#b2b2b2">    
                        <span class="saving_attribute" style="display:none;" ><i class="fa fa-spinner fa-spin spinner"></i></span>              
                        <div style="margin-bottom:1px;"><button style="width:100%" type="button" class="btn btn-primary save_attributes_ajax">Save Attribute</button></div>
                        <div><button style="width:100%" type="button" class="btn btn-primary add_row_attributes">Add Row</button></div>
               
                            </div> 
                    </div>';
        }else{
            $html .= '<div class="row" style="margin:12px; width:100% ; display:flex">
                                <div class="size_div" style="width:40%">   
                                     <i style="font-size:12px;">Size Name</i>                                                                    
                                    <input type="text" style="background:#fff;width: 100%;"
                                     name="input_size[]"  maxlength ="15"  xinput="size" class="input_size form-control">                         
                                </div>
                                <div style="width:29%;" class="qty_div">   
                                    <i style="font-size:12px;">Qty</i>                                                  
                                    <input type="text" xinput="qty"  name="input_qty[]" style="background:#fff;" class="input_qty form-control">
                                </div>
                            <div class=""> 
                                <span style="padding-top: 11px;padding-left: 9px;position: relative;top: 22px;" class="fa fa-trash"></span>    
                            </div>
                     </div>                  
                    <div class="row inset_append mb-4" style="margin-left:0px;">
                        <div class="col-md-12 col-sm-4" xuse="color:hover:#b2b2b2">   
                           <span class="saving_attribute" style="display:none;" ><i class="fa fa-spinner fa-spin spinner"></i></span>                  
                           <div style="margin-bottom:1px;"><button style="width:100%" type="button" class="btn btn-primary save_attributes_ajax">Save Attribute</button></div>
                           <div><button style="width:100%" type="button" class="btn btn-primary add_row_attributes">Add Row</button></div>
                        </div> 
                    </div>
                    ';
        }
        return response()->json(array('is_empty'=>$is_empty,'html'=>$html));
    }

    public function savesizesqty(Request $cc){
        $input = array();
        $table = 'tbl_shop_sizes';
        
        DB::table('tbl_shop_sizes')->where('color_id',  $cc->input('color_id'))->delete();

        foreach($_POST['input_size'] as $key => $v){
            $input[$key] = array( $v, $_POST['input_qty'][$key] );
            DB::table('tbl_shop_sizes')->insert([
                'color_id' =>  $cc->input('color_id'),
                'size_name'=>  $v,
                'qty'      =>  $_POST['input_qty'][$key],                 
            ]);
        }
        return response()->json( array('html'=>$input));       
    }

    /**
     *   Remove size and Qty
     */
    public function removesizeQty(Request $c){
        $colorid = $c->input('xcolor_id');
        $xid     = $c->input('xid');        
        
        
        DB::table('tbl_shop_sizes')->where('id', $xid)->where('color_id', $colorid)->delete();

        if( isset($_POST['xcolor_id'])){
           $get_shop = DB::table('tbl_shop_sizes')->where('color_id', $colorid)->get();
           if(count($get_shop) == 0){
               return response()->json(array('is_empty'=>1));
           }else{
            return response()->json(array('is_empty'=>0));
           }
        }
    }
    /* GET Product by ID , whe image
     * GET Product by ID , whe image 
     */
    public function getProductById()
    {
        $id = $_GET['id'];
        $array = array();
        $color = array();

        $ul         = '<i>--Empty--</i>';           
        $inner_div  = '';
        $GET_ITEM_SESSION_ID = 0;

        $is_product_has_variant = 0;

        $user_id = Auth::user();
        
        $get_all_products = DB::table('tbl_products')->where('id', $id)->get();   
        
        if( count($get_all_products)>0)
        {
            foreach($get_all_products as $v)
            {
                $array=  $v;
                $is_product_has_variant = $v->is_product_has_variant;
            }
        } 
        
        $html_color = '';
        $getallvariants = DB::table('tbl_product_variant')
                            ->join( 'tbl_product_variant_options',
                                    'tbl_product_variant.id','=','tbl_product_variant_options.variant_id')
                            ->where('tbl_product_variant.user_id',$user_id->id)
                            ->where('tbl_product_variant.product_id',$id)
                            ->orderBy('tbl_product_variant.id','asc')
                            ->get();    

        $html_edit = ''; 
        $li = '';  
        
        $option_session = array();        

        if( count($getallvariants) )
        {
            foreach($getallvariants as $variants){
                $GET_ITEM_SESSION_ID = $variants->item_session_id;

                /*
                $html_edit .='<tr><td>'.$variants->variant_name.'</td><td><div xvariant_name="test" class="wrapper_item" xid="'.$variants->variant_id.'" style="background: #eee;padding: 9px;">
                                	<input type="text" xid="'.$variants->variant_id.'" value="" name="variant['.$variants->variant_id.']['.$variants->variant_name.']" xvariant_name="test" class="color_name_element  form-control variant_option" style="cursor:pointer;font-size:12px;display: inline-block;width: 75%;border: ;"> 
                                    <span style="display:none;" xid="720" xvariant_name="test" class="fa fa-trash"> </span><span><i style="display:none;" class="fa fa-spinner fa-spin spinner_xid_720" "=""></i></span>
                              </div></td></tr>';
                */

                $option_session_id[$variants->option_session_id][] = array(
                                                                            'id' => $variants->id,
                                                                            'product_id' => $variants->product_id,
                                                                            'variant_name' => $variants->variant_name,
                                                                            'item_session_id' => $variants->item_session_id,
                                                                            'user_id' => $variants->user_id,
                                                                            'session_id' => $variants->session_id,
                                                                            //'is_has_variant' => $variants->is_has_variant,
                                                                            'variant_id' => $variants->variant_id,
                                                                            'content' => $variants->content,
                                                                            'option_session_id' => $variants->option_session_id,
                                                                          );
            }

            $ul         = '';           
            $inner_div  = ''; //

            foreach ($option_session_id as $ccc)
            {  

                $html_nani_html = '';
                $option_sessin_id = '';  
                $inner_div = '';            
                for($i=0;$i < sizeof($ccc);$i++)
                {
                    $html_nani_html .= $ccc[$i]['content'].'/';
                    $option_sessin_id = $ccc[$i]['option_session_id'];

                    $inner_div .='<tr><td>'.$ccc[$i]['variant_name'].'</td><td><div xvariant_name="'.$ccc[$i]['variant_name'].'" class="wrapper_item" xid="'.$ccc[$i]['id'].'" style="background: #eee;padding: 9px;">
                                    <input type="text" xid="'.$ccc[$i]['id'].'" value="" name="variant['.$ccc[$i]['id'].']['.$ccc[$i]['variant_name'].']" xvariant_name="test" class="color_name_element  form-control variant_option" style="cursor:pointer;font-size:12px;display: inline-block;width: 75%;border: ;"> 
                                    <span style="display:none;" xid="720" xvariant_name="test" class="fa fa-trash"> </span><span><i style="display:none;" class="fa fa-spinner fa-spin spinner_xid_720" "=""></i></span>
                                  </div></td></tr>';
                }

                $name = substr($html_nani_html, 0, -1);
                $ul .= '<li xoption_session = "'.$option_sessin_id.'"><a class="__access_data_click__" xoption_session = "'.$option_sessin_id.'" href="#">'.$name.'</a></li>';
                           
            }

            $inner_div = '<table>'.$inner_div.'<tr class="button_variant"><td></td><td><div style="display:block;float:left; padding-left:12px;background: #F2F2F2 !important;color: #000;"><span style="margin-top: 9px;font-size: 12px;padding-right: 8px;">Qty:</span><span><input type="text" style="padding:10px;width: 23%;" class="qty_checkbox form-control" name="qty_checkbox"></span></div></td></tr>
                                <tr class="button_variant">
                                    <td></td>
                                    <td>
                                        <button style="margin-left: 12px;margin-top:15px;width:100%;float:left;" xoption="s3x625gjqztkrfm1vjlioyw7n4yprr" xmode="edit" class="btn btn-primary save_button_variant" type="button">Add</button>
                                    </td>
                                </tr>
                            </table>';
            $ul = '<ul style="padding-left:15px">'.$ul.'</ul>';           

            $html_edit = '<form style="" id="new_form_submit_now" class="new_form_submit_now"><table>'.$html_edit.'</table></form>';
        }

        $array = array(
                       'SIDE_HTML' => $ul,
                       'PRODUCTS'  => $array,
                       'COLORS'    => $html_edit,
                       'item_session_id'=> $GET_ITEM_SESSION_ID,
                       'variant_options' => $inner_div,
                       'is_product_has_variant' =>$is_product_has_variant
                      );

        return response()->json($array);
    }

    /**
     *   Tawagon ni sya para mag deduct ug qty sa product after ang user nag checkout sa front-end
     */
    public function callbackDeductQty(){
        // NEED THE ARRAY OF ELEMENTS ID TO DEDUCT THE QTY
    }

    /**
     *   Update Product without image because the dropzone wont submit if no queue image
     */
    public function shop_product_update(Request $c){          
     
        if($_POST['is_has_variants']=='true'){
           
            $product_has_variants = 1;
           
        }else{
            $product_has_variants = 0; 
        }

        DB::table('tbl_products')
        ->where('id',$c->input('id'))
        ->where('session_id',$c->input('session_id') )
        ->update([
                    'product_name'  => $c->input('shop_product_name'),
                    'product_stock' => $c->input('shop_product_stock'),
                    'product_price' => $c->input('shop_product_price'),
                    'description'   => $c->input('product_description'),
                    'is_product_has_variant' => $product_has_variants,
                    'is_mandatory' => $c->input('is_mandatory')
                 ]);
    }

    /**
     * Avaliable qty for the item in shop
     */
    public function getremaining(){
        $get_shop = DB::table('tbl_shop_sizes')->where('id', $_GET['size_id'])->where('color_id', $_GET['colorid'])->get();

        $total_qty = 0 ;
        $total_remaining_qty = 0;

        if( count($get_shop) > 0 )
        {
            foreach( $get_shop as $val )
            {                
                $total_remaining_qty = (int)$val->qty - (int)$val->sold;
                $total_qty = (int)$val->qty ;
            }

            return response()->json(array('remaining'=>$total_remaining_qty, 'overall-qty'=>$total_qty));
        }

    }

    /**
     *  Save shop new variant version
     */
    public function save_new_variant_option(){
       
        if($_POST['mode'] != 'edit')
        {
                $getmode_type = $_POST['mode'];

                $gen = str_shuffle('fgjijklmno1234567pqrstyvwxyz');
                $user_id = Auth::user()->id;

                $checkifexist = DB::table('tbl_product_variant')
                                ->where('item_session_id',$_POST['item_session_id'])
                                ->where('session_id',$_POST['session_id'])
                                ->get();        
                

                // Check if Exist Check One by one
                $naay_wala_nag_exist = 0;
                
                if( count($checkifexist) > 0) 
                {

                    foreach($checkifexist as $vv)
                    {  

                        $key_variant = $vv->id;

                        foreach($_POST['variant'] as $key => $values)
                        {

                            foreach($values as $v)
                            {

                                $value = $v; 

                                if($key !=0)
                                {

                                        $check_variant = DB::table('tbl_product_variant_options')
                                        ->where('variant_id', $key)    
                                        ->where('content', $value)                                      
                                        ->where('item_session_id', $_POST['item_session_id'])
                                        ->where('user_id', Auth::user()->id )
                                        ->get();

                                        if( count($check_variant) == 0 )
                                        {
                                            $naay_wala_nag_exist = 1;
                                            break;
                                        }

                                    }                                    

                                }
                            
                            }                
                        }
                }           

                // IF POST 
                if(!empty($_POST))
                {
                    if($naay_wala_nag_exist)
                    {               

                        foreach($_POST['variant'] as $key => $values){                               
                                foreach($values as $v){
                                    if($key !=0){
                                        DB::table('tbl_product_variant_options')->insert([
                                            'variant_id' => $key,
                                            'content'       => $v,
                                            'item_session_id'   => $_POST['item_session_id'],
                                            'option_session_id' => $gen,
                                            'session_id' => $_POST['session_id'] ,
                                            'user_id' => $user_id
                                        ]);
                                    }
                                }                
                        }

                        // Save qty 
                        if(isset($_POST['variant'][0]['qty'])){
                            $qty = ($_POST['variant'][0]['qty']);
                        }else{
                            $qty = $_POST['qty_checkbox'];
                        }
                        
                        // FOR MAXIMUM QUANTITY                        
                        DB::table('variant_option_inventory')->insert([
                                                                            'option_session_id' => $gen,
                                                                            'qty'               => $qty,
                                                                            'item_session_id'   => $_POST['item_session_id'],
                                                                            'session_id'        => $_POST['session_id'],
                                                                            'user_id' => $user_id                
                                                                    ]);
                        
                        
                        // get all options from    
                        $get_all_options = DB::table('tbl_product_variant')
                                            ->join( 'tbl_product_variant_options',
                                                    'tbl_product_variant.id',
                                                    '=',
                                                    'tbl_product_variant_options.variant_id'
                                                    )
                                            ->where('tbl_product_variant.item_session_id',$_POST['item_session_id'])        
                                            ->get(); 

                        if( count($get_all_options) > 0 )
                        {
                            $value_option = array(); 
                            foreach($get_all_options as $yy)
                            {
                                $value_option[$yy->option_session_id][] = array(
                                                                                    'id' => $yy->id,
                                                                                    'name' => $yy->content                                                                           
                                );
                            }
                            
                           /* $variant_list = '';
                        

                            foreach($value_option as $keyopton => $yyy){
                                $li = '';
                            foreach($yyy as $c)
                            {
                                $li .= ''.$c['name'].'/';                        
                            }

                            $variant_list .= '<li xoption-id="'.$keyopton.'" style="display:block;padding-top:3px;padding-bottom:3px;"><a xoption-id="'.$keyopton.'" href="#">'.$li.'</a></li>';
                            }*/

                            $variant_list = '';                       

                            foreach($value_option as $keyopton => $yyy)
                            {

                                $li = '';
                                foreach($yyy as $c)
                                {
                                    $li .= ''.$c['name'].'/';                        
                                }

                                $name = substr($li, 0, -1);

                                $variant_list .= '<li xoption_session = "'.$keyopton.'"><a class="__access_data_click__" xoption_session = "'.$keyopton.'" href="#">'.$name.'</a></li>';

                                //$variant_list .= '<li xoption-id="'.$keyopton.'" style="display:block;padding-top:3px;padding-bottom:3px;"><a xoption-id="'.$keyopton.'" href="#">'.$li.'</a></li>';
                            }


                        }

                        return response()->json(array('mode'=>'create','html'=>'success' , 'values'=>'<ul style="padding-left: 0px;">'.$variant_list.'</ul>'));
                    
                    }else {
                        return response()->json(array('html'=>'Duplicate try again'));
                    }
                }

        }else{
                
                $exoption = $_POST['xoption'];
                $checkifexist = DB::table('tbl_product_variant')
                              ->where('item_session_id',$_POST['item_session_id'])
                              ->where('session_id',$_POST['session_id']) 
                              ->where('product_id',$_POST['product_id'])                                 
                              ->get();        
                

                // Check if Exist Check One by one
                $naay_wala_nag_exist = 0;
                $naa =array();

                if( count($checkifexist) > 0) 
                {
                    foreach($checkifexist as $vv)
                    {  
                        $key_variant = $vv->id;

                        foreach($_POST['variant'] as $key => $values)
                        {       
                            if($key !=0)
                            {
                                $first =  array_key_first($values);
                                $newfirst = $values[$first];

                                $check_variant = DB::table('tbl_product_variant_options')
                                                 ->where('variant_id', $key)    
                                                 ->where('content', $newfirst)                                      
                                                 ->where('item_session_id', $_POST['item_session_id'])
                                                 ->where('user_id', Auth::user()->id )
                                                 ->where('option_session_id','<>',$exoption)
                                                 ->get();                                       
                                              
                                if( count($check_variant) == 0 )
                                {  
                                    $naay_wala_nag_exist = 1;
                                    break;

                                }else{                                   
                                }
                            }

                            }                
                        }
                }
                
                // IF POST 
                if(!empty($_POST))
                {                   
                    if($naay_wala_nag_exist)
                    {  
                        foreach($_POST['variant'] as $key => $valuess)
                        { 
                            $id = ''; 
                            $valueni = ''; 
                            $first = '';

                            $first      =  array_key_first($valuess);
                            $id         =  $valuess['id'];                                  
                            $valueni    =  $valuess[$first];                             
                            
                            if($key !=0)
                            {                                
                                DB::table('tbl_product_variant_options')
                                ->where('item_session_id',$_POST['item_session_id'])
                                 ->where('session_id',$_POST['session_id'])
                                ->where('option_session_id',$_POST['xoption'])
                                ->where( 'user_id', Auth::user()->id)
                                ->where( 'id', $id)                                          
                                ->update([
                                    // 'variant_id' => $key,
                                    'content'       => $valueni
                                    //'item_session_id'   => $_POST['item_session_id'],
                                    // 'option_session_id' => $gen,
                                    // 'session_id' => $_POST['session_id'] ,
                                    // 'user_id' => $user_id
                                ]);
                            }                                 
                                          
                        }
                      
                        // save qty                         
                        $qty = ($_POST['qty_checkbox']);

                        $qtycheck =  DB::table('variant_option_inventory')
                                    ->where('option_session_id',$_POST['xoption'])
                                    ->get();

                         if( count($qtycheck)>0){
                            DB::table('variant_option_inventory')
                            ->where('option_session_id',$_POST['xoption'])
                                                              ->update([
                                                                                //'option_session_id' => $gen,
                                                                                'qty'               => $qty
                                                                                //'item_session_id'   => $_POST['item_session_id'],
                                                                                //'session_id'        => $_POST['session_id'],
                                                                                //'user_id' => $user_id                
                                                                        ]);
                         }   else{
                            DB::table('variant_option_inventory')
                            ->where('option_session_id',$_POST['xoption'])
                                                              ->insert([
                                                                                'option_session_id' => $_POST['xoption'],
                                                                                'qty'               => $qty,
                                                                                'item_session_id'   => $_POST['item_session_id'],
                                                                                'session_id'        => $_POST['session_id'],
                                                                                'user_id' => Auth::user()->id                 
                                                                        ]);
                         }        
                       
                        // get all options from    
                        $get_all_options = DB::table('tbl_product_variant')
                                            ->join( 'tbl_product_variant_options',
                                                    'tbl_product_variant.id',
                                                    '=',
                                                    'tbl_product_variant_options.variant_id'
                                                    )
                                            ->where('tbl_product_variant.item_session_id',$_POST['item_session_id'])        
                                            ->get(); 

                        if( count($get_all_options) > 0 )
                        {
                            $value_option = array(); 
                            foreach($get_all_options as $yy)
                            {
                                $value_option[$yy->option_session_id][] = array(
                                                                                    'id' => $yy->id,
                                                                                    'name' => $yy->content                                                                           
                                );
                            }
                            
                            $variant_list = '';                       

                            foreach($value_option as $keyopton => $yyy)
                            {

                                $li = '';
                                foreach($yyy as $c)
                                {
                                    $li .= ''.$c['name'].'/';                        
                                }

                                $name = substr($li, 0, -1);

                                $variant_list .= '<li xoption_session = "'.$keyopton.'"><a class="__access_data_click__" xoption_session = "'.$keyopton.'" href="#">'.$name.'</a></li>';

                                //$variant_list .= '<li xoption-id="'.$keyopton.'" style="display:block;padding-top:3px;padding-bottom:3px;"><a xoption-id="'.$keyopton.'" href="#">'.$li.'</a></li>';
                            }

                        }

                        return response()->json(array('html'=>'success','mode'=>'edit' , 'values'=>'<ul style="padding-left: 0px;">'.$variant_list.'</ul>'));
                    
                    }else {
                        return response()->json(array('html'=>'Duplicate try again'));
                    }
                }
                //die('DIE OPTION EDIT HERE');

        }
             
    }

    /*
     *  Save Variant Default , wala gamita
     */
    public function save_variant_default()
    {

        $user_id = Auth::user()->id;

        $variant_default = array('color','size');
         
                /* tbl_product_variant clean first */             
                try {
                        DB::delete("DELETE t1,t2 FROM tbl_product_variant as t1
                                    INNER JOIN tbl_product_variant_options as t2 
                                    ON t1.id = t2.variant_id 
                                    where t1.product_id=0 and t2.user_id={$user_id}");
                    } catch (\Exception $e) 
                    {              
                        return $e->getMessage();
                    }

        /*
            Variant_option_inventory delete
         */

        DB::table('variant_option_inventory')
            ->where('option_session_id','')                
            ->where('user_id',$user_id)  
            ->delete();          
           
        foreach($variant_default as $v)
        {
           /* 
                DB::table('tbl_product_variant')->insert([
                    'variant_name'    => $v ,
                    'session_id'      => $_GET['session_id'],
                    'item_session_id' => $_GET['product_session_id'],
                    'user_id'         => $user_id
                ]);
            */
        }       
        
        // insert new qty       
        $getresult  = DB::table('tbl_product_variant')
                    ->where('item_session_id', $_GET['product_session_id'])
                    ->where('user_id', $user_id)
                    ->where('session_id', $_GET['session_id'])->get();
        
        $html = '';

        if( count($getresult) > 0)
        { 
            foreach ($getresult as $key => $value) 
            {
                $html .='<tr><td>'.$value->variant_name.'</td><td><div xvariant_name="'.$value->variant_name.'" class="wrapper_item" xid="'.$value->id.'" style="background: #eee;padding: 9px;">
                            <input type="text" xid="'.$value->id.'" value="" name="variant['.$value->id.']['.$value->variant_name.']'.'" xvariant_name="'.$value->variant_name.'" class="color_name_element  form-control variant_option" style="cursor:pointer;font-size:12px;display: inline-block;width: 75%;border: ;"> 
                            <span style="display:none;" xid="'.$value->id.'" xvariant_name="'.$value->variant_name.'" class="fa fa-trash"> </span><span><i style="display:none;" class="fa fa-spinner fa-spin spinner_xid_'.$value->id.'" "=""></i></span>
                     </div></td></tr>';
            }
                $html .='<tr><td>qty</td><td><div xvariant_name="qty" class="wrapper_item" xid="0" style="background: #eee;padding: 9px;">
                            <input type="text" xid="0" value="" name="variant[0][qty]" xvariant_name="qty" class="color_name_element  form-control variant_option" style="cursor:pointer;font-size:12px;display: inline-block;width: 75%;border: ;"> 
                            <span style="display:none;" xid="0" xvariant_name="qty" class="fa fa-trash"> </span><span><i style="display:none;" class="fa fa-spinner fa-spin spinner_xid_0" "=""></i></span>
                     </div></td></tr>';
                $html ='';
                $html = '<form style="display:none;" id="new_form_submit_now" class="new_form_submit_now"><table>'.$html.'<tr class="button_variant"><td></td><td><div style="display:block;float:left; padding-left:12px;background: #F2F2F2 !important;color: #000;"><span style="margin-top: 9px;font-size: 12px;padding-right: 8px;">Qty:</span><span><input type="text" style="padding:10px;width: 23%;" class="qty_checkbox form-control" name="qty_checkbox"/></span></div></td></tr>
                        <tr class="button_variant">
                            <td></td>
                            <td>
                                <button style="margin-left: 12px;margin-top:15px;float:left;" class="btn btn-primary save_button_variant" type="button">Add</button>
                            </td>
                        </tr>
                </table></form>';
        }

        $html = '<form style="display:none;" id="new_form_submit_now" class="new_form_submit_now"><table>'.$html.'<tr class="button_variant"><td></td><td><div style="display:block;float:left; padding-left:12px;background: #F2F2F2 !important;color: #000;"><span style="margin-top: 9px;font-size: 12px;padding-right: 8px;">Max Qty:</span><span><input type="text" style="padding:10px;width: 23%;" class="qty_checkbox form-control" name="variant[0][qty]"/></span></div></td></tr>
            <tr class="button_variant">
                <td></td>
                <td>
                    <button style="margin-left: 12px;margin-top:15px;float:left;" class="btn btn-primary save_button_variant" type="button">Add</button>
                </td>
            </tr>
        </table></form>';
        return response()->json(array('html'=>$html));
    }


    /*   front-end shop get variant qty when onchange select option
     *   New Variant Product
     */
    public function newvariantproduct()
    {         
        $wlaynakita       = false;       
        $array_commulated = array();
        $items            = array();
        $length           = sizeof($_POST['variant_option']);
        $pilakorek        = 0;

        $final_qty        = 0; //  For final qty

        $ass =  ($_POST['variant_option']);
       
        $result = array_filter($ass); 
        $leng   =  sizeof($result); // length of the options
        
        /*
            new variant query
        */

        $item_session_id = $_POST['item-session-id'];

        // Advance query para sa product options and variants
        $query = "SELECT COUNT(c.variant_id) AS num ,                   
                    c.option_session_id
                    FROM `tbl_product_variant_options` as c
                        right JOIN tbl_product_variant 
                        on c.variant_id = tbl_product_variant.id        
                        where c.content in ( select tbl_product_variant_options.content  
                        from tbl_product_variant_options inner JOIN tbl_product_variant
                        on tbl_product_variant_options.variant_id = tbl_product_variant.id ) and                         
                        c.item_session_id ='$item_session_id' GROUP by c.option_session_id HAVING num = $leng";

        $dbquery =  DB::select($query);
        $getItemsessionid = '';

        if( count($dbquery) > 0 ) 
        {       
            // WHY PARA MA ARRANGE ANG VARIABLE FROM 1 TO 5 ELEMENT     
            if($result)
            {
                $countni = 1;
                $array_  = array();
                foreach($result as $cc){
                    $array_[$countni] = $cc;
                    $countni++;
                }          
            }
         
            foreach($dbquery as $vv)
            {       
                if($leng==1){ // If isa lang ang option gi pili 
                    $qcc = "SELECT * FROM `tbl_product_variant_options`
                    WHERE (content = '$array_[1]' ) and 
                    tbl_product_variant_options.option_session_id = '$vv->option_session_id'";
                } else if($leng == 2) { // if 2 ang option gipili                    
                    $qcc = "SELECT * FROM `tbl_product_variant_options`
                    WHERE (content = '$array_[1]' or content = '$array_[2]' ) and 
                    tbl_product_variant_options.option_session_id = '$vv->option_session_id'";                   
                }else if($leng == 3){ // if 3 ang option gipili
                    $qcc = "SELECT * FROM `tbl_product_variant_options`
                    WHERE (content = '$array_[1]' or content = '$array_[2]' or content = '$array_[3]' ) and 
                    tbl_product_variant_options.option_session_id = '$vv->option_session_id'";  
                } else if($leng == 4){// if 4 option ang gipili 
                    $qcc = "SELECT * FROM `tbl_product_variant_options`
                    WHERE (content = '$array_[1]' or content = '$array_[2]' or content = '$array_[3]'  or content = '$array_[4]' ) and 
                    tbl_product_variant_options.option_session_id = '$vv->option_session_id'";  
                }else if($leng == 5){// if 5 ang option ang gipili 
                    $qcc = "SELECT * FROM `tbl_product_variant_options`
                    WHERE (content = '$array_[1]' or content = '$array_[2]' or content = '$array_[3]' or content = '$array_[4]' or content = '$array_[5]' ) and 
                    tbl_product_variant_options.option_session_id = '$vv->option_session_id'";  
                }
               
                $s = DB::select($qcc);
                if( count($s) == $leng ){               
                   foreach($s as $cs){
                        $getItemsessionid = $cs->option_session_id;
                   }
                }
            }
        }
        
        // IF DILI EMPTY it MEANs NAAY OPTION SESSION ID 
        if( $getItemsessionid != '' ){

            $GET_OPTION_SESSION_ID = $getItemsessionid;

            $qcc = "SELECT * FROM `variant_option_inventory` WHERE 
                    `option_session_id` = '$getItemsessionid' ORDER BY `id` ASC "; 

            $getqty = DB::select($qcc);

            if( count($getqty) > 0 ) {
               foreach($getqty as $tim)
               {
                    $final_qty = $tim->qty;                    
               }
            }        
           
        }
        
        // GET PRODUCT QTY FOR MAXIMUM QUANTITY 
        // DILI NA MAGAMIT KAY ANG QTY GIKUHA SA variant_option_inventory
        $qtynamaximum = 0;
        $getmaximumqty = DB::table('tbl_products')->where('id', $_POST['product_id'])->get();
        if( count($getmaximumqty) > 0){
            foreach($getmaximumqty as $v){
                $qtynamaximum = $v->product_stock;
            }
        }

        // GET ALL THE OPTION SESSION IDS GROUP BY DISTICT 
        /* $GET_DISTINCT = $singleline= DB::table('tbl_product_variant_options')
                                    ->select('option_session_id')
                                    ->distinct()
                                     ->where('tbl_product_variant_options.item_session_id',$_POST['item-session-id'])   
                                     ->get();
        if( count($GET_DISTINCT) > 0)
        {  
            $getalloption =array();
            foreach($GET_DISTINCT as $option_id)
            {
                $getalloption[] = $option_id->option_session_id;
            }            
            for($i=0; $i< sizeof($getalloption);$i++)
            {     
                $pilakorek  = 0;    
                foreach($_POST['variant_option'] as $key => $values)
                {                   
                    $singleline = DB::table('tbl_product_variant')
                                ->join('tbl_product_variant_options',
                                    'tbl_product_variant.id','=',
                                    'tbl_product_variant_options.variant_id')
                                ->where('tbl_product_variant.id',$key)    
                                ->where('tbl_product_variant.product_id',$_POST['product_id'])
                                ->where('tbl_product_variant_options.item_session_id',$_POST['item-session-id'])
                                ->where('tbl_product_variant_options.content',$values)
                                ->where('tbl_product_variant_options.option_session_id',$getalloption[$i])
                                ->get();
                    if(count($singleline)>0)
                    {
                         $pilakorek++; 
                    }
                }
                if( $pilakorek == $length ){
                     break;
                }
                $pilakorek = 0;
            }
        }
        // IF PILA KOREK 
        if( $pilakorek == $length )
        {
            foreach($singleline as $sisssion)
            {
                $GET_OPTION_SESSION_ID =  $sisssion->option_session_id;
            }            
            $qty = $qtynamaximum;           
        }else{
            $wlaynakita  = true;
        }
        $check_variantw =    DB::table('tbl_product_variant')                                   
                            ->join( 'tbl_product_variant_options as n',
                                'tbl_product_variant.id','=', 
                                'n.variant_id')
                            ->join( 'variant_option_inventory',
                                'n.option_session_id','=',
                                'variant_option_inventory.option_session_id')                             
                            ->where('tbl_product_variant.product_id',$_POST['product_id'])
                            ->whereIn('name',$items) 
                            ->where('tbl_product_variant.id',$key)
                            ->where('n.option_session_id','gpf5ysrkytm7wlv3nojjqx416iz2') 
                            ->where('n.item_session_id', $_POST['item-session-id'])
                            ->select('tbl_product_variant.*',
                                'n.id as option_id',
                                'n.variant_id',
                                'n.name',
                                'n.item_session_id',
                                'n.option_session_id',
                                'n.user_id',
                                'n.session_id',
                                'variant_option_inventory.qty')
                            ->get();
        if($wlaynakita)
        {
            return response()->json( array( 'option_session_id'=>'','success'=>0,'html'=>'') );
        }else
        {      
            $getqty = DB::table('variant_option_inventory')->where('option_session_id',$GET_OPTION_SESSION_ID)->get();
            if( count($getqty) > 0){
                foreach($getqty as $qtty){
                    $qty = $qtty->qty;
                }
            }
            return response()->json( array(
                                    'option_session_id'=> $GET_OPTION_SESSION_ID,
                                    'success'=> 1,
                                    'html'=> $qty)
                                   );
        }
        */

        if($final_qty == 0)
        {
            return response()->json( array( 'option_session_id'=>'','success'=>0,'html'=>'') );
        }else
        {    
            /*  
                $getqty = DB::table('variant_option_inventory')->where('option_session_id',$GET_OPTION_SESSION_ID)->get();
                if( count($getqty) > 0){
                    foreach($getqty as $qtty){
                        $qty = $qtty->qty;
                    }
                } 
            */           
            return response()->json( array(
                                            'option_session_id'=> $GET_OPTION_SESSION_ID,
                                            'success'=> 1,
                                            'html'=> $final_qty
                                          )
                                   );
        }
    }

    /**
     *  Get shop variants
     */
    public function getproductvariants()
    {     
        $user_id = Auth::user()->id;
        $xoption = $_GET['xoption'];

        $singleline = DB::table('tbl_product_variant')
                      ->join('tbl_product_variant_options',
                             'tbl_product_variant.id','=',
                             'tbl_product_variant_options.variant_id')
                      ->where('tbl_product_variant_options.option_session_id',$xoption)
                      ->orderBy('tbl_product_variant.id')
                      ->get();

        $html_edit = '';

        // GET THE QTY FROM variant_option_inventory
        $get_inventory = DB::table('variant_option_inventory')->where('option_session_id',$xoption)->get();
        $qty = 0; 

        if( count($get_inventory) > 0)
        {
            foreach($get_inventory as $a){
                $qty = $a->qty;
            }
        }

        if( count($singleline) > 0 )
        {
            foreach($singleline as $variants)
            {
                $option_session_id = $variants->option_session_id;
                $html_edit        .='<tr><td>'.$variants->variant_name.'</td><td><div xvariant_name="test" class="wrapper_item" xid="'.$variants->variant_id.'" style="background: #eee;padding: 9px;">
                                        <input type="text" xid="'.$variants->variant_id.'" value="'.$variants->content.'" name="variant['.$variants->variant_id.']['.$variants->variant_name.']" xvariant_name="test" class="color_name_element  form-control variant_option" style="cursor:pointer;font-size:12px;display: inline-block;width: 75%;border: ;"> 
                                        <input type="hidden" xid="'.$variants->variant_id.'" value="'.$variants->id.'" name="variant['.$variants->variant_id.'][id]" xvariant_name="test" class="color_name_element  form-control variant_option_hidden" style="cursor:pointer;font-size:12px;display: inline-block;width: 75%;border: ;"> 
                                        <input type="hidden" xid="'.$variants->variant_id.'" value="'.$variants->product_id.'" name="product_id" xvariant_name="test" class="color_name_element  form-control variant_option_hidden" style="cursor:pointer;font-size:12px;display: inline-block;width: 75%;border: ;"> 
                                         
                                        <span style="display:none;" xid="720" xvariant_name="test" class="fa fa-trash"> </span><span><i style="display:none;" class="fa fa-spinner fa-spin spinner_xid_720" "=""></i></span>
                                     </div></td></tr>';
            }

            $html_edit ='<table>'.$html_edit.'<tr class="button_variant"><td><button style="margin-top:4px;width:100%;float:left;" xoption="'.$option_session_id.'" xmode="edit" class="btn save_button_variant" type="button">Update</button><button style="margin-top:4px;width:100%;float:left;" xoption="'.$option_session_id.'" xmode="edit" class="btn save_button_variant_cancel" type="button">Cancel</button></td><td><div style="display:block;float:left; padding-left:12px;background: #F2F2F2 !important;color: #000;"><span style="margin-top: 9px;font-size: 12px;padding-right: 8px;">Qty:</span><span><input type="number" value="'.$qty.'" style="padding:10px;width: 41%;" class="qty_checkbox form-control" name="qty_checkbox"/></span></div></td></tr></table>';
        
        }
        return response()->json( array(                                       
                                        'html'=> $html_edit)
                                );
    }

    /**
     *  Set has product variants 
     *  Wala na gamita didto ni sa shop checkbox has variant
     */
    public function sethasvariants()
    {
       /* $user_id = Auth::user()->id;  
        
            $ischecked = $_POST['ischecked'];
            $event_id  = $_POST['event_id'];

            // TBL ORGANIZER EVENT
                DB::table('tbl_products')
                    ->where('user_id',$user_id)
                    ->where('id',$event_id)
                    ->update([
                                'is_product_has_variant' => $ischecked
                            ]); 
            // TBL ORGANIZER EVENT
        */
    }

    /**
     *  Shopped Pending Payments
     */
    public function getShoppedPendingPayment($ev)
    {
        $userid =  Auth::user()->id;
       
        $sql = "SELECT
                t1.event_id,
                t1.status as paymentstatus,
                t2.* ,
                t1.*,
                t3.*,
                t4.event_name
                FROM
                tbl_racer_registration t1
                INNER JOIN tbl_reg_event_cart_session t2
                    ON t1.id = t2.registration_id
                INNER JOIN tbl_products t3
                    ON t2.product_id = t3.id
                INNER JOIN tbl_organizer_event t4
                    ON t1.event_id = t4.id
                where t1.registered_racer_id = $userid and 
                t1.action_type = 'buy only' and 
                t1.payment_method_name = 'Bank Deposit' and 
                t1.event_id = $ev";

            $getuserstatus = DB::select($sql);
            $group_all_event_id = array();

            //echo 'This is a test';
            $html = '';
            foreach($getuserstatus as $values)
			{
				$group_all_event_id[$values->registration_id][] = $values ;
			}
				

            $all_products_wrapper = '';
			if(!empty($group_all_event_id)){
                $counterss = 0;
                
                $all_total = 0;
				foreach($group_all_event_id as $key => $val)
				{

					// GET ALL THE CATEGORY CURRENCY 
					$event_id = 0;                   
					$all_products = '';
					$totalLine = 0;
					$shop_currency = '';
                    $stagus = 0;
                    $submitted_fields = '';

					foreach($val as $vv)
					{			
						
                        $stagus = $vv->paymentstatus;
                        
                        if($stagus == 3)
                        {
                            $submitted_fields = ' <div class="col-md-12 bank_deposit_registration_status">
               
                            <h6 class="heading_title">Bank Deposit Receipt</h6>
                            <div class="custom-file">              
                              <input type="file" name="receipt[]" accept="image/x-png,image/gif,image/jpeg" class="UPLOAD_FILE_ADDITIONAL_INFO custom-file-input" id="customFile" required>                
                              <label class="custom-file-label form-control" for="customFile">Choose a file to upload</label>
                            </div>
                            <div class="row shipping_option_wrapper mt-5 mb-4">
                              <div class="mb-3 col-md-5" style="display: block;">
                                  <label for="">Bank Name</label> 
                                  <input type="text" value="'.$vv->submit_bank_name.'" name="submit_bank_name" class="form-control small_input invoice_credit_owner bank_name" required>
                              </div>
                              <div class="mb-3 col-md-5" style="display: block;">
                                  <label for="">Deposit Name</label> 
                                  <input type="text" value="'.$vv->submit_deposit_name.'" name="submit_deposit_name" value="" class="form-control small_input invoice_cvv account_name" required>
                              </div>
                              <div class="mb-3 col-md-5" style="display: block;">
                                  <label for="">Reference Number</label> 
                                  <input type="text" value="'.$vv->submit_reference_number.'" name="submit_reference_number" value="" class="form-control small_input invoice_card_number account_number" required>
                              </div>
                              <div class="mb-3 col-md-5" style="display: block;">
                                <label for="">Amount Deposited</label> 
                                <input type="text" value="'.$vv->submit_amount_deposited.'" name="submit_amount_deposited" value="" class="form-control small_input invoice_card_number account_number" required>
                              </div>
                          </div>	
                        </div>';
                        }

						$tbl_category_events =	DB::table('tbl_category_events')
								->join('tbl_country', 'tbl_category_events.currency', '=', 'tbl_country.name')
								->where(['tbl_category_events.event_id' => $vv->event_id ])
								->get();

						if(!$tbl_category_events->isEmpty())
						{
							foreach($tbl_category_events as $v)
							{
								$shop_currency = $v->currency;
							}
						}

					

							$all_products .='							
								<tr>
									<td>
									<img style="width:50px" src="/uploads/'.$vv->product_image.'">
									'.$vv->product_name.'</td>
									<td>'.$shop_currency.'&nbsp;'.number_format($vv->_line_unit_price,2).'</td>
									<td> '.$vv->_line_product_qty.'</td>
									<td> '.$shop_currency. '&nbsp;'.number_format($vv->_line_unit_price * $vv->_line_product_qty,2).'</td>
								</tr>
														
						';
						$totalLine += $vv->_line_unit_price * $vv->_line_product_qty;
                       
                        //$all_products .='<div style="padding:10px;"><img style="width:50px" src="/uploads/'.$vv->product_image.'"> X '.$vv->_line_product_qty.'&nbsp;'.  $vv->product_name. '<div>'.$vv->currency.$vv->_line_unit_price.'</div></div>';
					}
                    $all_total += $totalLine ;
					$all_products = $all_products.'<tr style="background:#eee;"><td colspan="2"> <strong></strong> '.''.' <button style="display:none;" class="btn btn-primary btn-danger">Delete</button> </td><td colspan="2" style="text-align:right;"><button type="submit" style="border:0px;" class="">Sub Total&nbsp;&nbsp;<strong>'.$shop_currency.'&nbsp;'. number_format($totalLine,2).'</strong></button></td></tr>';

					if($counterss == 0){
						$countheader = '<h6 class="heading_title" style="padding-top:0px;">Order Details</h6>';
					}else {
						$countheader = '';
                    }
                    
					$counterss++;
					$all_products_wrapper .= '<div class="wrapper_all_order" >
												'.$countheader.'
												<div style="margin: 7px;background: #fff;padding: 14px;">
												<div>Transaction #:</div>
												<table class="table">
												<thead>
													<tr>
														<th>
															Item Name
														</th>
														<th>
															Price
														</th>
														<th>
															Qty
														</th>
														<th style="width:17%">
															Product Total
														</th>
													</tr>
												</thead>
												<tbody>
												'.$all_products.

											 '</tbody></table></div></div>';
                }
                

            }

            if($stagus == 3){
                $payment_method = $submitted_fields;
            }else{

            $payment_method = '<div id="clickhere_changepayment" style="" class="col-md-12 change_payment_method_shopped_items">
            
            <div class="row">
                <div class="mb-0 col-md-6 col-sm-6" style="padding-right: 0px;">	
                <h6 class="heading_title">Change Payment Method: </h6>
                </div>
            </div>
            <div class="row">
              <div class="mb-4 col-md-6 col-sm-6" style="padding-right: 0px;">	
                  <div class="radio_payment_select">
                      <div class="form-check">
                      <input class="form-check-input payment_method__change_" type="radio" name="exampleRadios" id="exampleRadios2" value="Credit Card" x-organizer-id="1">
                      <label class="form-check-label" for="exampleRadios2">
                        Credit Card
                      </label>
                      <img style="float:right ;width: 176px;" src="'.URL('/').'/images/credi.png">
                    </div>

                  </div>	
              </div>
              <div class="mb-4 col-md-6 col-sm-6" style="padding-right: 0px;">
                  <div class="radio_payment_select">
                      <div class="form-check">
                      <input class="form-check-input payment_method__change_" type="radio" name="exampleRadios" id="exampleRadios2" value="Paypal" x-organizer-id="1">
                      <label class="form-check-label" for="exampleRadios2">
                        Paypal
                      </label>
                      <img style="float:right ;width: 36px;" src="'.URL('/').'/images/paypal.png">               
                    </div>
                  </div>
              </div>                                       
              </div>

              <div class="row">
               
                <div class="col-md-6 col-sm-6" style="padding-right: 0px;">
                    <div class="radio_payment_select">
                        <div class="form-check">
                        <input class="form-check-input payment_method__change_" type="radio" name="exampleRadios" id="exampleRadios2" value="Raceyaya Payment Portal" x-organizer-id="1">
                        <label class="form-check-label" for="exampleRadios2">
                          Raceyaya Payment Portal
                        </label>
                        <img style="float:right ;width: 103px;" src="'.URL('/').'/images/h-Iogo.png">
                      </div>
                    </div>
                </div>						     					   
              </div>

              <button style="display:none" type="button" class="mt-5 btn-success btn btn-primary  backtouploadbankdetails">Back to upload bank details</button>
        </div>
        
     
        <div class="col-md-12 bank_deposit_registration_status">
               
                <h6 class="heading_title">Bank Deposit Receipt</h6>
                <div class="custom-file">              
                  <input type="file" name="receipt[]" accept="image/x-png,image/gif,image/jpeg" class="__bankdetails__ UPLOAD_FILE_ADDITIONAL_INFO custom-file-input" id="customFile" required>                
                  <label class="custom-file-label form-control" for="customFile">Choose a file to upload</label>
                </div>
                <div class="row shipping_option_wrapper mt-5 mb-4">
                  <div class="mb-3 col-md-5" style="display: block;">
                      <label for="">Bank Name</label> 
                      <input type="text" value="" name="submit_bank_name" class="__bankdetails__ form-control small_input invoice_credit_owner bank_name" required>
                  </div>
                  <div class="mb-3 col-md-5" style="display: block;">
                      <label for="">Deposit Name</label> 
                      <input type="text" name="submit_deposit_name" value="" class="__bankdetails__ form-control small_input invoice_cvv account_name" required>
                  </div>
                  <div class="mb-3 col-md-5" style="display: block;">
                      <label for="">Reference Number</label> 
                      <input type="text" name="submit_reference_number" value="" class="__bankdetails__ form-control small_input invoice_card_number account_number" required>
                  </div>
                  <div class="mb-3 col-md-5" style="display: block;">
                    <label for="">Amount Deposited</label> 
                    <input type="text" name="submit_amount_deposited" value="" class="__bankdetails__ form-control small_input invoice_card_number account_number" required>
                  </div>
              </div>	
            </div>
        ';
        }

        $bankdeposit = '<div class="col-md-12 bank_deposit_registration_status">
                        <h6 class="heading_title">Bank Deposit Receipt</h6>
                        <div class="custom-file">              
                        <input type="file" name="receipt[]" accept="image/x-png,image/gif,image/jpeg"  class="UPLOAD_FILE_ADDITIONAL_INFO custom-file-input" id="customFile">                
                        <label class="custom-file-label form-control" for="customFile">Choose a file to upload</label>
                        </div>
                        <div class="row shipping_option_wrapper mt-5 mb-4">
                        <div class="mb-3 col-md-5" style="display: block;">
                            <label for="">Bank Name</label> 
                            <input type="text" value="" name="submit_bank_name" class="form-control small_input invoice_credit_owner bank_name">
                        </div>
                        <div class="mb-3 col-md-5" style="display: block;">
                            <label for="">Deposit Name</label> 
                            <input type="text"  name="submit_deposit_name" value="" class="form-control small_input invoice_cvv account_name">
                        </div>
                        <div class="mb-3 col-md-5" style="display: block;">
                            <label for="">Reference Number</label> 
                            <input type="text"  name="submit_reference_number" value="" class="form-control small_input invoice_card_number account_number">
                        </div>
                        <div class="mb-3 col-md-5" style="display: block;">
                            <label for="">Amount Deposited</label> 
                            <input type="text"  name="submit_amount_deposited" value="" class="form-control small_input invoice_card_number account_number">
                        </div>
                    </div>	
                    </div>';

            return response()->json( array(  
                'status'=> $stagus,                                     
                'html'=> $payment_method.$all_products_wrapper.'<table class="table"><tr><td><span style="font-size:15pt;font-weight:bold;">Grand Total: '.$shop_currency.'&nbsp;'.number_format($all_total,2).'</span></td></tr></table><div class="row"><div class="col-md-4"> <div class="inner_wrapper_payment_box"></div><br/><button type="submit" style="width:100%" class="btn btn-primary">Submit</button></div>')
            );
    }

    public function shop_pending_items(){
            if( isset($_POST['shopp_items_input']) )
            {

            }
    }
}
?>