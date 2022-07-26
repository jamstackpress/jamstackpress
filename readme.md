=== JAMStackPress ===
Contributors: santiagocajal, guilledutra, jamstackpress
Tags: headless,static,jamstack,pwa,spa,api,json
Requires at least: 5.7.1
Tested up to: 6.0.1
Stable tag: 0.1.3
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Power-up your WordPress site and get it ready for JAMStack. Take advantage of useful fields, endpoints and filters extending the WP-JSON API.  
  
== Description ==  
# JAMStackPress - Power-up you WordPress backend  
  
This plugin extends the WP-JSON API by adding a new useful set of fields to the WP-JSON API response, this new set of fields will make your front-end development easier. JAMStackPress also applies some optional filters  
to the content in order to make it front-end ready (no need to make replacements or ad image width and height attrs at front-end level).  Finally we also adds to more endpoints to the WP-JSON API (contact form and sitemap) very useful!
We think about the possible scenarios of development for your static website, so in other words, we'll try to make your life easier, so that you only think about developing your decoupled front-end.  
  
  
  
## Extra fields (jamstackpress object)  
We include some extra fields that can be activated in the plugins administration page, that will make your front-end development easier:  
  
- Human readable date field (uses the locale defined in your WordPress panel):  
```  
"readable_date": "March 26, 2018"  
```  
  
- Post's full slug and front-end link respecting your WordPress permalinks selection:  
```  
"routes": {  
"slug": "/category/post-title/",  
"front_link": "https://frontenddomain.com/category/post-title/"  
}  
```  
  
- Featured image URLs one for every size:  
  
```  
"featured_image": {  
"thumbnail": "http://example.com/wp-content/uploads/2022/07/thumbnail-150x150.jpg",  
"medium": "http://example.com/wp-content/uploads/2022/07/medium-300x200.jpg",  
"medium_large": "http://example.com/wp-content/uploads/2022/07/medium-large-768x512.jpg"  
"large": "http://example.com/wp-content/uploads/2022/07/large-1024x683.jpg"  
}  
```  
  
- SEO tags Title and Description - Compatible With Yoast and RankMath plugins:  
```  
"seo": {  
"title": "Post Title",  
"description": "Post SEO description"  
}  
```  
  
## Extra endpoints  
JAMStackPress includes 2 optional endpoints, always with the porpoise in mind of making your front end development tasks much more easier  
  
**/jamstackpress/v1/contact**  
This endpoint acts as a contact form back-end resource. Will save a jp_contact custom post and send an email on every success submission.  
  
How to use it:  
  
1. Enable the custom **contact form endpoint** in the options panel.  
2. Fill and save the rest of the options related to the contact endpoint: **Contact email**, **Contact Fail Message**, **Contact Success Message** and **reCaptcha Secret Key** (google reCaptcha V3).  
3. Send a request to the custom contact form endpoint, here is an example of a call to the contact form endpoint using js fetch()  
  
```  
fetch('https://example.com/wp-json/jamstackpress/v1/contact?',{  
method: 'POST',  
headers: {  
'Accept': 'application/json',  
'Content-Type': 'application/json'  
},  
body: JSON.stringify({  
name: 'Name',  
email: 'example@example.com',  
subject: 'Contact Subject',  
message: 'Body of the contact form message',  
recaptach_token: 'xxxxxxxxxxx'})  
})  
```  
  
**/jamstackpress/v1/sitemap**  
This endpoint will return a full list of posts and categories slugs, here is a sample of returned list:  
``` 
["/sapiente/eveniet-velit-et-aut-est-et-inventore/","/sapiente/aliquid-aut-ut-eius-excepturi-magni/","/nulla-molestias/eius-ratione-mollitia-aliquam/","/uncategorized/aut-qui-repudiandae-nihil-iste/","/uncategorized/test/","/aliquam/","/ipsa-ratione/","/nulla-molestias/","/perferendis-modi/","/sapiente/","/uncategorized/","/unde-temporibus/","/ut-quo/"]  
```  
  
  
## Content filters & Deploy tools  
**Content filters**  
- Replace your WordPress base URL with the front-end URL defined in the plugin settings.  
- Add image width and height attributes to every image placed at the content.  
- Add _blank target to every external link at the content.  
  
**Deploy tools**  
- Trigger front-end build: You can specify a build webhook url for triggering a deployment in your front-end site, directly from your WordPress back-end. This  
is specially useful to keep your front-end site always updated with the latest content, without having to manually trigger a deploy.  
  
== Screenshots ==  
  
1. Options panel.  
  
== Changelog ==  

= 0.1.3 =
* Fix plugin version
* Update changelog order

= 0.1.2 =
* Fix internal GitHub deployment

= 0.1.1 =  
* Fix dependencies missing

= 0.1.0 =  
* Major changes (see readme)
* The plugin now extends the WP-JSON API

= 0.0.5 =  
* Fix version number

= 0.0.4 =  
* Fix endpoint response not being formatted correctly.  
  
= 0.0.3 =  
* Fix previous release version issues.  
* Update screenshots and url placeholders.  

= 0.0.2 =  
* Add plugin assets dir.  

= 0.0.1 =  
* First version.  

  

  

  






