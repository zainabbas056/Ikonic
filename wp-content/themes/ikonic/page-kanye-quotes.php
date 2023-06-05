<!DOCTYPE html>
<html>
	<head>
		<title>Kanye Quotes</title>
	</head>
	<body>
		<h1>Kanye Quotes</h1>
		<ul id="quote-list"></ul>

		<?Php
		for ($i = 0; $i < 5; $i++) {
			// Fetch quotes from the API
			$response = wp_remote_get('https://api.kanye.rest/quotes?count=5');

			// Check if the request was successful
			if (is_array($response) && !is_wp_error($response)) {
				// Get the response body
				$body = wp_remote_retrieve_body($response);

				// Decode the JSON response
				$data = json_decode($body);
				// Check if the JSON decoding was successful
				if ($data) {
					echo '<p>' . $data->quote . '</p>';
				}
			}
		}
		?>
	</body>
</html>
