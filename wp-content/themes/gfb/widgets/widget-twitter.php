<?php class TwitterWidget extends WP_Widget {

	function TwitterWidget() {
		$widget_ops = array('classname' => 'widget_latest_tweets', 'description' => __( 'Displays a list of twitter feeds', TEMPLATENAME ) );
		$this->WP_Widget(false, __('Twitter +', TEMPLATENAME), $widget_ops);

		if ( is_active_widget(false, false, $this->id_base) ){
			add_action( 'wp_print_scripts', array(&$this, 'add_tweet_script') );
		}

	}

	function add_tweet_script(){
		wp_enqueue_script('js_twitter');
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Tweets', TEMPLATENAME) : $instance['title'], $instance, $this->id_base);
		$username= $instance['username'];
		$count = (int)$instance['count'];

		if($count < 1){
			$count = 1;
		}

		if ( !empty( $username ) ) {
			echo $before_widget;
			if ( $title)
				echo $before_title . $title . $after_title;

		$id = rand(1,1000);
		    $hash = md5(rand(1, 999));
						
						//$twitter_id='345111976353091584';
						$twitter_id='385069522157182977';
						$limit=$count;
    ?>

		
		<script>
      
      var twitterFetcher=function(){function t(d){return d.replace(/<b[^>]*>(.*?)<\/b>/gi,function(c,d){return d}).replace(/class=".*?"|data-query-source=".*?"|dir=".*?"|rel=".*?"/gi,"")}function m(d,c){for(var f=[],e=RegExp("(^| )"+c+"( |$)"),g=d.getElementsByTagName("*"),b=0,a=g.length;b<a;b++)e.test(g[b].className)&&f.push(g[b]);return f}var u="",j=20,n=!0,h=[],p=!1,k=!0,l=!0,q=null,r=!0;return{fetch:function(d,c,f,e,g,b,a){void 0===f&&(f=20);void 0===e&&(n=!0);void 0===g&&(g=!0);void 0===b&&(b=!0);
      void 0===a&&(a="default");p?h.push({id:d,domId:c,maxTweets:f,enableLinks:e,showUser:g,showTime:b,dateFunction:a}):(p=!0,u=c,j=f,n=e,l=g,k=b,q=a,c=document.createElement("script"),c.type="text/javascript",c.src="//cdn.syndication.twimg.com/widgets/timelines/"+d+"?&lang=en&callback=twitterFetcher.callback&suppress_response_codes=true&rnd="+Math.random(),document.getElementsByTagName("head")[0].appendChild(c))},callback:function(d){var c=document.createElement("div");c.innerHTML=d.body;"undefined"===
      typeof c.getElementsByClassName&&(r=!1);var f=d=null,e=null;r?(d=c.getElementsByClassName("e-entry-title"),f=c.getElementsByClassName("p-author"),e=c.getElementsByClassName("dt-updated")):(d=m(c,"e-entry-title"),f=m(c,"p-author"),e=m(c,"dt-updated"));for(var c=[],g=d.length,b=0;b<g;){if("string"!==typeof q){var a=new Date(e[b].getAttribute("datetime").replace(/-/g,"/").replace("T"," ").split("+")[0]),a=q(a);e[b].setAttribute("aria-label",a);if(d[b].innerText)if(r)e[b].innerText=a;else{var s=document.createElement("p"),
      v=document.createTextNode(a);s.appendChild(v);s.setAttribute("aria-label",a);e[b]=s}else e[b].textContent=a}n?(a="",l&&(a+='<div class="user">'+"</div>"),a+='<p class="tweet">'+t(d[b].innerHTML)+"</p>",k&&(a+='<p class="timePosted">'+e[b].getAttribute("aria-label")+"</p>")):d[b].innerText?(a="",l&&(a+='<p class="user">'+f[b].innerText+"</p>"),a+='<p class="tweet">'+d[b].innerText+"</p>",k&&(a+='<p class="timePosted">'+e[b].innerText+"</p>")):(a="",l&&(a+='<p class="user">'+f[b].textContent+
      "</p>"),a+='<p class="tweet">'+d[b].textContent+"</p>",k&&(a+='<p class="timePosted">'+e[b].textContent+"</p>"));c.push(a);b++}c.length>j&&c.splice(j,c.length-j);d=c.length;f=0;e=document.getElementById(u);for(g="<ul>";f<d;)g+="<li>"+c[f]+"</li>",f++;e.innerHTML=g+"</ul>";p=!1;0<h.length&&(twitterFetcher.fetch(h[0].id,h[0].domId,h[0].maxTweets,h[0].enableLinks,h[0].showUser,h[0].showTime,h[0].dateFunction),h.splice(0,1))}}}();


      /*
      * ### HOW TO CREATE A VALID ID TO USE: ###
      * Go to www.twitter.com and sign in as normal, go to your settings page.
      * Go to "Widgets" on the left hand side.
      * Create a new widget for what you need eg "user timeline" or "search" etc. 
      * Feel free to check "exclude replies" if you dont want replies in results.
      * Now go back to settings page, and then go back to widgets page, you should
      * see the widget you just created. Click edit.
      * Now look at the URL in your web browser, you will see a long number like this:
      * 345735908357048478
      * Use this as your ID below instead!
      */

    
      twitterFetcher.fetch('<?php echo $twitter_id; ?>', 'tweets_<?php  echo $hash ?>', <?php echo $limit; ?>, true);


  
      function dateFormatter(date) {
        return date.toTimeString();
      }
    </script>
	<div id="tweets_<?php  echo $hash ?>" ></div>

		<?php
			echo $after_widget;
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['username'] = strip_tags($new_instance['username']);
		$instance['count'] = (int) $new_instance['count'];

		return $instance;
	}

	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$username = isset($instance['username']) ? esc_attr($instance['username']) : '385069522157182977';
		$count = isset($instance['count']) ? absint($instance['count']) : 3;
		$display = isset( $instance['display'] ) ? $instance['display'] : 'latest';
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', TEMPLATENAME); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Twitter ID:', TEMPLATENAME); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('How many tweets to display?', TEMPLATENAME); ?></label>
		<input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" size="3" /></p>

<?php
	}
}

function TwitterWidgetInit() {
  register_widget('TwitterWidget');
}

add_action('widgets_init', 'TwitterWidgetInit');

?>