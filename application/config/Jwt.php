<?php 

    defined('BASEPATH') OR exit('No direct script access allowed');

    $config['jwt_key'] = '443fcbe08c1e5e70202f89137e0290308784679756a43c07c7fdacf9bfb2427b';
    $config['jwt_algorithm'] ='HS256' ;
    $config['jwt_issuer'] = 'https://serverprovider.com';
    $config['jwt_audience'] = 'https://serverclient.com';
    $config['jwt_expire'] = 3600;
    
?>