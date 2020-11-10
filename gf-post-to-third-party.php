<?php

/**
 * Plugin Name:       Gravity Forms Post to Third Party
 * Description:       Posts Gravity Forms field data to a third party.
 * Version:           1.0
 * Author:            Adrian Chellew
*/

// -----------------------------------------------------------------#
// Send Gravity Forms data to a third party.
// -----------------------------------------------------------------#

function gf_post_to_third_party($entry, $form) {

		// Get the form ID
		$id = $form['id'];

		// Get the data from each form field by specifiying the field's ID
		$form_field1 = rgar($entry, '1');
		$form_field2 = rgar($entry, '2');
		$form_field3 = rgar($entry, '3');

		// Specify the URL to which the form data will be posted
		$url = 'http://myremoteservice/';

		// Initiate cURL
		$ch = curl_init($url);

		// Create an array with the form data to be posted
		$jsonData = [
			'id'		=> $id,
			'field1'	=> $form_field1,
			'field2'	=> $form_field2,
			'field3'	=> $form_field3
		];

		// Encode the array into JSON
		$jsonDataEncoded = json_encode($jsonData);

		// Tell cURL that we want to send a POST request
		curl_setopt($ch, CURLOPT_POST, 1);

		// Attach the encoded JSON string to the POST fields
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

		// Set the content type to JSON
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		
		// Don't return the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Execute the request
		curl_exec($ch);

		// Close cURL resource
		curl_close($ch);

	}

}

add_action( 'gform_after_submission', 'gf_post_to_third_party', 10, 2 );

?>