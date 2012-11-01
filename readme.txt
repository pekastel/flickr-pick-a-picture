=== Plugin Name ===
Contributors: pekastel
Donate link: http://www.3nodos.com.ar/
Tags: flickr, images, galleries, image, gallery, cc, creative-commons, photo, photos
Requires at least: 3.0
Tested up to: 3.4
Stable tag: 1.2.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Lets you pick a Creative Commons picture from Flickr and use it anywhere you want on your WordPress installation.

== Description ==

Lets you pick a Creative Commons picture from Flickr and use it anywhere you want on your WordPress installation.  The plugin will maintain  attribution to the original Flickr author to keep peace with the CC Attribution License.

This plugin makes use of the newest WordPress 3.4 feature that allows to embed html in image captions, and also is backward compatible with older version of wordpress as well.

Features:

1. Search photos from flickr with creative commons license by tag (since version 1.2 you can search by any type of license)
1. Preview image results.
1. Define the order of the search results.
1. Automatically add image caption that links back to the original flickr owner.
1. Lets you use the standard features provided by WordPress for image editing:
 * Image alignment.
 * Cropping.
 * Rotating.
 * Flipping.
 * Resizing.

== Installation ==

1. Upload the `flickr-pick-a-picture` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. You can quickly access the plugin on the new icon in the media bar.
2. Next you will have to type the search criteria.
3. This is the search result screen.
4. By clicking on one of the thumbnails you can see the picture.
5. Once a picture was chosen you can edit the image before inserting it into the post.
6. The embedded image maintains credits of the flickr owner.

== Changelog ==

= 1.2.3 =
* If CURL is not available the plugin will try with file_get_contents,  and if that fails report an error message to the user.


= 1.2.2 =
* Now you can choose to add the original photo license into the caption.

= 1.2.1 =
* file_get_contents() call replaced by the PHP Curl library, to circumvent problems on sites that does not enable the php.ini option "allow_url_fopen".

= 1.2 =
* Added support to search by license type.
* Now it's possible to define the results sort order.

= 1.1 =
* Added a new options page for the plugin with Flickr Api Key and Flickr Default Image Size (requested by Dan)
* Improved error handling when interacting with the Flickr Api.

= 1.0 =
* Initial Version

