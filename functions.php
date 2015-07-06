<?php

function pp_contextual_related_links_tags($content){
	if(is_singular('post')){
		$tags = get_the_tags();
		foreach($tags as $tag) {
    		$taglink = get_tag_link($tag->term_id);
    		$tagname = "/".$tag->name."/";
    		$replacement = "<a href='$taglink'>$tag->name</a>";
			$content = preg_replace($tagname, $replacement, $content, 1);
		}
	}
	return $content;
}

function pp_contextual_related_links_related_tags($content){
	if(is_singular('post')) {
		$postid = get_the_ID();
		$charstoremove = array("!", "#", "$", "%", "^", "*", "(", ")", "-", "[", "]", "{", "}", ":", ";", "?", "<", ">", "+", ",", ".");
		$textprepare = strip_tags($content);
		$textprepare = str_replace($charstoremove, "", $textprepare);
		$textprepare = explode(" ", $textprepare);
		foreach($textprepare as $tag){
			$args = array(
					'orderby' => 'date',
					'nopaging' => 'true',
					'posts_per_page' => 1,
					'tag_slug__in' => array($tag),
					'post__not_in' => array($postid)
			);
			$query = new WP_Query($args);
			if($query->have_posts()) {
			    $query->the_post();
			    $id = $query->post->ID;
			    $tagname = "/".$tag."/";
			    $postlink = get_permalink($id);
        		$replacement = "<a href='$postlink'>$tag</a>";
				$content = preg_replace($tagname, $replacement, $content, 1);
			    break;
			}
		}
		wp_reset_postdata();
	}
	return $content;
}

?>