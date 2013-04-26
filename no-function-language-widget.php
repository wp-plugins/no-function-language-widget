<?php
/*
Plugin Name: No Function Language Widget
Plugin URI: http://wordpress.org/extend/plugins/no-function-language-widget
Description: It produces an output of a language changing widget but has no additional features behind it.
Author: wp-plugin-dev.com
Version: 1.0
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Author URI: http://www.wp-plugin-dev.com/



You are free to use it or modify it for clients, as long as you keep the name wp-plugin-dev.com .

Flags by Copyright (c) 2013 Go Squared Ltd. http://www.gosquared.com/

*/






function contains($substring, $string) {
        $pos = strpos($string, $substring);
 
        if($pos === false) {
                // string needle NOT found in haystack
                return false;}
        else {
        		// string needle found in haystack
                return true;
        }
 
}
 
class no_function_language_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'no_function_language_widget', // Base ID
			'NFWL', // Name
			array( 'description' => __( 'A No Function Language Changer', 'text_domain' ), ) // Args
		);
	}


	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', __($instance['title'] ));
		$all_languages = $instance['nflw_languages'];
		$nflw_languages = explode(",", $all_languages);
		$langbase= $instance['nflw_language_base'];
		

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
			
			$lansum=count($nflw_languages);
			$i=0;
			if ($langbase=="?lang=")
			{
			
		while ($i<$lansum ){
		?><a href="?lang=<?php echo $nflw_languages[$i]; ?>"> <img src="<?php echo ''.plugin_dir_url( $file ).'no-function-language-widget/flags/'.$nflw_languages[$i].'.png'; ?>"></a> <?php
		$i++;}
		}
		else { 
		
		
		
			while ($i<$lansum ){
			
			
			
			
			$this_wp = ''.get_bloginfo('wpurl').'';
			$this_url ="http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$this_post = str_replace($this_wp ,"", $this_url);
			
			
	
		//checkblock 1.5
			$j=0;
			while($j<$lansum) {
			$this_url_lang=''.$this_wp.'/'.$nflw_languages[$j].'/';
			
			if ($this_url_lang==$this_url)
			{$language_set=true;}
			else {$language_set=false;}
			
			$current_language = "/".$nflw_languages[$j]."/";
			if (contains($current_language, $this_url))
			{$language_set=true;}
			else {$language_set=false;}
			
			if($language_set==true)
			{$choozen_language_URL=="";
			$this_post = str_replace($this_url_lang ,"", $this_url);
			//$this_post = str_replace($current_language ,"", $this_post);
			}
			else {}
			$j++;
			}
			
			
			
			if($nflw_languages[$i]==$nflw_languages[0])
			{
			$choozen_language_URL=''.get_bloginfo('wpurl').'/';
			//default language hack
			}
			else
			{
			$choozen_language_URL=''.get_bloginfo('wpurl').'/'.$nflw_languages[$i].'';//.$this_post;
			//Artikel nicht in Landessprache Hack
			}
			$language_set=false;
			

		?><a href="<?php echo $choozen_language_URL ?>"> <img src="<?php echo ''.plugin_dir_url( $file ).'no-function-language-widget/flags/'.$nflw_languages[$i].'.png'; ?>"></a> <?php
		$i++;}
		
		}
		//echo ' -> your url '.$this_post.'';
		echo $after_widget;

	}


	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['nflw_languages'] = strip_tags( $new_instance['nflw_languages'] );
		$instance['nflw_language_base'] = strip_tags( $new_instance['nflw_language_base'] );
		return $instance;
	}


	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] )) {
			$title = __($instance[ 'title' ]);
			$nflw_languages = $instance[ 'nflw_languages' ];
			$nflw_language_base = $instance[ 'nflw_language_base' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
			$nflw_languages = __( 'en,de,tr,cz,nl,fi', 'text_domain' );
			$nflw_language_base = __( '/', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'nflw_languages' ); ?>">nfwl Languages</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'nflw_languages' ); ?>" name="<?php echo $this->get_field_name( 'nflw_languages' ); ?>" type="text" value="<?php echo esc_attr( $nflw_languages ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'nflw_language_base' ); ?>">nfwl Language base</label> <br>
		<input  id="<?php echo $this->get_field_id( 'nflw_language_base' ); ?>" name="<?php echo $this->get_field_name( 'nflw_language_base' ); ?>" type="radio" value="/" <?php if($nflw_language_base=="/"){echo ' checked';}?>/> /de <br>
		<input id="<?php echo $this->get_field_id( 'nflw_language_base' ); ?>" name="<?php echo $this->get_field_name( 'nflw_language_base' ); ?>" type="radio" value="?lang=" <?php if($nflw_language_base=="?lang="){echo ' checked';}?>/> ?lang=de
		</p>
		<?php 
	}

} // class no_function_language_widget
add_action( 'widgets_init', create_function( '', 'register_widget( "no_function_language_widget" );' ) );
?>