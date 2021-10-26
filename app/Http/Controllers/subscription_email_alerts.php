<?php 

    /**
     *      Date restriction for the subscription 
     *      ang default subscription nya is the bulletin
     *      if ma set ang date restriction or ma modify e access or enable nya ma access
     *      from date onward query it from tbl_date_restriction
     *      article date > new date set 
     * 
     */

$suscriber_id = $_GET['email_alert'];
global $wpdb;
$status_ = '';

$query = "select * from tbl_subscribe_users where id = {$suscriber_id}";
$query_select = $wpdb->get_results($query);
$user_id = 0;

if( count($query_select) > 0 )
{
    $status_ = $query_select[0]->subscription_date;
    $user_id = $query_select[0]->user_id;
}
?>

<div class="container" style="padding-top:56px;">
  <h4>Date Restriction</h4>          
    <table class="table table-bordered">    
      <tbody>
          <tr>
              <td><div><strong>Enable Access Content Onward:</strong> </div></td>
              <td>
                <div class="container">
                    <div class="row">    
                        <link rel='stylesheet' href='https://s3.amazonaws.com/thurgoimages/hire/css/bootstrap-datepicker3.min.css'>
                        <!-- partial:index.partial.html -->
                        <div class="container" id="#sandbox-container" style="width:287px;">
                            <span>Change Date: <?php echo $status_;?></span>
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="form-control date_restriction_field" value="11/05/2019">
                                <button x-subscriber-id="<?php echo $suscriber_id;?>" class="btn btn-info btn-small save_date_restriction_changes" style="margin-left: 4px;">Save</button>
                            </div>
                        </div>
                        <!-- partial -->

                        <script type='text/javascript' src='https://actionacademy.co/cwci/wp-content/plugins/cwci/assets/js/jquery3.3.1.js?ver=5.2.4'></script>
                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
                        <script src='https://s3.amazonaws.com/thurgoimages/hire/js/bootstrap-datepicker.min.js'></script>
                        <script>
                          jQuery('.input-daterange').datepicker({
                              todayBtn: true,
                              autoclose: true
                          });

                          jQuery('.input-daterange input').each(function() {
                            jQuery(this).datepicker('clearDates');
                          });
                        </script>  
                    </div>
                </div>
           </td>
          </tr>            
      </tbody>
    </table>
    <a style="font-size:12px;" class="btn btn-primary" href="<?php echo  $url = admin_url();?>/admin.php?page=cwci-subscription">Back</a>
 </div>