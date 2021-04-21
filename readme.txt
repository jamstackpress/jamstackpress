=== JAMStackPress ===
Contributors: jamstackpress
Tags: headless,static,jamstack,pwa,spa,api,json
Requires at least: 5.7.1
Tested up to: 5.7.1
Stable tag: 0.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Power-up your WordPress site and get it ready for JAMStack. Super Fast wp-json endpoints and much more.

== Description ==
# JAMStackPress - PowerUP you WP Backend

 By adding custom endpoints that connect directly to the database, we achieve that the data consumption speed of the json api is significantly faster than the default wordpress endpoints.
Apart  from the super fast endpoints, we think about the possible scenarios of development of static websites,  in other words we make your life easier so that you only think about developing your decoupled front end.
 

## Super Fast Custom API endpoints
JAMSTackPress plugins comes with 3 custom super fast wp-json api endpoints which connects directly to the WordPress database:

 - Posts
`https://example.com/wp-json/jamstackpress/v1/posts`
 - Categories 
  `https://example.com/wp-json/jamstackpress/v1/categories`
 - Comments
  `https://example.com/wp-json/jamstackpress/v1/comments`
 
**Flexible**
You can combine your endpoint data, for example you can retrieve all the posts data including its categories, comments and tags all  in one API call.
Example:

    https://example.com/wp-json/jamstackpress/v1/posts?include=categories;comments;tags

**Extra  fields**
We include some extra fields that will make your  front development easier:

 - Human Readable Date field 
 `\"readable_date\": \"March 26, 2018\"`
 
 - Posts full slug and front link using your permalinks options: 
 `\"full_slug\": {
	\"slug\": \"/category/post-title/\",
	\"front_url\": \"https://example.com/category/post-title/\"
}`

**Pagination**
Built in pagination, no need to filter response headers anymore, pagination info will be available inside the data response:

`https://example.com/wp-json/jamstackpress/v1/posts?per_page=10&page=1`


== Changelog ==
= 0.0.1=
* First version.