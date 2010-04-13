<?php
/*
 * Amazon SNS example script
 * 
 * This will help you setup a topic, add a subscriber and pubish a sample
 * message to the topic.
 * 
 * Be sure to customize the details as required.
 * 
 * After this, you'll need to run the script once to create the topic & 
 * add you as a subsriber...
 * 
 * Then uncomment the last line and publish to the topic.
 * 
 * @author Russell Smith <russell.smith@ukd1.co.uk>
 */


/*
 * Your access key for AWS
 */
define('AWS_ACCESS_KEY', '<your amazon access key>');

/*
 * Your private AWS key
 */
define('AWS_PRIVATE_KEY', '<your amazon secret key>');


// Customize these variables...
$your_email = 'your_email@example.com';
$topic_title = 'hello-world';
$topic_display_name = 'Amazon SNS Test';

// Then omment this next line out or remove when you're done setting up the above & run!
exit();








require_once 'class.amazon_sns_helper.php';
require_once 'class.amazon_sns_topic.php';
require_once 'class.amazon_sns_subscriber.php';

$topic = amazon_sns_topic::create($topic_title);

print 'Your topic ARN: ' . $topic->getArn() . "\n";

$topic->setDisplayName($topic_display_name);

// Create the new subscription - this will email you a "opt in" message
$subscriber = amazon_sns_subscriber::create($topic, $your_email);



// Note, publish won't work and commented out as you'll need to 
// confirm the subscription by opting in first.

//$topic->publish('Amazon SNS Test message', 'Hello, world!');