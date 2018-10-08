<?php
/**
 * Created by PhpStorm.
 * User: krystofkosut
 * Date: 16.09.18
 * Time: 0:22
 */

namespace App\Twitter;
use App\model\params;
use OAuthException;
use OAuth;

class twitter
{
    public static $apiKey;
    public static $apiSecretKey;
    public static $apitoken;
    public static $apisecretToken;

    private static $instance;
    private static $nonce;

  //  private $method = 'POST';

 //   private $token;

    const API_VERSION       = '1.1';
    const API_HOST          = 'https://api.twitter.com';
    const UPLOAD_HOST       = 'https://upload.twitter.com';
    const SIGNATURE_METHOD  = 'HMAC-SHA1';
  //  const BASEURL           = 'https://api.twitter.com/1.1/statuses/update.json';

    static public function getInstance(){
        if( !isset( self::$instance)){
            self::$apiKey           = params::getValue('twitter_APIKey');
            self::$apiSecretKey     = params::getValue('twitter_APISecretKey');
            self::$apitoken         = params::getValue('twitter_AccessToken');
            self::$apisecretToken   = params::getValue('twitter_AccessTokenSecret');
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function getTimeline($channel){
        $resourceUrl = 'https://api.twitter.com/1.1/statuses/user_timeline.json';

        // if channel is array... (more than one)


        // TODO: Use user ID or user name???
        // TODO: Determinate if using user_id or screen_name
        $params = array(
            'screen_name'   => $channel->screen_name,
            'count'         => $channel->count
        );


    }























    public function authenticate(){
        $time = time();
        self::$nonce = trim(base64_encode($time), '=');

        $data = array(
            'oauth_consumer_key' => self::$apiKey,
            'oauth_nonce' => self::$nonce,
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => $time,
            'oauth_token' => self::$apitoken,
            'oauth_version' => '1.0'
        );
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'Authorization' => json_encode($data)
            )
        );
        $context  = stream_context_create($options);
    }

    /**
     * Calculating the signature
     *
     * @return string  Signature
     */
    private function calculateSignature()
    {
        return base64_encode(hash_hmac('sha1', $this->getSignatureBaseString(), $this->getSigningKey(), true));
    }

    /**
     * Getting OAuth signature base string
     *
     * @return string  OAuth signature base string
     */
    private function getSignatureBaseString()
    {
        $method = strtoupper($this->method);
        $url    = rawurlencode(self::BASEURL);
        return $method . '&' . $url . '&' . $this->getRequestString();
    }

    private function getRequestString(){
        return 'status=Hello%20Ladies%20%2b%20Gentlemen%2c%20a%20signed%20OAuth%20request%21';
    }


}