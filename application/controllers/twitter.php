<?php
/**
  * Controller for Twitter
  * 
*/

defined('BASEPATH') OR exit('No direct script access allowed');

//Using Twitter API
require_once(APPPATH.'libraries/TwitterAPIExchange.php');

class Twitter extends CI_Controller{
	
	/**
  	  * get() method return tweet that memtion the city.
      * Call by {url}/twitter/get?address={address}&ll={latitude,longitude}
	  * Example - http://www.web.com/twitter/get?q=bangkok&ll=13.71704,100.554718
	  * After got tweets from twiiter, we store tweets into database.
	  */
	public function get(){
		
		$address = $this->input->get('address');
		$ll = $this->input->get('ll');
		$radius = "50km";
		
		//twitter configuration variables
		$settings = array(
			'oauth_access_token' => ACCESS_TOKEN,
			'oauth_access_token_secret' => ACCESS_TOKEN_SECRET,
			'consumer_key' => CONSUMER_KEY,
			'consumer_secret' => CONSUMER_SECRET
		);
		
		$url = 'https://api.twitter.com/1.1/search/tweets.json';
		$getfield = '?q='.$address.'&geocode='.$ll.','.$radius;
		$requestMethod = 'GET';
		
		$twitter = new TwitterAPIExchange($settings);
		
		$string = json_decode($twitter->setGetfield($getfield)
									  ->buildOauth($url, $requestMethod)
									  ->performRequest(),$assoc = TRUE);
		
		$data = array();
		
		//load usefull model
		$this->load->model('tweet_model');
		$this->load->model('search_history_model');
		
		//check and store $address to database.
		if(!$this->search_history_model->isExist($address)){
			$this->search_history_model->insert_entry($address);
		}

		//start to access the information about each tweet.
		foreach($string['statuses'] as $items){
			if(!empty($items['geo'])){
				
				$tweet = array();
				$tweet['id'] = $items['id'];
				$tweet['created_at'] = date('H:i, M d', strtotime($items['created_at']));
				$tweet['text'] = $items['text'];
				$tweet['screen_name'] = $items['user']['screen_name'];
				$tweet['profile_image_url'] = $items['user']['profile_image_url'];
				$tweet['lat'] = $items['geo']['coordinates'][0];
				$tweet['lng'] = $items['geo']['coordinates'][1];
				
				//check if tweet id is already exist in database. If not, store tweet into database.
				if(!$this->tweet_model->isExist($tweet['id'])){
					$this->tweet_model->insert_entry($tweet);
				}
				
				$data[] = $tweet;
			}
		}
		
		//return the information about each tweet.
		echo json_encode($data);
	}
	
}