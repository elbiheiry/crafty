<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
class CloudFrontCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $host = parse_url(config('app.url'))['host'];

        $cookies = $this->createSignedCookie("https://crafty-workshop.com", 'outputs/*', 1000);

        foreach($cookies as $key => $value){
            setcookie($key, $value, 0, "/", "{$host}", false, false);
        }

        return $next($request);
    }

    public function createSignedCookie($streamHostUrl, $resourceKey, $timeout)
    {
        $keyPairId = "K2O4GJ2WFU7C81"; // Key Pair
        $expires = time() + $timeout; // Expire Time
        $url = $streamHostUrl . '/' . $resourceKey; // Service URL
        $ip = $_SERVER["REMOTE_ADDR"] . "\/24"; // IP
        $json = '{"Statement":[{"Resource":"' . $url . '","Condition":{"DateLessThan":{"AWS:EpochTime":' . $expires . '}}}]}';

        $fp = fopen(storage_path('public_key.pem'), "r");
        $priv_key = fread($fp, 8192);
        fclose($fp);

        $key = openssl_get_privatekey($priv_key);
        if (!$key) {
            echo "<p>Failed to load private key!</p>";
            return;
        }
        if (!openssl_sign($json, $signed_policy, $key, OPENSSL_ALGO_SHA1)) {
            echo '<p>Failed to sign policy: ' . openssl_error_string() . '</p>';
            return;
        }

        $base64_signed_policy = base64_encode($signed_policy);

        $policy = strtr(base64_encode($json), '+=/', '-_~'); //Canned Policy

        $signature = str_replace(array('+', '=', '/'), array('-', '_', '~'), $base64_signed_policy);

        //In case you want to use signed URL, just use the below code
        //$signedUrl = $url.'?Expires='.$expires.'&Signature='.$signature.'&Key-Pair-Id='.$keyPairId; //Manual Policy
        $signedCookie = array(

            "CloudFront-Key-Pair-Id" => $keyPairId,
            "CloudFront-Policy" => $policy,
            "CloudFront-Signature" => $signature
        );

        return $signedCookie;
    }
}
