@extends('layouts.app')

@section('content')
<div class="container">
		    <div class="row" style="padding-top:37px;margin-bottom: 70px;">
				<div class="col-md-12" style="padding:62px padding-top:0px;">						
						<h5>RaceYaya Dragonpay</h5>                        
                        <div class="form">
                            <br/>
                            <form method="post" action="{{route('paydragon')}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="cb" value="dragonpay">
                                <input type="hidden" name="id" value="<?php echo $_GET['id']?>">
                                
                                <?php foreach ($fields as $key => $value): ?>
                                    <?php 

                                        if( $value['label'] =='Amount'){
                                            $hide = 'display:block;';
                                        }else{
                                            $hide = 'display:none;';
                                        }

                                    ?>
                                    <div class="col-md-4" style="margin-bottom:5px;<?php echo $hide;?>" class="input">
                                        <span class="label"><label for="<?php echo $key; ?>">
                                            <?php echo $value['label']; ?>:</label>
                                        </span>
                                        
                                        <?php 
                                        if( $value['label'] =='Amount'){ ?>

                                          <div style="display:flex;"> <span style="padding-top: 8px;font-size: 29px;">PHP</span> <input readonly type="text" style="background:none; border:0px; font-size:22pt;font-weight: bold;" class="form-control input_medium"  name="<?php echo $key; ?>" value="<?php echo $parameters[$key]; ?>" /></div>
                                        
                                        <?php } else { ?>

                                            <input readonly type="text" style="background:none; border:0px; font-size:22pt;font-weight: bold;" class="form-control input_medium"  name="<?php echo $key; ?>" value="<?php echo $parameters[$key]; ?>" />
                                        
                                        <?php } ?>

                                     </div>
                                <?php endforeach; ?>
                                <div class="col-md-4">
                                    <input type="submit" style="border: 0px;
                                    padding: 6px;
                                    width: 118px;
                                    border-radius: 0px;
                                    color: #fff;
                                 
                                    margin-right: 11px;
                                    font-weight: 600;" class="btn btn-primary" name="submit" value="Pay Now">
                                </div>                             
                            </form>
                          </div>    
				</div>
			</div>
    </div>
@endsection
