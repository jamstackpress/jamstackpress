=== JAMStackPress ===
Contributors: jamstackpress
Tags: headless,static,jamstack,pwa,spa,api,json
Requires at least: 5.7.1
Tested up to: 5.7.1
Stable tag: 0.0.5
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Power-up your WordPress site and get it ready for JAMStack. Take advantage of usefull fields and anedpoints extending the WP-JSON API.

== Description ==
# JAMStackPress - Power-up you WordPress backend

This plugin extends the WP-JSON api by adding a new useful set of fields to the WP-JSON api response, this new set of fields will make your frontend development easier. JAMStackPress also applies some optional filters
to the content in order to make it front-end ready (no need to make replaces at front-end level).
We think about the possible scenarios of development for your static website, so in other words, we'll try to make your life easier, so that you only think about developing your decoupled frontend.



## Extra fields (jamstackpress object)
We include some extra fields that can be activated in the plugins administration page, that will make your frontend development easier:

- Human readable date field (uses the locale defined in your WordPress panel):
"readable_date": "March 26, 2018"


- Post's full slug and frontend link respecting your Wordpress permalinks selection:

"routes": {
  "slug": "/category/post-title/",
  "front_link": "https://example.com/category/post-title/"
}

- Featured image URLs one for every size:

"featured_image": {
  "thumbnail": "http://example.com/wp-content/uploads/2022/07/thumbnail-150x150.jpg",
  "medium": "http://example.com/wp-content/uploads/2022/07/medium-300x200.jpg",
  "medium_large": "http://example.com/wp-content/uploads/2022/07/medium-large-768x512.jpg"
  "large": "http://example.com/wp-content/uploads/2022/07/large-1024x683.jpg"
}

- SEO tags Title and Description - Compatible With Yoast and RankMath plugins:

"seo": {
   "title": "Post Title",
   "description": "Post SEO description"
}

## Extra endpoints



## Content filters & Deploy tools
**Content filters**
- Replace your WordPress base URL with the frontend URL defined in the plugin settings.
- Add image width and height attributes to  every image placed at the content.
- Add _blank target to every external link at the content.
 
**Deploy tools**
- Trigger frontend build: You can specify a build webhook url for triggering a deploy in your frontend site, directly from your WordPress backend. This
is specially useful to keep your frontend site always updated with the latest content, without having to manually trigger a deploy.

== Screenshots ==

1. Options panel.

== Changelog ==

= 0.0.1=
* First version.

= 0.0.2=
* Add plugin assets dir.

= 0.0.3=
* Fix previous release version issues.
* Update screenshots and url placeholders.

= 0.0.4 =
* Fix endpoint response not being formatted correctly.

= 0.0.5 =
* Fix version number