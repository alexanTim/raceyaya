@extends('layouts.app')

@section('content')
<div class="container">

       
<?PHP $status = $_GET['status'];?>

        <div class="row justify-content-center" style="padding-top:37px;margin-bottom: 70px;">
            <div style="padding: 40px;" class="thankyou-box col-md-12">						
            <?php
                if($status == 'S'){
            ?>
                <h1 style="font-size: 26px;font-weight: bold;">Thank your for paying through Dragonpay</h1>
                <p style="text-align: center;margin-top: 20px;padding-bottom: 45px;">
                    <?PHP echo str_replace('[000]', '',  $_GET['message']);?>
                </p>   
                <p style="text-align: center;margin-bottom: 30px;">
                    Your Reference No: <strong><?PHP echo $_GET['refno'];?> </strong>
                </p>   
            <?php
                }elseif($status == 'P'){
            ?>
                <h1 style="font-size: 26px;font-weight: bold;">Your Payment is Pending</h1>
                <p style="text-align: center;margin-top: 20px;padding-bottom: 45px;">
                    <?PHP echo str_replace('[000]', '',  $_GET['message']).'. We send a payment instruction to your email.';?>
                </p>   
                <p style="text-align: center;margin-bottom: 30px;">
                    Your Reference No: <strong><?PHP echo $_GET['refno'];?> </strong>
                </p>   
            <?php
                }elseif($status == 'F'){
            ?>
                <h1 style="font-size: 26px;font-weight: bold;">Payment Failed</h1>
                <p style="text-align: center;margin-top: 20px;padding-bottom: 45px;">
                    <?PHP echo str_replace('[000]', '',  $_GET['message']);?>
                </p>   
                <p style="text-align: center;margin-bottom: 30px;">
                    Your Reference No: <strong><?PHP echo $_GET['refno'];?> </strong>
                </p>   
            <?php
                }
            ?>
                <a href="/profile" class="text-danger"><u>Back to profile</u></a>
            </div>
        </div>


		    

    </div>
@endsection
