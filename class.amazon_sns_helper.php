<?php
/**
 * Amazon SNS helper class
 * 
 * Just does request's using CURL and signs things
 * 
 * @author Russell Smith <russell.smith@ukd1.co.uk>
 */
class amazon_sns_helper {

	/**
	 * Host to perform calls to
	 */
	const HOST = 'sns.us-east-1.amazonaws.com';

	/**
	 * Sign and perform a request
	 * 
	 * @param array key / value list of parameters to pass
	 * @return SimpleXMLElement
	 */
	public static function request ($params) {
		// Add in the extra parameters which we know    
		$params['AWSAccessKeyId'] = AWS_ACCESS_KEY;
		$params['Timestamp'] = gmdate("Y-m-d\TH:i:s\Z");
		$params['SignatureMethod'] = 'HmacSHA256';
		$params['SignatureVersion'] = 2;
		
		// Create the string to be signed
		$string = "GET\n" . self::HOST . "\n/\n";
		
		// Sort them
		ksort($params);
		
		$encoded = array();
		foreach($params as $key=>$param) {
			$encoded[] = rawurlencode($key) . '=' . rawurlencode($param);
		}
		$string .= implode('&', $encoded);
		
		$params['Signature'] = base64_encode(hash_hmac('sha256', $string, AWS_PRIVATE_KEY, true));
		$encoded[] = 'Signature=' . rawurlencode( $params['Signature'] );
		$url = 'https://' . self::HOST . '/?' . implode('&', $encoded);
		
		// Init curl
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		// Execute
		$output = curl_exec($ch);
		
		// Really should check for some http error codes or something...
		
		return new SimpleXMLElement($output);
	}
}