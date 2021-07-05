<?php

use Illuminate\Support\Facades\Cache;

use function PHPUnit\Framework\returnSelf;

function active($url, $res, $group = null)
	{
		$url = $group ? request()->is($url) || request()->is($url.'/*') : request()->is($url);
		return $url ? $res : '';
	}

	function localDate($date)
	{
		return date('d M Y', strtotime($date));
	}

	function img($name)
	{
		return asset('storage/images/'.$name);
	}

	function site($key)
	{
		return Cache::get('site')->$key;
	}

	function sidebar_title() {
		$cache = Cache::get('site');
		if (@$cache->sidebar_title) return $cache->sidebar_title;

		$name = strtoupper(site('name'));
		$title = str_replace(['PERPUSTAKAAN', 'LIBRARY'], '', $name);
		while (!ctype_alnum($title[0])) {
			$title = substr($title, 1);
			$title = trim($title);
		}
		$cache->sidebar_title = $title;
		Cache::forever('site', $cache);
		return $title;
	}

 ?>