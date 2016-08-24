<?php
/**
 * Plugin Name: Sefaria Text Insert
 * Plugin URI: http;//sefaria.org
 * Description: Insert text from the Sefaria database.
 * Version: 1.0
 * Author: Josh Mason-Barkin
 * Author URI: http://sefaria.org
 */

//Load CSS for Backend
add_action( 'admin_print_styles', 'go_to_the_head' );
function go_to_the_head() {
	
	// Get current screen and determine if we are using the editor
    $screen = get_current_screen();
    // If we are editing (adding new) post or page
    if ( $screen->id == 'page' || $screen->id == 'post' ) {

	    wp_register_style( 'sefaria-text-styles', plugin_dir_url( __FILE__ ) . 'css/text-styles.css','','', 'all' );
	    wp_register_style( 'sefaria-ui-styles', plugin_dir_url( __FILE__ ) . 'css/ui-styles.css','','', 'all' );
	 
	    wp_enqueue_style( 'sefaria-text-styles' );
	    wp_enqueue_style( 'sefaria-ui-styles' );
	}
}

add_action( 'wp_enqueue_scripts', 'sef_style_load' );
function sef_style_load() {
	    wp_register_style( 'sefaria-text-styles', plugin_dir_url( __FILE__ ) . 'css/text-styles.css','','', 'all' );
	    wp_enqueue_style( 'sefaria-text-styles' );
}

//add the linker
function sef_linker() {
    echo '<script type="text/javascript" charset="utf-8" src="http://sefaria.org/linker.js"></script><script>sefaria.link({mode: "link", }) </script>';}
add_action( 'wp_footer', 'sef_linker' );


//Editor CSS
function plugin_mce_css( $mce_css ) {
  if ( !empty( $mce_css ) )
    $mce_css .= ',';
    $mce_css .= plugins_url( 'css/text-styles.css', __FILE__ );
    return $mce_css;
  }
add_filter( 'mce_css', 'plugin_mce_css' );

//Customizer
function sef_customize_register( $wp_customize ) {
  //All our sections, settings, and controls will be added here
}
add_action( 'customize_register', 'sef_customize_register' );

/*Add this code to your functions.php file of current theme OR plugin file if you're making a plugin*/
//add the button to the tinymce editor
add_action('media_buttons_context','add_my_tinymce_media_button');
function add_my_tinymce_media_button($context){

return $context.=__("
<a href=\"#TB_inline?width=480&inlineId=my_shortcode_popup&width=640&height=513\" class=\"button thickbox\" id=\"sefaria_button\" title=\"Add a Text\"><span class=\"icon-sefaria\"></span>Add a Text</a>");
}

add_action('admin_footer','my_shortcode_media_button_popup');
//Generate inline content for the popup window when the "my shortcode" button is clicked
function my_shortcode_media_button_popup(){?>
  <div id="my_shortcode_popup" style="display:none;">
    <!--".wrap" class div is needed to make thickbox content look good-->
    <div class="wrap">
      <div>
        <h2>Enter a Text Reference</h2>
        <p>For example: <strong>Ex. 12:2-8</strong> or <strong>Sanhedrin 4b</strong>.</p><p><a href="https://github.com/Sefaria/Sefaria-Project/wiki/Text-References" target="_blank">Read more about text references. (Opens in new tab/window.)</a></p>
        <div class="my_shortcode_add">
          <input type="text" id="id_of_textbox_user_typed_in"><button class="button-primary" id="id_of_button_clicked">Add Source</button>
        </div>
      </div>
    </div>
  </div>
<?php
}

//javascript code needed to make shortcode appear in TinyMCE edtor
add_action('admin_footer','my_shortcode_add_shortcode_to_editor');
function my_shortcode_add_shortcode_to_editor(){?>
<script>
jQuery('#id_of_button_clicked ').on('click',function(){

  var user_content = jQuery('#id_of_textbox_user_typed_in').val();
  var getStr = "http://www.sefaria.org/api/texts/" + user_content + "?commentary=0&context=0&pad=0";


jQuery.ajax({
    url: getStr,
 
    // Tell jQuery we're expecting JSONP
    dataType: "jsonp",

    // Work with the response
    success: function( response ) {
        var shortcode = '<blockquote class="textual"><span class="hebrew-text">'+response.he+'</span> <span class="text-english">'+response.text+'</span><cite class="text-source">'+response.ref+' </cite></blockquote>';
          
          if( !tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden()) {
            jQuery('textarea#content').val(shortcode);
          } else {
            tinyMCE.execCommand('mceInsertContent', false, shortcode);
          }
          //close the thickbox after adding shortcode to editor
          self.parent.tb_remove();

    }
});
      
  
  
  
  
  
});

</script>
<?php
}