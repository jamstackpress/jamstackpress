=== JAMStackPress ===
Contributors: jamstackpress
Tags: headless,static,jamstack,pwa,spa,api,json
Requires at least: 5.7.1
Tested up to: 5.7.1
Stable tag: 0.0.4
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Power-up your WordPress site and get it ready for JAMStack. Super fast wp-json endpoints and much more.

== Description ==
# JAMStackPress - Power-up you WordPress backend

By adding custom endpoints that connect directly to your database, you can achieve super fast speeds for the wp-json API, which are significantly faster than the default WordPress's endpoints.
We think about the possible scenarios of development for your static website, so in other words, we'll try to make your life easier, so that you only think about developing your decoupled frontend.
 

## Super Fast Custom API endpoints
JAMStackPress comes with 4 super fast custom wp-json API endpoints, which connect directly to your WordPress's database:

- Posts
`https://example.com/wp-json/jamstackpress/v1/posts`
- Categories 
`https://example.com/wp-json/jamstackpress/v1/categories`
- Tags
`https://example.com/wp-json/jamstackpress/v1/tags`
- Comments
`https://example.com/wp-json/jamstackpress/v1/comments`
 
**Flexible Filtering**
You can filter the data using several attributes
List of filters grouped by endpoint:

**/posts**
	
- **id**: Filter posts by id (for e.g: `https://yourwordpress.com/wp-json/jamstackpress/v1/posts?id=1`)
- **status**: Filter posts by status (published, draft....) (for e.g: `https://yourwordpress.com/wp-json/jamstackpress/v1/posts?status=publish`)
- **slug**: Filter posts by slug (for e.g: `https://yourwordpress.com/wp-json/jamstackpress/v1/posts?slug=my-first-post`)
- **categories**: Filter posts by categories ids or categories slugs, separated by commas (for e.g: `https://yourwordpress.com/wp-json/jamstackpress/v1/posts?categories=1,my-category,2`)

**/tags**
	
- **id**: Filter tags by id (for e.g: `https://yourwordpress.com/wp-json/jamstackpress/v1/tags?id=1`)
- **slug**: Filter tags by slug (for e.g: `https://yourwordpress.com/wp-json/jamstackpress/v1/tags?slug=my-tag`)
- **hide_empty**: Hide the tags without posts (for e.g: `https://yourwordpress.com/wp-json/jamstackpress/v1/tags?hide_empty=true`)

**/categories**
	
- **id**: Filter categories by id (for e.g: `https://yourwordpress.com/wp-json/jamstackpress/v1/categories?id=1`)
- **slug**: Filter categories by slug (for e.g: `https://yourwordpress.com/wp-json/jamstackpress/v1/categories?slug=my-category`)
- **hide_empty**: Hide the categories without posts (for e.g: `https://yourwordpress.com/wp-json/jamstackpress/v1/categories?hide_empty=true`)

**/comments**
	
- **id**: Filter comments by id (for e.g: `https://yourwordpress.com/wp-json/jamstackpress/v1/comments?id=1`)
- **approved**: Filter comments by status options: *all, true, false* (for e.g: `https://yourwordpress.com/wp-json/jamstackpress/v1/comments?approved=false`)
- **post**: Filter comments by post id (for e.g: `https://yourwordpress.com/wp-json/jamstackpress/v1/comments?post=1`)
- **user**: Filter posts by user id (for e.g: `https://yourwordpress.com/wp-json/jamstackpress/v1/comments?user=1`)
 
**Show/Hide response fields**
This behaviour applies to every endpoint.
It is possible to only retrieve the necessary fields by using the **"fields"** filter, which is present on every endpoint:
`https://yourwordpress.com/wp-json/jamstackpress/v1/posts?fields=slug,title,id`
The response will contain only the posts fields specified in the filter.


**Extra fields**
We include some extra fields that can be activated in the plugins administration page, that will make your frontend development easier:
- Human readable date field (uses the locale defined in your WordPress panel):
`\"readable_date\": \"March 26, 2018\"`

- Post's full slug and frontend link using your permalinks options:
`\"full_slug\": {
  \"slug\": \"/category/post-title/\",
	\"front_url\": \"https://example.com/category/post-title/\"
}`

**Pagination**
With our built in pagination, there's no need to filter response headers anymore. The pagination info will be available inside the data response:
`https://example.com/wp-json/jamstackpress/v1/posts?per_page=10&page=1`

## Content filters & Deploy tools
**Content filters**
- Replace your WordPress base URL with the frontend URL defined in the plugin settings.
- More coming soon...
 
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