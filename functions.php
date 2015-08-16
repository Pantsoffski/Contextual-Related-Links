<?php

function pp_contextual_related_links_tags($content){ //links all tags from post/page found in viewed content
	if(is_singular('post')){
		$contentlenght = strlen($content) / 2; //lenght of contet / 2
        $content1 = substr($content, 0, $contentlenght); //first half of content
        $content2 = substr($content, $contentlenght); //second half of content
		$tags = get_the_tags(); //returns tags assigned to the post
		foreach($tags as $tag) {
    		$taglink = get_tag_link($tag->term_id);
    		$tagname[] = "/".$tag->name."/i";
    		$tagnameold = "/".$tag->name."/i";
    		$searchedword = preg_match_all($tagnameold, $content, $match);
    		foreach($match as $match2){ //create arrays with keywords to replace and replacement
				foreach($match2 as $match3){
					$replacement[] = "<a href='$taglink'>$match3</a>";
					$macher[] = "/".$match3."/";
				}
			}
		}
		$replacement = array_unique($replacement); //removes duplicate array values
		$macher = array_unique($macher);
	    		if(get_option('contextual_related_links_links_where')==1){ //if user wants first half of content
					$content = preg_replace($macher, $replacement, substr($content, 0, $contentlenght), get_option('contextual_related_links_links_how_many'));
					$content = $content.$content2;
				}elseif(get_option('contextual_related_links_links_where')==2){ //if user wants second half of content
						$content = preg_replace($macher, $replacement, substr($content, $contentlenght), get_option('contextual_related_links_links_how_many'));
						$content = $content1.$content;
				}else{ //if user wants entire content
						$content = preg_replace($macher, $replacement, $content, get_option('contextual_related_links_links_how_many'));
				}
	}
	return $content;
}

function pp_contextual_related_links_related_tags($content){
	if(is_singular('post')) {
		$postid = get_the_ID();
		$contentlenght = strlen($content) / 2; //lenght of contet / 2
        $content1 = substr($content, 0, $contentlenght); //first half of content
        $content2 = substr($content, $contentlenght); //second half of content
		$charstoremove = array("!", "#", "$", "%", "^", "*", "(", ")", "-", "[", "]", "{", "}", ":", ";", "?", "<", ">", "+", ",", ".");
		$textprepare = strip_tags($content);
		$textprepare = str_replace($charstoremove, "", $textprepare);
		$textprepare = explode(" ", $textprepare); //put words to array
		foreach($textprepare as $tag){
			$args = array(
					'orderby' => 'date',
					'nopaging' => 'true',
					'posts_per_page' => 1,
					'tag_slug__in' => array($tag),
					'post__not_in' => array($postid)
			);
			$query = new WP_Query($args);
			if($query->have_posts()){
			    $query->the_post();
			    $id = $query->post->ID;
			    $tagname = "/".$tag."/";
			    $postlink = get_permalink($id);
        		$replacement = "<a href='$postlink'>$tag</a>";
        		if(get_option('contextual_related_links_links_where')==1){ //if user wants first half of content
					$content = preg_replace($tagname, $replacement, substr($content, 0, $contentlenght), get_option('contextual_related_links_links_how_many'));
					$content = $content.$content2;
				}elseif(get_option('contextual_related_links_links_where')==2){ //if user wants second half of content
					$content = preg_replace($tagname, $replacement, substr($content, $contentlenght), get_option('contextual_related_links_links_how_many'));
					$content = $content1.$content;
				}else{ //if user wants entire content
					$content = preg_replace($tagname, $replacement, $content, get_option('contextual_related_links_links_how_many'));
				}
			}
		}
		wp_reset_postdata();
	}
	return $content;
}

function pp_contextual_related_links_related_posts_with_tags($content){
	if(is_singular('post')) {
		$postid = get_the_ID();
		$tags = get_tags(); //retrieve all tags
		foreach($tags as $tag){
			$tagname = "/".$tag->name."/i";
			$tagstoignore = pp_contextual_related_links_ignored_tags_ids();
			if(preg_match($tagname, $content, $match)){ //if tag is inside content
				$args = array( //arguments for WP_Query
					'orderby' => 'date',
					'nopaging' => 'true',
					'posts_per_page' => 1,
					'tag_slug__in' => array($tag->name),
					'post__not_in' => array($postid),
					'tag__not_in' => $tagstoignore
				);
				$query = new WP_Query($args);
				if($query->have_posts()){ //if WP-Query have posts
				    $query->the_post();
				    $id = $query->post->ID;
				    $postlink = get_permalink($id);
	        		$replacement = "<a href='$postlink'>$match[0]</a>";
					$content = preg_replace($tagname, $replacement, $content, get_option('contextual_related_links_links_how_many'));
				}
			}
		}
	}
	wp_reset_postdata();
	return $content;
}

function pp_contextual_related_links_ignored_tags_ids(){
	$ignoredtags = esc_attr(get_option('contextual_related_links_banned_tags'));
	$search = "/(,\s+)|(\s+,)|(\s+)/i";
	$ignoredtags = preg_replace($search, ",", $ignoredtags);
	$ignoredtags = explode(",", $ignoredtags);
	foreach($ignoredtags as $tag){
		$tags = get_term_by('name', "$tag", 'post_tag');
		if($tags){
			$tagsid[] = $tags->term_id;
		}
	}
	if(!isset($tagsid)){
		$tagsid = array(); 
	}
	return $tagsid;
}

function pp_contextual_related_links_included_tags(){
	$includedtags = esc_attr(get_option('contextual_related_links_include_tags'));
	$search = "/(,\s+)|(\s+,)|(\s+)/i";
	$includedtags = preg_replace($search, ",", $ignoredtags);

	return $includedtags;
}

?>