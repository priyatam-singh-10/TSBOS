<?php

namespace App\Http\Controllers;

use DateInterval;
use Illuminate\Http\Request;

class CommonController extends Controller
{
	// Get video details new code
	function get_video_details(Request $request, $url = "")
	{
		if ($url == "") {
			$url = $request->url;
		}
		// Agar iframe paste hua hai to usme se src nikal lo
		if (stripos($url, '<iframe') !== false) {

			preg_match('/src=(["\'])(.*?)\1/i', $url, $matches);

			if (!empty($matches[2])) {

				$url = html_entity_decode($matches[2], ENT_QUOTES);

				$parts = parse_url($url);

				$url = $parts['scheme'] . '://' . $parts['host'] . $parts['path'];
			}
		}


		$host = explode('.', str_replace('www.', '', strtolower(parse_url($url, PHP_URL_HOST))));
		$host = isset($host[0]) ? $host[0] : $host;

		$vimeo_api_key = get_settings('vimeo_api_key');
		$youtube_api_key = get_settings('youtube_api_key');

		if ($host == 'vimeo' || $host == 'player') {

			$path = parse_url($url, PHP_URL_PATH) ?? '';
			$video_id = null;

			// New Vimeo "Copy link" format: https://vimeo.com/share/{uuid}
			if (preg_match('#/share/([0-9a-fA-F-]{30,})#', $path)) {
				$resolved = $this->resolve_vimeo_share_url($url);
				if (empty($resolved['video_id'])) {
					return response()->json([
						'error' => 'Unable to resolve Vimeo share URL. Please paste the video URL like https://vimeo.com/123456789'
					]);
				}
				$video_id = $resolved['video_id'];
			} elseif (preg_match('#/video/(\d+)#', $path, $matches)) {
				$video_id = $matches[1];
			} elseif (preg_match('#/(?:channels|groups)/[^/]+/(?:videos/)?(\d+)#', $path, $matches)) {
				$video_id = $matches[1];
			} elseif (preg_match('#/(?:album|showcase)/\d+/video/(\d+)#', $path, $matches)) {
				$video_id = $matches[1];
			} elseif (preg_match('#(?:^|/)(\d{6,})(?:/|$)#', $path, $matches)) {
				// Standard numeric URL: https://vimeo.com/1210287057
				$video_id = $matches[1];
			} else {
				return response()->json([
					'error' => 'Invalid Vimeo URL'
				]);
			}

			$options = [
				'http' => [
					'method' => 'GET',
					'header' => 'Authorization: Bearer ' . $vimeo_api_key . "\r\n"
						. "Accept: application/vnd.vimeo.*+json;version=3.4\r\n",
					'ignore_errors' => true,
					'timeout' => 20,
				],
				'ssl' => [
					'verify_peer' => false,
					'verify_peer_name' => false,
				],
			];

			$context = stream_context_create($options);

			try {
				$response = @file_get_contents("https://api.vimeo.com/videos/{$video_id}", false, $context);
				$hash = json_decode($response ?: '');
			} catch (\Throwable $th) {
				return response()->json([
					'error' => $th->getMessage()
				]);
			}

			if (empty($hash) || empty($hash->duration)) {
				return response()->json([
					'error' => 'Unable to fetch Vimeo video details'
				]);
			}

			return [
				'provider'    => 'Vimeo',
				'video_id'    => (string) $video_id,
				'title'       => $hash->name ?? '',
				'thumbnail'   => $hash->pictures->sizes[0]->link ?? '',
				'video'       => $hash->link ?? ('https://vimeo.com/' . $video_id),
				'embed_video' => "https://player.vimeo.com/video/" . $video_id,
				'duration'    => gmdate("H:i:s", (int) $hash->duration),
			];
		} elseif ($host == 'youtube' || $host == 'youtu') {
			preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
			$video_id = $match[1];

			try {
				$hash = json_decode(file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id=$video_id&key=$youtube_api_key"));
			} catch (\Throwable $th) {
				$hash = '';
			}

			if ($hash == '') return;

			$duration = new DateInterval($hash->items[0]->contentDetails->duration);
			return array(
				'provider'          => 'YouTube',
				'video_id'			=> $video_id,
				'title'             => $hash->items[0]->snippet->title,
				'thumbnail'         => 'https://i.ytimg.com/vi/' . $hash->items[0]->id . '/default.jpg',
				'video'             => "http://www.youtube.com/watch?v=" . $hash->items[0]->id,
				'embed_video'       => "http://www.youtube.com/embed/" . $hash->items[0]->id,
				'duration'       	=> $duration->format('%H:%I:%S'),
			);
		} elseif ($host == 'drive') {
		}
	}

	/**
	 * Resolve Vimeo share/copy links (UUID) to the real numeric video ID.
	 * Example: https://vimeo.com/share/74894c91-a5f8-4bd5-a05c-badf9e9ba343
	 */
	private function resolve_vimeo_share_url(string $url): ?array
	{
		$parts = parse_url($url);
		if (empty($parts['host']) || empty($parts['path'])) {
			return null;
		}

		$shareUrl = ($parts['scheme'] ?? 'https') . '://' . $parts['host'] . $parts['path'];

		$context = stream_context_create([
			'http' => [
				'method' => 'GET',
				'timeout' => 20,
				'ignore_errors' => true,
				'header' => "User-Agent: Mozilla/5.0\r\nAccept: text/html\r\n",
			],
			'ssl' => [
				'verify_peer' => false,
				'verify_peer_name' => false,
			],
		]);

		$html = @file_get_contents($shareUrl, false, $context);
		if (!$html) {
			return null;
		}

		// Prefer canonical / og:url → https://vimeo.com/{numeric_id}
		$patterns = [
			'/rel=["\']canonical["\'][^>]*href=["\']https?:\/\/(?:www\.)?vimeo\.com\/(\d+)["\']/i',
			'/href=["\']https?:\/\/(?:www\.)?vimeo\.com\/(\d+)["\'][^>]*rel=["\']canonical["\']/i',
			'/property=["\']og:url["\'][^>]*content=["\']https?:\/\/(?:www\.)?vimeo\.com\/(\d+)["\']/i',
			'/content=["\']https?:\/\/(?:www\.)?vimeo\.com\/(\d+)["\'][^>]*property=["\']og:url["\']/i',
			'/player\.vimeo\.com\/video\/(\d+)/i',
			'/vimeo\.com\/(\d{6,})/i',
		];

		foreach ($patterns as $pattern) {
			if (preg_match($pattern, $html, $matches)) {
				$videoId = $matches[1];
				return [
					'video_id' => $videoId,
					'video' => 'https://vimeo.com/' . $videoId,
				];
			}
		}

		return null;
	}

	public function rendered_view(Request $request, $path = "")
	{
		$page_data = array();
		foreach ($request->all() as $key => $value) :
			$page_data[$key] = $value;
		endforeach;

		return view($path, $page_data)->render();
	}
}
