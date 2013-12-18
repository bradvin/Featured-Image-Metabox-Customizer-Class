Featured Image Metabox Customizer Class
=======================================

A class to help override the Featured Image Metabox in WordPress

## Usage ##
Include the class and instantiate a new instance passing in the post type you want to change and the new values to show in the featured image metabox:

```
require_once 'class-featured-image-metabox-cusomizer.php';

new Featured_Image_Metabox_Customizer(array(
	'post_type'     => 'company',
	'metabox_title' => __( 'Company Logo', 'my-plugin-slug' ),
	'set_text'      => __( 'Set Company logo', 'my-plugin-slug' ),
	'remove_text'   => __( 'Remove Company logo', 'my-plugin-slug' )
));
```

## Example Plugin ##

Check out plugin-featured-image-metabox-customizer.php for an example plugin.