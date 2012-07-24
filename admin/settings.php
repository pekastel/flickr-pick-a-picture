<?php

// Default API KEY
define( 'PICKAPIC_FLICKR_API_KEY', 'b9f0d341e3aab89a09e84c6d88d50539' );

// Default Flickr image size
define( 'PICKAPIC_DEFAULT_FLICKR_IMG_SIZE', 'Medium' );

// Flickr image sizes
define ("FLICKR_IMG_SIZES", serialize ( array (
    'Square' => 0,
    'Large Square' => 0,
    'Thumbnail' => 0,
    'Small' => 0,
    'Small 320' => 0,
    'Medium' => 0, 
    'Medium 640' => 0,
    'Medium 800' => 0,
    'Large' => 0,
    'Original' => 0 
)));

/**
 * Add the options page for the plugin.
 **/
function pac_pickapic_admin_add_page() {
    add_options_page('Flickr - Pick a Picture Plugin Settings', 'Flickr - Pick a Picture', 'manage_options', 'pac_pickapic_settings', 'pac_pickapic_options_page');
}
add_action('admin_menu', 'pac_pickapic_admin_add_page');

/**
 * 
 **/
function pac_pickapic_admin_init(){
    register_setting( 'pac_pickapic_options', 'pac_pickapic_options', 'pac_pickapic_options_validate' );
    // Flickr Section.
    add_settings_section('pac_pickapic_flickr', __('Flickr Settings','pickapic'), 'pac_pickapic_flickr_section_text', 'pac_pickapic_settings');
    // Flickr Settings.
    add_settings_field('pac_pickapic_flickr_api_key-id', __('API Key','pickapic'), 'pac_pickapic_render_flickr_apikey', 'pac_pickapic_settings', 'pac_pickapic_flickr');
    add_settings_field('pac_pickapic_flickr_image_size-id', __('Default Image Size','pickapic'), 'pac_pickapic_render_flickr_image_size', 'pac_pickapic_settings', 'pac_pickapic_flickr');
}
add_action('admin_init', 'pac_pickapic_admin_init');

/**
 * Plugin options page.
 **/
function pac_pickapic_options_page() {
?>
    <div class="wrap">
    <div id="icon-options-general" class="icon32"><br></div>
    <h2><?php _e('Flickr - Pick a Picture','pickapic'); ?></h2>
    <form action="options.php" method="post">
        <?php settings_fields('pac_pickapic_options'); ?>
        <?php do_settings_sections('pac_pickapic_settings'); ?>

        <p class="submit">
        <input class="button-primary" name="Submit" id="submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
        </p>
    </form>
    </div>
<?php
}

/**
 * 
 **/
function pac_pickapic_flickr_section_text(){
    echo "<p>".__('Flickr options used in the plugin','pickapic')."</p>";
}

/**
 * Renders the flickr apikey input field.
 **/
function pac_pickapic_render_flickr_apikey(){
    $options = get_option('pac_pickapic_options',array('flickrapikey' => PICKAPIC_FLICKR_API_KEY));
    echo "<input id='pac_pickapic_flickr_api_key-id' name='pac_pickapic_options[flickrapikey]' size='40' type='text' value='{$options['flickrapikey']}' />";
}

/**
 * Renders the flickr default image size select field
 **/
function pac_pickapic_render_flickr_image_size(){
    $options = get_option('pac_pickapic_options',array('flickrimgsize' => PICKAPIC_DEFAULT_FLICKR_IMG_SIZE));

    $select_options = unserialize (FLICKR_IMG_SIZES);
    // Set as selected the image size defined.
    $select_options[$options['flickrimgsize']] = 1;
    ?>
    <select id='pac_pickapic_flickr_image_size-id' name='pac_pickapic_options[flickrimgsize]' value='<?php echo $options['flickrimgsize']; ?>'>
        <?php foreach ($select_options as $key => $selected): ?>
            <option <?php if ($selected) echo "selected='selected';"; ?>value='<?php echo $key; ?>'><?php echo $key; ?></option>
        <?php endforeach; ?>
    </select>
    <?php
}

/**
 * Validates user input.
 **/
function pac_pickapic_options_validate($input){
    $options = get_option('pac_pickapic_options');

    if(preg_match('/^[a-z0-9]{32}$/i', $input['flickrapikey'])) {
        $options['flickrapikey'] = trim($input['flickrapikey']);
    }

    if( in_array($input['flickrimgsize'], unserialize(FLICKR_IMG_SIZES)) ) {
        $options['flickrimgsize'] = $input['flickrimgsize'];
    }

    return $options;
}

?>
