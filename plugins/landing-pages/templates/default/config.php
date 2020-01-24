<?php
/**
 * Default theme single.php template
 *
 * To customize your default landing page, create a single-landing-page.php and customize
 * http://docs.inboundnow.com/guide/creating-landing-page-default-template/
 *
 * DO NOT USE THE DEFAULT TEMPLATE FOR INNOVATING NEW THEMES! Instead use the demo template or any other the others
 */

do_action('lp_global_config'); // global config action hook

//gets template directory name to use as identifier - do not edit - include in all template files
$key = basename(dirname(__FILE__));

$lp_data[$key]['info'] =
array(
	'data_type' => 'template',
	'version' => "1.0.1",
	'label' => "Current Theme Template",
	'category' => 'Theme',
	'demo' => 'http://docs.inboundnow.com/guide/creating-landing-page-default-template/',
	'description'  => 'This template uses your current wordpress theme. To customize your default landing page, create a single-landing-page.php and customize more info: http://docs.inboundnow.com/landing-pages/dev/creating-templates/default-wp-themes'
);

// Define Meta Options for template
// These values are returned in the template's index.php file with lp_get_value($post, $key, 'field-id') function
$lp_data[$key]['settings'] =
array(
    array(
        'label' => 'Default Instructions', // Name of field
        'description' => "<strong><u>Default Template Instructions</u></strong><br> This landing page template uses the single.php file of your current active theme. You might need to customize some components to get it looking the way you want. <a href=\"#\" onClick=\"window.open('http://www.youtube.com/embed/pQzmx4ooL1M?autoplay=1','landing-page','width=640,height=480,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,copyhistory=no,resizable=no')\">Watch Video Explanation</a>", // what field does
        'id' => 'description', // metakey. $key Prefix is appended from parent in array loop
        'type'  => 'description-block', // metafield type
        'default'  => '', // default content
        'context'  => 'normal' // Context in screen (advanced layouts in future)
        ),
     array(
       'label' => "Default Content",
       'description' => "This is the default content from template.",
       'id' => "default-content",
       'type' => "default-content",
       'default' => '<p>This is the first paragraph of your landing page. You want to grab the visitors attention and describe a commonly felt problem that they might be experiencing. Try and relate to your target audience and draw them in.</p>
[list icon="check" font_size="16" icon_color="#00a319" text_color="" bottom_margin="10"]
<h3>In this guide you will learn:</h3>
<ul>
    <li>This list was created with the list icon shortcode.</li>
    <li>Click on the power icon in your editor to customize your own</li>
    <li>Explain why users will want to fill out the form</li>
    <li>Keep it short and sweet.</li>
    <li>This list should be easily scannable</li>
</ul>
[/list]
<p>This is the final sentence or paragraph reassuring the visitor of the benefits of filling out the form and how their data will be safe.</p>'
     ),

    array(
        'label' => 'Conversion/Form Placement', // Label of field
        'description' => "Where should the conversion area show on the page? When setting to 'Use Widget' make sure that the 'Conversion Area Widget' is added to the 'Landing Page Sidebar' for the conversion area to display properly.", // field description
        'id' => 'conversion-area-placement', // metakey.
        'type'  => 'dropdown', // text metafield type
        'default'  => 'widget', // default content
        'options' => array('widget'=>'Use Sidebar Widget (default)','right'=>'Float Form Area Right', 'left'=>'Float Form Area Left','bottom'=>'Insert Below Content','top'=>'Insert Above Content'), // options for radio
        'context'  => 'normal' // Context in screen for organizing options
        ),
    array(
        'label' => "Navigation Settings",
        'description' => "Toggle the regular navigation on or off with this setting. It's highly recommended that you turn off your page navigation to increase conversion rates on your landing page",
        'id'  => 'lp_hide_nav',
        'type'  => 'dropdown',
        'default'  => 'off',
        'options' => array('off'=>'Hide Navigation (recommended)','on'=>'Show Navigation'),
        'context'  => 'normal'
        )
);

?>