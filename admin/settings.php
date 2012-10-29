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

// Default Flickr Licenses
define( 'PICKAPIC_FLICKR_LICENSES', '4%2C7' ); // those images with license 4 or 7 (http://www.flickr.com/services/api/flickr.photos.licenses.getInfo.html)

// Default Flickr sort order
define( 'PICKAPIC_FLICKR_SORT', 'relevance' );

// Flickr sort options
define ("PICKAPIC_FLICKR_SORT_OPTIONS", serialize ( array (
    'date-posted-asc' => array('Date Posted Asc',0),
    'date-posted-desc' => array('Date posted Desc',0), 
    'date-taken-asc' => array('Date taken Asc',0), 
    'date-taken-desc' => array('Date taken Desc',0), 
    'interestingness-desc' => array('Interestingness Desc',0), 
    'interestingness-asc' => array('Interestingness Asc',0), 
    'relevance' => array('Relevance',0)
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

    add_settings_field('pac_pickapic_flickr_licenses-id', __('Flickr Licenses','pickapic'), 'pac_pickapic_render_flickr_licenses', 'pac_pickapic_settings', 'pac_pickapic_flickr');

    add_settings_field('pac_pickapic_flickr_sort-id', __('Flickr Sort Order','pickapic'), 'pac_pickapic_render_flickr_sort_options', 'pac_pickapic_settings', 'pac_pickapic_flickr');
    
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
 * Renders the flickr licenses options.
 **/
function pac_pickapic_render_flickr_licenses(){
    $options = get_option('pac_pickapic_options',array('flickrlicenses' => PICKAPIC_FLICKR_LICENSES));
    $licenses = explode("%2C", $options['flickrlicenses']);
    ?>
    <form>
        <input name="pac_pickapic_options[flickrlicenses_4]" type="checkbox" <?php pac_pickapic_checkbox_selected(4, $licenses); ?> value="4">Attribution License<br>
        <input name="pac_pickapic_options[flickrlicenses_6]" type="checkbox" <?php pac_pickapic_checkbox_selected(6, $licenses); ?> value="6">Attribution-NoDerivs License<br>
        <input name="pac_pickapic_options[flickrlicenses_3]" type="checkbox" <?php pac_pickapic_checkbox_selected(3, $licenses); ?> value="3">Attribution-NonCommercial-NoDerivs License<br>
        <input name="pac_pickapic_options[flickrlicenses_2]" type="checkbox" <?php pac_pickapic_checkbox_selected(2, $licenses); ?> value="2">Attribution-NonCommercial License<br>
        <input name="pac_pickapic_options[flickrlicenses_1]" type="checkbox" <?php pac_pickapic_checkbox_selected(1, $licenses); ?> value="1">Attribution-NonCommercial-ShareAlike License<br>
        <input name="pac_pickapic_options[flickrlicenses_5]" type="checkbox" <?php pac_pickapic_checkbox_selected(5, $licenses); ?> value="5">Attribution-ShareAlike License<br>
        <input name="pac_pickapic_options[flickrlicenses_7]" type="checkbox" <?php pac_pickapic_checkbox_selected(7, $licenses); ?> value="7">No known copyright restrictions<br>
        <input name="pac_pickapic_options[flickrlicenses_0]" type="checkbox" <?php pac_pickapic_checkbox_selected(0, $licenses); ?> value="0">All Rights Reserved
    </form>
    <?php 
}

function pac_pickapic_checkbox_selected($option, $array){
    if (in_array($option, $array)) { 
        echo 'checked="checked"'; 
    } 
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
 * Renders the flickr sort options
 **/
function pac_pickapic_render_flickr_sort_options(){
    $options = get_option('pac_pickapic_options', array('flickrsort' => PICKAPIC_FLICKR_SORT));

    $flickr_sort_options = unserialize (PICKAPIC_FLICKR_SORT_OPTIONS);
    $flickr_sort_options[$options['flickrsort']][1] = 1;
    ?>
    <select id='pac_pickapic_flickr_sort-id' name='pac_pickapic_options[flickrsort]' value='<?php echo $options['flickrsort']; ?>'>
        <?php foreach ($flickr_sort_options as $key => $values): ?>
            <option <?php if ($values[1]) echo "selected='selected' "; ?>value='<?php echo $key; ?>'><?php echo $values[0]; ?></option>
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

    $flickrlicenses = "";
    for ($i=0; $i < 9 ; $i++) { 
        if ( isset($input['flickrlicenses_'.$i]) ) {
            if ( $flickrlicenses != "" ) {
                $flickrlicenses .= '%2C'.$input['flickrlicenses_'.$i];
            } else {
                $flickrlicenses = $input['flickrlicenses_'.$i];
            }
        }
    }

    // Validate that at least one license is selected.
    if ( $flickrlicenses != "" ) {
        $options['flickrlicenses'] = $flickrlicenses;
    } else {
        //add_settings_error('pac_pickapic_options', 'emptylicenses', __('Flickr licenses cannot be empty, restoring default values.'.$flickrlicenses,'pickapic'), 'updated');
        $options['flickrlicenses'] = PICKAPIC_FLICKR_LICENSES;
    }

    if ( $input['flickrsort'] ) {
        $options['flickrsort'] = $input['flickrsort'];
    }

    return $options;
}

?>
