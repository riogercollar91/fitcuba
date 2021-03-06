=== Cache Enabler - WordPress Cache ===
Contributors: keycdn
Tags: cache, caching, wordpress cache, performance, gzip, webp, http2
Requires at least: 4.1
Tested up to: 4.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html



A lightweight caching plugin for WordPress that makes your website faster by generating static HTML files plus WebP support.



== Description ==

= WordPress Cache Engine =
The Cache Enabler plugin creates static HTML files and stores them on the servers disk. The web server will deliver the static HTML file and avoids the resource intensive backend processes (core, plugins and database). This WordPress cache engine will improve the performance of your website.


= Features =
* Efficient and fast disk cache engine
* Automated and/or manual clearing of the cache
* Display of the actual cache size in your dashboard
* Minification of HTML and inline JavaScript
* WordPress multisite support
* Custom Post Type support
* Expiry Directive
* Support of *304 Not Modified* if the page has not modified since last cached
* WebP Support (when combined with [Optimus](https://optimus.io/en/ "Optimus"))
* Supports responsive images via srcset since WP 4.4
* HTTP/2 Focused

> Cache Enabler is the first WP plugin to allow you to serve WebP images without JavaScript and also fully supports srcset since WP 4.4. WebP is a new image format that provides lossless and lossy compression for images on the web. WebP lossless images are [26% smaller](https://developers.google.com/speed/webp/docs/webp_lossless_alpha_study#results "webp lossless alpha study") in size compared to PNGs.


= How does the caching work? =
This plugin requires minimal setup time and allows you to easily take advantage of the benefits that come from using Wordpress caching.

The Wordpress Cache Enabler has the ability to create 2 cached files. One is plain HTML and the other version is gzipped (gzip level 9). These static files are then used to deliver content faster to your users directly via PHP without any database lookups or gzipping as the files are already pre-compressed. You can use our [advanced configuration snippets](https://www.keycdn.com/support/wordpress-cache-enabler-plugin/#advanced-configuration "WP cache config snippet") to even *bypass PHP* calls required to fetch the static HTML files.

When combined with Optimus, the Wordpress Cache Enabler allows you to easily deliver WebP images. The plugin will check your wp-content/uploads directory for any JPG or PNG images that have an equivalent WebP file. If there is, the URI of these image will be cached in a WebP static file by Cache Enabler. It is not required for all images to be converted to WebP when the "Create an additional cached version for WebP image support" option is enabled. This will not break any images that are not in WebP format. The plugin will deliver images that do have a WebP equivalent and will fall back to the JPG or PNG format for images that don't.


= Support =
Just [contact us](https://www.keycdn.com/contacts "Support Request") directly to get support on this plugin.


= System Requirements =
* PHP >=5.3
* WordPress >=4.1


= Website =
* [WordPress Cache Enabler - Documentation](https://www.keycdn.com/support/wordpress-cache-enabler-plugin/ "WordPress Cache Enabler - Documentation")


= Maintainer =
* [Twitter](https://twitter.com/keycdn)
* [Google+](https://plus.google.com/+Keycdn "Google+")
* [KeyCDN](https://www.keycdn.com "KeyCDN")


= Credits =
This WordPress cache plugin is partially based on Cachify developed by [Sergej Müller](https://wordpress.org/plugins/cachify/ "Author Sergej Müller").


== Changelog ==

= 1.0.9 =
* Option to disable pre-compression of cached pages if decoding fails

= 1.0.8 =
* Added support for srcset in WP 4.4
* Improved encoding (utf8)

= 1.0.7 =
* Added cache behavior option for new posts
* Improved metainformation of the signature
* Optimized cache handling for nginx

= 1.0.6 =
* Fixed query string related caching issue

= 1.0.5 =
* Credits update

= 1.0.4 =
* Changed WebP static file naming

= 1.0.3 =
* Fixed WebP version switch issue

= 1.0.2 =
* Added support for WebP and CDN Enabler plugin

= 1.0.1 =
* Added WebP support and expiry directive

= 1.0.0 =
* Initial Release


== Screenshots ==

1. Display of the cache size in your dashboard
2. Cache Enabler settings page and "Clear Cache" link in the dashboard
