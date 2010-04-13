<?php
/*
 * Amazon SNS Topic
 * 
 * Allows creating of new topics, deleting, setting the display name and publishing to existing topics
 * 
 * @author Russell Smith <russell.smith@ukd1.co.uk>
 */
class amazon_sns_topic {

	private $TopicArn;
	
	/*
	 * Create a new topic object
	 * 
	 * param string the topicarn you got previously after creating a new topic
	 */
	public function __construct ($TopicArn = null) {
	
		if (!is_null($TopicArn)) {
			$this->TopicArn = $TopicArn;
		}
	
	}
	
	/*
	 * Publish a message to this topic
	 * 
	 * @param string subject of the message (for emails)
	 * @param string message body
	 */
	public function publish ($subject, $message) {
		$response = amazon_sns_helper::request(array('Subject'=>$subject, 'Message'=>$message, 'TopicArn'=>$this->TopicArn, 'Action'=>'Publish'));
	}
	
	/*
	 * Set the display name for this topic
	 * 
	 * @param string the human readable display name
	 */
	public function setDisplayName ($DisplayName) {
		$response = amazon_sns_helper::request(array('Action'=>'SetTopicAttributes', 'TopicArn'=>$this->TopicArn, 'AttributeName'=>'DisplayName', 'AttributeValue'=>$DisplayName));
	}
	
	/*
	 * Return the arn for the current topic
	 * 
	 * @return string
	 */
	public function getArn () {
		return $this->TopicArn;
	}
	
	/*
	 * Ask amazon to delete the current topic 
	 */
	public function delete () {
		$response = amazon_sns_helper::request(array('Action'=>'DeleteTopic', 'TopicArn'=>$this->TopicArn));
	}
	
	/**
	 * Create a new topic with this name
	 * 
	 * @param string topic name
	 * @return amazon_sns_topic
	 */
	public static function create ($name) {
		$response = amazon_sns_helper::request(array('Action'=>'CreateTopic', 'Name'=>$name));
	
		return new amazon_sns_topic($response->CreateTopicResult->TopicArn);
	}

}