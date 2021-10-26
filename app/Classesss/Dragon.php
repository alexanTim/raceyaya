<?php
namespace App\Classesss;
use DB;
use Illuminate\Support\Facades\Auth;

class Dragon {	   
	public function __construct()
    {
          
    }
	
	function fetch($tnxid,$username,$passw,$ENV_TEST)
	{		
		if($ENV_TEST){			
			 $url = 'https://gw.dragonpay.ph/MerchantRequest.aspx?';
		}else{
			 $url = 'https://test.dragonpay.ph/MerchantRequest.aspx?';
		}		
		
		$getQuery = 'op=GETSTATUS&merchantid='.$username.'&merchantpwd='.$passw.'&txnid='.$tnxid;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url.$getQuery);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$status = curl_exec($ch);
		return ($status);
	}

	function cancelTransaction($tnxid,$username,$passw,$ENV_TEST)
	{		
		if($ENV_TEST)
		{			
			 $url = 'https://gw.dragonpay.ph/MerchantRequest.aspx?';
		}else{
			 $url = 'https://test.dragonpay.ph/MerchantRequest.aspx?';
		}		
		
		$getQuery = 'op=VOID&merchantid='.$username.'&merchantpwd='.$passw.'&txnid='.$tnxid;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url.$getQuery);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$status = curl_exec($ch);
		return ($status);
	}
}				
?>