<?php
/*
 * Amazon SNS Subscriber
 * 
 * Allows creating of a new subscriber for a topic
 * 
 * @author Russell Smith <russell.smith@ukd1.co.uk>
 */
class amazon_sns_subscriber {

	/*
	 * Create a new subscriber
	 * 
	 * @param amazon_sns_topic topic to create the subscriber in
	 * @param string endpoint - aka email address for most people?
	 * @param string protocol to use (see docs)
	 */
	public static function create (amazon_sns_topic $topic, $endpoint, $protocol = 'email') {
		$response = amazon_sns_helper::request(array('Action'=>'Subscribe', 'TopicArn'=>$topic->getArn(), 'Endpoint'=>$endpoint, 'Protocol'=>$protocol));
	}

}