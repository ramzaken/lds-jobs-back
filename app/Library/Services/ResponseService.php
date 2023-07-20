<?php
namespace App\Library\Services;

class ResponseService
{
    public function response($data, $message, $status)
    {   
        $result     =   [
                            'data'      =>  $data,
                            'message'   =>  $message,
                            'status'    =>  $status
                        ];
        return $result;
    }
}


