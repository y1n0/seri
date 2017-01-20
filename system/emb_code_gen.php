<?php
function url_treat($url, $operation){
	switch (true) {
		case preg_match('#youtube#', $url):
			$id = explode("v=", $url)[1];
			$id = explode("&", $id)[0];

			if ($operation === 'emb_code')
				$toreturn = '<iframe type="text/html" src="http://www.youtube.com/embed/'.$id.'" frameborder="0" id="ytplayer" class="vid-emb" webkitallowfullscreen mozallowfullscreen allowfullscreen style="border: 1px solid;"></iframe>';
			elseif ($operation === 'thumbnail')
				$toreturn = 'http://img.youtube.com/vi/'.$id.'/hqdefault.jpg';

			break;

		case preg_match('#vimeo#', $url):
			$id = explode("vimeo.com/", $url)[1];
			$id = explode("/", $id)[0];

			if ($operation === 'emb_code')
				$toreturn = '<iframe src="http://player.vimeo.com/video/'.$id.'?&color=000&badge=0&byline=0&portrait=0&title=0" frameborder="0" class="vid-emb" webkitallowfullscreen mozallowfullscreen allowfullscreen style="border: 1px solid;" ></iframe>';
			elseif ($operation === 'thumbnail')
				$toreturn = unserialize(file_get_contents('https://vimeo.com/api/v2/video/'.$id.'.php'))[0]['thumbnail_large'];
			
			break;
		
		default:
			$toreturn = "default";
			break;
	}

return $toreturn;
}


?>