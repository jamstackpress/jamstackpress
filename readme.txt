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
 
**Flexible Filtering**
You can filter the endpoints data responses using several attributes
List of filters grouped by endpoint:

 **/posts**
	
 - **id**: Filter post by post id
 - **status**: Filter posts by post status (published, draft....)
 - **slug**: Filter post by post slug
 - **categories**: Filter posts by categories ids or categories slugs separated by commas

 **/categories**
	
 - **id**: Filter post by category id
 - **count**: Hide categories with a post count less than given in the attribute
  - **status**: Filter all comments or only approved

 **/comments**
	
 - **id**: Filter comment by comment id
 - **approved**: Filter comment by comment status options: *all, true, false*
 - **post**: Filter comments by id
 - **user**: Filter posts by user id
 

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

## Content filters & Deploy tools
**Content filters**
 - Replace backed base URL (the base URL of your WP installation) with the front base URL
 - more coming.......
 
 
**Deploy tools**
 - Generate site button: Special button at the dashboard, once clicked it will trigger your front end build at your favorite static hosting.
== Screenshots ==

1. Options panel.

== Changelog ==
= 0.0.1=
* First version.