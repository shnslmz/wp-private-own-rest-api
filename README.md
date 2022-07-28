### Private Own REST API 
* Tags: wordpress, api, private rest, your own api
* Requires at least: 4.9
* Tested up to: 6.0
* Requires PHP: +7
* License: GPLv2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html


### Description:

This plugin shows JSONplaceHolder's (API) users list and their detail info on a DataTable, a private WP virtual page and/or existing page/post using Wordpress shortcode.
 => The default API URL for user listing: https://jsonplaceholder.typicode.com/users
 => The default API URL for user listing: https://jsonplaceholder.typicode.com/users/{id}/posts
 
 
## The screenshots:

### The Plugin Settings Page:
<img width="852" alt="1-178255095-590a2778-1298-45e0-a1b3-f03a3e05f28b" src="https://user-images.githubusercontent.com/13356931/181321161-014c2edc-d8b7-47a0-ba99-bb969d58ccdc.png">

### The Plugin Page to show on an existed Wordpress Admin Page (It is created by the plugin as auto).
<img width="896" alt="2-178255330-176aa134-7799-4ed2-ba5b-3f5beda575b8" src="https://user-images.githubusercontent.com/13356931/181321137-6dce2340-3ddc-4858-b13f-7900a094f53e.png">

### The Plugin <b>Virtual Page</b> for frontend
<img width="823" alt="3-178255509-01dc8781-d5f3-4dc2-8d99-44b4a47c900e" src="https://user-images.githubusercontent.com/13356931/181321106-aa008913-5c51-4fdf-881b-32811bdbbe94.png">

### and The Plugin Existed Page for frontend
<img width="873" alt="4-178255600-7d7a26d7-b540-45ff-a27f-baa56ee5ae3b" src="https://user-images.githubusercontent.com/13356931/181321034-6dc579fa-b069-45ed-adeb-7183e08d96aa.png">


<br />
== Note ==
This plugin was created for a  test.

### Development process fiction summary:

● When the plugin is activated, an option record is created (if not created before),
● In this option:
<br /> 
* guid,
* api_url,
* ed_access //control of access to editors' plugin settings
* slug,     // for virtual page dynamic uri
* updated_at, 

● A default page is created to be used to display the relevant output on the front.
● On this page:
<br /> 
* As a shortcode content where the plugin displays the front-end output is defined,
* The $guid value, which was randomly created in the previous step, is the value of this post. It is written in the guid field.

● The created shortcode can be used in any page or text.

● When the relevant default page is visited for the first time, the data loaded in is PHP, the relevant API
out of the way and written.

● DataTable is used for search and filter operations on the front side.
● Request to the detail page of the relevant API when clicking on any data row
discarded and the articles belonging to that user are pulled and displayed as a popup.

* If the plugin is disabled, the default page is removed and the wp_options variable line is deleted,
* When the plugin is installed and activated, the table and default page are created.
* Besides automatically creating an existing page for WP, a virtual page is also created and the url (slug) of this page is created via the administration panel.
can be done. 
* In terms of changing the appearance of the plugin's page, the plugin files must first be added to the theme. files are loaded later and the plugin files contain a priority like !important. Since the rule set is not defined, it will be overridden directly. Example: The h4 style rule in the main.css file in the public folder of the plugin, Override the h4 rule in the style.css file of the default theme twentytwenty is an example (5px makes the margin 4.5rem auto 2.5rem).

● Access control to the settings page:
<br /> 
* After the plugin is installed, the access permission of the editors is set to true by default,
* The administrator can set this field to false to make the access exclusive to administrators only
* Part of readme, and license files made in c/p.
