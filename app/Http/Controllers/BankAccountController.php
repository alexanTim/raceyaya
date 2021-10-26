<?php
namespace App\Http\Controllers;
use App\User;
use  DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankAccountController extends Controller 
{

    // load here to fetch bank account
    public function index(){

    }

    /**
     *  Call to insert row in modal when creating event
     */
    public function insert_row(){

        if((INT)$_GET['len'] + 1 == 6){
        }else{
            $row = (INT)$_GET['len'] + 1;
            $html = '<div style="margin-bottom:20px;margin-top:20px;border-bottom:1px solid #ddd; margin-bottom:4px;padding-bottom: 11px;" xcount = "'.$row.'" class="wrapper_inner_account">
                            <span>'.$row.'.</span>
                        <div class="row mt-2 mb-3">
                        <div class="col-md-6 col-sm-6"><label for="">Bank Name</label> 
                            <input type="text" name="bank_account['.$row.'][bank_name]" class="input_grey_field form-control bank_name">
                        </div>
                        </div> 
                        <div class="row mt-2 mb-3">
                        <div class="col-md-6 col-sm-6"><label for="">Account Name</label> 
                            <input type="text" name="bank_account['.$row.'][bank_account]" class="input_grey_field form-control bank_account">
                        </div>
                        </div>             
                        <div class="row mt-1"><div class="col-md-12 col-sm-6"><label for="">Account Number</label>
                        <input type="text" name="bank_account['.$row.'][bank_account_number]" class="input_grey_field form-control bank_account_number">
                        </div>
                        </div>
                        <div class="row mt-1"><div class="col-md-12 col-sm-6"><label for="">Bank Branch</label>
                        <input type="text" name="bank_account['.$row.'][bank_branch]" class="input_grey_field form-control bank_branch">
                        </div>
                        </div>
                    </div>';
            return response()->json($html);  
        } 

        return response()->json( array('html'=>'Exceeds'));        
    }

    /*
    Array
    (
        [bank_name] => Alexander
        [bank_account] => adfsdkfjsdkfd
        [bank_account_number] => 99999999999999999999999
    )
    */
    public function insertBankAccountData()
    {
        $user_id =  Auth::user();

        DB::table('tbl_account_info')->where("user_id",$user_id->id)->delete();

        foreach($_POST['bank_account'] as $values)
        {             
            if( $values['bank_name'] != '' and  
                $values['bank_account_number'] !=''  and  
                $values['bank_account'] !='' )           
                {
                    DB::table("tbl_account_info")->insert([
                                                            'bank_name'     => $values['bank_name'],
                                                            'account_number'=> $values['bank_account_number'],
                                                            'account_name'  => $values['bank_account'],
                                                            'bank_branch'  => $values['bank_branch'],
                                                            'user_id'       => $user_id['id'],
                                                          ]);
                }
        }
    }

    /* Get Bank Accounts
     * Get Bank Accounts
     * Get Bank Accounts
     */
    public function getbankaccounts()
    {
         $result = DB::table("tbl_account_info")->where('user_id',Auth::user()->id)->get();
         $count = count($result);
         $html  = '';
         if($count >0)
         {
             $count = 1;
            

             foreach( $result as $v )
             {
                $html .= '<div xcount="'.$count.'" class="wrapper_inner_account" style="margin-bottom:20px;margin-top:20px;border-bottom:1px solid #ddd; margin-bottom:4px;padding-bottom: 11px;" >
                            <span>'. $count .'.</span>
                            <div class="row mt-2 mb-3">
                                <div class="col-md-6 col-sm-6"><label for="">Bank Name</label> 
                                    <input type="text" name="bank_account['.$count.'][bank_name]" value="'.$v->bank_name.'" class="input_grey_field form-control bank_name">
                                </div>
                            </div> 
                            <div class="row mt-2 mb-3">
                                <div class="col-md-6 col-sm-6"><label for="">Account Name</label> 
                                    <input type="text" name="bank_account['.$count.'][bank_account]"  value="'.$v->account_name.'" class="input_grey_field form-control bank_account">
                                </div>
                            </div>             
                            <div class="row mt-1">
                                <div class="col-md-12 col-sm-6"><label for="">Account Number</label>
                                     <input type="text" name="bank_account['.$count.'][bank_account_number]"  value="'.$v->account_number.'" class="input_grey_field form-control bank_account_number">
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-12 col-sm-6"><label for="">Bank Branch</label>
                                     <input type="text" name="bank_account['.$count.'][bank_branch]"  value="'.$v->bank_branch.'" class="input_grey_field form-control bank_branch">
                                </div>
                            </div>
                        </div>';
                $count++;
             }
         }

        $resultName = array();

        return response()->json( array('html'=> $html,'size'=> $count ));
       
    }

    public function method($v){
        echo $v;
    }
}