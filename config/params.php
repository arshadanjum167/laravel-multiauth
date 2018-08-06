<?php
include('api_messages.php');
return array_merge([

    'appTitle'=>'Multi-Auth',
    'short_appTitle'=>'MA',
    'adminEmail'=>'arshad@peerbits.com',
    'msg_success'=>'<div class="alert alert-success alert-dismissable">',
    'msg_error'=>'<div class="alert alert-danger alert-dismissable">',
    'msg_end' => '</div>',
    'account_deactivate'=>'lll',
    
    
    'displayTimezone' => 'UTC',
    'response_text'=>array(200=>"Success",400=>'Bad Request',401=>'Unauthorized',403=>'Forbidden',404=>'Not Found',500=>'Internal Server Error',601=>'Data Dupliacation',602=>'Could Not Save',603=>'No data found'),
    'android_server_api_key'=>"AIzaSyCquNbmpa6jdO66QzXSXD2mZLyx6jiC1Q4", // android server api key
    'ios_server_api_key'=>"AIzaSyCquNbmpa6jdO66QzXSXD2mZLyx6jiC1Q4", // android server api key

],$array);
?>