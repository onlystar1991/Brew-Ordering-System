<?php namespace application\helpers;



class CurlHelper
{

    public function execute($url)
    {
        try
        {
            //echo "start\t" . date("h:i:sa").  "\t";
            ini_set('max_execution_time', 6000); //300 seconds = 5 minutes
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, trim($url));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            //echo curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            $response  = curl_exec($ch);
            if(curl_errno($ch))
            {
                echo 'Curl error: ' . curl_error($ch);
            }
            curl_close($ch);
            unset($ch);
            //echo "end\t" . date("h:i:sa").  "<br>";
            //echo "end\t" . date("h:i:sa").  "<br>";
        }
        catch(exception $ex)
        {
            echo $ex;
            Session::push('execute_error', $ex->getMessage());
        }

        return $response;

    }

}
