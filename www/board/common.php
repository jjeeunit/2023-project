<?php 
function _json(...$args)
{
    if (func_num_args() > 3) return false;
    $json = array('err' => true);

    foreach ($args as $key => $val) {
        $type = gettype($val);

        if ($type == 'string') $json['msg'] = $val;
        if ($type == 'boolean') $json['err'] = $val;
        if ($type == 'array') $json['data'] = $val;
    } 

    exit(json_encode($json));
}//end _function _json


function _pr($arr) 
{
    echo '<pre>';
        print_r($arr);
    echo '</pre>';

}