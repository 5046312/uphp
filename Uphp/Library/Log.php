<?php
namespace Uphp;

class Log
{
    public function test(){
        $log_config = config('log');
        if($log_config['open']){
            $startMicroTime = microtime();
            switch(strtolower($log_config['type'])){
                case "file":
                    $log_class = U_DIR."\\Log\\FILE";
                    $log_args =  [NULL, $log_config['file']];
                    break;
                default:
                    Exception::error(Language::get("LOG_TYPE_ERROR"));
            }
            call_user_func_array([$log_class, "init"], $log_args);
        }
    }
}