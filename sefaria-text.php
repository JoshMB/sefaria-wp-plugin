<?php
/**
 * Plugin Name: Sefaria Text Insert
 * Plugin URI: http;//sefaria.org
 * Description: Insert text from the Sefaria database.
 * Version: 1.0
 * Author: Josh Mason-Barkin
 * Author URI: http://sefaria.org
 */

//Create Settings Page
add_action('admin_menu', 'sef_text_settings_menu');

function sef_text_settings_menu() {
	add_options_page('Sefaria Text Insert - Settings', 'Sefaria Insert', 'manage_options', 'sef_text_settings', 'sef_text_settings_page');
}

add_action( 'admin_init', 'sef_text_settings' );

//Register the Settings
function sef_text_settings() {
	register_setting( 'sef_text_settings', 'sef_hebrew_color' );
	register_setting( 'sef_text_settings', 'sef_english_color' );
	register_setting( 'sef_text_settings', 'sef_source_color' );
}

//Setup the Page Itself
function sef_text_settings_page() {
?>
<div class="wrap">
<h2>Sefaria Text Insert - Settings</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'sef_text_settings' ); ?>
    <?php do_settings_sections( 'sef_text_settings' ); ?>
    <table class="form-table">        
        <tr valign="top">
        <th scope="row">Hebrew Color</th>
        <td><input type="text" name="sef_hebrew_color" value="<?php echo esc_attr( get_option('sef_hebrew_color') ); ?>" /></td>
        </tr>
		<tr valign="top">
        <th scope="row">English Color</th>
        <td><input type="text" name="sef_english_color" value="<?php echo esc_attr( get_option('sef_english_color') ); ?>" /></td>
        </tr>
		<tr valign="top">
        <th scope="row">Source Citation Color</th>
        <td><input type="text" name="sef_source_color" value="<?php echo esc_attr( get_option('sef_source_color') ); ?>" /></td>
        </tr>
    </table>
    <?php submit_button(); ?>
</form>
</div>

<?php
}

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
        var hebcolor = fromPHP(<?php echo json_encode(get_option('sef_hebrew_color')); ?>);
        var engcolor = fromPHP(<?php echo json_encode(get_option('sef_english_color')); ?>);
        var sourcecolor = fromPHP(<?php echo json_encode(get_option('sef_source_color')); ?>);
        var shortcode = '<blockquote class="textual"><span class="hebrew-text" style="color:'+hebcolor+';">'+response.he+'</span> <span class="text-english" style="color:'+engcolor+';">'+response.text+'</span><cite class="text-source" style="color:'+sourcecolor+';">'+response.ref+'</cite></blockquote> <span>&nbsp;</span>';
          
          if( !tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden()) {
			var currentText = jQuery('textarea#content').val();
			jQuery('textarea#content').val(currentText+" "+shortcode);
          } else {
            tinyMCE.execCommand('mceInsertContent', false, shortcode);
          }
          //close the thickbox after adding shortcode to editor
          self.parent.tb_remove();
    },
    error: function (xhr, string, thrownError) {
        alert('Error. Usually this is due to an unknown reference');
      }
});
      
  
  
  
  
  
});

</script>
<?php
}