<?php

namespace App\Core\Services;

class RatingService
{
	/**
	 * Service Data.
	 *
	 * @var array
	 */
	private $service_data;

	/**
	 * Default data of Rating service
	 */
	public function __construct()
	{
		$this->service_data = [
			'host' => 'http://localhost:8000/api/',
			'api' => [
				'add_rating' => 'posts/'
			]
		];
	}

	/**
	 * Send user data for rating service via CURL.
	 *
	 * @param int    $post_id
	 * @param string $post_title
	 * @param int    $user_rating
	 * @return mixed
	 */
	public function send_rating(int $post_id, string $post_title, int $user_rating)
	{

		$params = [
			'post_id' => $post_id,
			'post_title' => $post_title,
			'rating' => $user_rating
		];

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->service_data['host'] . $this->service_data['api']['add_rating'] . '?',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_POSTFIELDS => http_build_query($params),
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
		));

		$response = curl_exec($curl);

		return json_decode($response);
	}
}