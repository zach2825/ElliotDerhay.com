<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    private $api_url = 'https://api.twitter.com';
    private $token;
    private $key;
    private $secret;

    /**
     * Create a new instance of the Tweet model
     *
     * @param array     $attributes
     * @return void
     *
     * This is necessary to initialize some properties that can't otherwise be
     * initialized. Initializing properties outside of a constrctor requires
     * that the initial values be static.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->token = config('service.twitter.token', false);
        $this->key = config('services.twitter.key', false);
        $this->secret = config('services.twitter.secret', false);
    }

    /**
     * Generate a new Twitter API token if one doesn't exist
     *
     * @return void
     *
     * The 'if' in this case has to do with whether Twitter already has a token
     * for use. If the token hasn't been generated previously or if the previous
     * token was revoked, then this function will be used to ask Twitter for a
     * new one.
     *
     * This method will also only be called if the token doesn't already exist
     * in the environment.
     */
    public function createToken()
    {
        $post_url = "$this->api_url/oauth2/token";

        if(!$this->key || !$this->secret) {
            abort(500);
        }

        $twitter_str = base64_encode(urlencode($this->key) . ':' . urlencode($this->secret));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $post_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Basic $twitter_str",
            "Content-Type: application/x-www-form-urlencoded;charset=UTF-8"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = json_decode(curl_exec($ch));
        curl_close($ch);

        if(isset($result->errors)) {
            abort(500);
        }

        $this->token = $result->access_token;
    }

    /**
     * Retrieve raw tweets via Twitter's GET API
     *
     * @param string    $screen_name
     * @param int       $count
     * @param bool      $retweets
     * @return string
     */
    public function getRawTweets($screen_name = 'jsn1nj4', $count = 5, $retweets = false)
    {
        if(!$this->token) {
            $this->createToken();
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$this->api_url/1.1/statuses/user_timeline.json?count=$count&screen_name=$screen_name");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $this->token"
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $tweets = curl_exec($ch);

        if(isset(json_decode($tweets)->errors)) {
            abort(500);
        }

        return $tweets;
    }

    /**
     * Retrieve formatted tweets via Twitter's GET API
     *
     * @param string    $screen_name
     * @param int       $count
     * @param bool      $retweets
     * @return string
     *
     * This method reduces the amount of data sent back to the client. If the
     * raw tweets are needed instead, the function called within can be called
     * directly instead.
     */
    public function getTweets($screen_name = 'jsn1nj4', $count = 5, $retweets = false)
    {
        return $this->getRawTweets($screen_name, $count, $retweets);
    }
}
