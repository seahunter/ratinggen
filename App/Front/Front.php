<?php

namespace App\Front;

use App\Core\Services\RatingService;

class Front
{
	public function __construct()
	{
		/**
		 * Comment form filter
		 *
		 * @see add_rating_field()
		 */
		add_filter('comment_form_defaults', [$this, 'add_rating_field']);
		/**
		 * Send the request data from comment form to rating service
		 *
		 * @see send_user_rating()
		 */
		add_action('comment_post', [$this, 'send_user_rating']);
	}

	/**
	 * Add custom rating field after comment textarea
	 *
	 * @param $default
	 * @return mixed
	 */
	public function add_rating_field($default)
	{
		$default['comment_field'] .= $this->get_rating_template();
		return $default;
	}

	/**
	 * Get template of rating field
	 *
	 * @return false|string
	 */
	private function get_rating_template()
	{
		ob_start();
		include_once plugin_dir_path(__FILE__) . '/partials/template-rating-field.php';
		$template = ob_get_contents();
		ob_end_clean();

		return $template;

	}

	/**
	 * Get post data for rating service
	 *
	 * @param int $post_id Post ID.
	 * @return array
	 */
	private function get_post_data(int $post_id)
	{
		$current_post = get_post($post_id);
		return [
			$current_post->ID,
			$current_post->post_title
		];
	}

	/**
	 * Send comment data to rating service
	 */
	public function send_user_rating()
	{
		if (!empty($_POST['comment_post_ID']) && !empty($_POST['rating_list'])) {
			$post_id = (int)$_POST['comment_post_ID'];
			$rating_data = $this->get_post_data($post_id);
			$rating_data[] = (int)$_POST['rating_list'];

			$result = (new RatingService())->send_rating(...$rating_data);
			$this->update_user_rating($post_id, (float)$result->averageRating);
		}
	}

	/**
	 * Save average rating for current post
	 *
	 * @param int   $post_id Post id.
	 * @param float $number  Rating value.
	 */
	private function update_user_rating(int $post_id, float $number)
	{
		update_post_meta($post_id, 'averageRating', $number);
	}


}