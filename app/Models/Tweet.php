<?php

namespace App\Models;

use App\Http\Clients\TwitterClient;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    private ?TwitterClient $twitter = null;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->twitter = new TwitterClient;
    }

    /**
     * Format tweet data
     *
     * @method                  formatTweetData
     * @access private
     *
     * @param array             $tweets
     *
     * @return array
     *
     * Strip down tweet data returned by Twitter API. Most of the data returned
     * by the Twitter API isn't necessary in this case.
     */
    private function formatTweetData(array $tweets)
    {
        $formattedTweets = collect([]);

        foreach($tweets as $tweet) {
            $tweet = collect($tweet)->reject(function($val, $key) {
                return !in_array($key, [
                    'created_at',
                    'id_str',
                    'text',
                    'entities',
                    'user'
                ]);
            });

            $user = collect($tweet->get('user'))->reject(function($val, $key) {
                return !in_array($key, [
                    'name',
                    'screen_name',
                    'profile_image_url_https'
                ]);
            });
            $tweet->put('user', $user->toArray());

            $formattedTweets->push($tweet->toArray());
        }

        return $formattedTweets->toJson();
    }

    /**
     * Retrieve tweets
     *
     * @method                  getTweet
     * @access public
     *
     * @param array             $options: count, screen_name, retweets
     *
     * @return string
     *
     * This method returns a list of tweets that their initial API data trimmed
     * down first.
     */
    public function getTweets(array $options = [])
    {
        $count = isset($options['count']) && $options['count'] > 0 ?
            $options['count'] : 5;
        $screen_name = isset($options['screen_name']) && mb_strlen($options['screen_name']) ?
            $options['screen_name'] : 'jsn1nj4';
        $retweets = isset($options['retweets']) && is_bool($options['retweets']) ?
            $options['retweets'] : true;

        return $this->formatTweetData(
            $this->twitter->getTweets($screen_name, null, $retweets, $count)
        );
    }
}
