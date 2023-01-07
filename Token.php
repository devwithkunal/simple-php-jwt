<?php

class Token{

    /**
     * Sign - Static method to generate token
     *  
     * @param array $payload
     * @param string $key - The signature key
     * @param int $expire - (optional) Max age of token in seconds. Leave it blank for no expiration.
     * 
     * @return string token
     */
    static function Sign($payload, $key, $expire = null){

        // Header
        $headers = ['algo'=>'HS256', 'type'=>'JWT', 'expire' => time()+$expire];
        if($expire){
            $headers['expire'] = time()+$expire;
        }
        $headers_encoded = base64_encode(json_encode($headers));

        // Payload
        $payload['time'] = time();
        $payload_encoded = base64_encode(json_encode($payload));

        // Signature
        $signature = hash_hmac('SHA256',$headers_encoded.$payload_encoded,$key);
        $signature_encoded = base64_encode($signature);

        // Token
        $token = $headers_encoded . '.' . $payload_encoded .'.'. $signature_encoded;

        return $token;
    }

    /**
     * Verify - Static method verify token
     * 
     * @param string $token
     * @param string $key - The signature key
     * 
     * @return boolean false if token is invalid or expired
     * @return array payload
     */
    static function Verify($token, $key){

        // Break token parts
        $token_parts = explode('.', $token);

        // Verigy Signature
        $signature = base64_encode(hash_hmac('SHA256',$token_parts[0].$token_parts[1],$key));
        if($signature != $token_parts[2]){
            return false;
        }

        // Decode headers & payload
        $headers = json_decode(base64_decode($token_parts[0]), true);
        $payload = json_decode(base64_decode($token_parts[1]), true);

        // Verify validity
        if(isset($headers['expire']) && $headers['expire'] < time()){
            return false;
        }

        // If token successfully verified
        return $payload;
    }

}