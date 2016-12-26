=== WHMCS Bridge Pro ===
Contributors: globalprogramming
Donate link: http://i-plugins.com/
Tags: WHMCS, hosting, support, billing, integration
Requires at least: 3.1
Tested up to: 4.6
Stable tag: 3.7.2
License: Premium

WHMCS Bridge Pro (aka SSO) is a premium addon to the WHMCS Bridge plugin that takes the integration between WHMCS and WordPress a step further.

== Description ==

Thanks to the single sign-on feature, your customers can sign in once on your site and comment on your blog postings, share information with their peers, order hosting plans and pay their bills.
The multi-lingual option allows you to choose the language of the WHMCS customer portal.

== Installation ==

WHMCS Bridge Pro provides additional functionality on top of WHMCS Bridge, so make sure you leave WHMCS Bridge installed.

1. Upload the `whmcs-bridge-sso` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. The plugin works in concert with the Bridge Helper addon for WHMCS, you can download it within your Client Zone on http://i-plugins.com/

Please visit the [i-Plugins](http://wordpress.org/support/plugin/whmcs-bridge "Support Forum") for more information and support.

** Note : You should have htaccess setup in your WHMCS (standard WHMCS htaccess setup - see WHMCS documentation) for pretty permalinks.

== Frequently Asked Questions ==
* Please see our Knowledgebase on www.i-plugins.com

== Screenshots ==
* Please see our Knowledgebase on www.i-plugins.com

=== How does it work? ===
All WHMCS users are copied to Wordpress upon activation and are kept in sync.

When a user logs in to Wordpress the following checks take place:
1) If the entered password is valid, the plugin tries to login the user to WHMCS using the entered password.
	a) If the login succeeds, everything is fine.
	b) If the login fails, the WHMCS user password is updated with the entered user password (so they're both back in sync). Then, the login to WHMCS is retried and should be succesful.

2) If the entered password is not valid, the plugin checks to see if the entered password can be used to login to WHMCS (old WHMCS password).
	a) If it succeeds, the user gets logged in to WP and in to WHMCS.
	b) If it fails, the whole login fails.
	
If a WP user password gets changed, the WHMCS user password gets updated.

If a WP user details get changed, the WHMCS user details get updated.

If a user registers in WP, no WHMCS user is created.

If a WP user gets deleted, the WHMCS user is left intact.

Please checkout our Knowledgebase Articles (https://i-plugins.com/whmcs-bridge/knowledgebase/1021/WHMCS-Bridge/) for more information and support.

== Known Issues ==

* Using https may require HTACCESS "Header set Access-Control-Allow-Origin: https://yourdomain.com" (no trailing slash) added.
* qTranslate / Pro does not work with pretty permalinks. Does work with WPML.

== Upgrade Notice ==

Simply go to the WordPress Settings page for the plugins and click the Upgrade button.

== Changelog ==

= 3.7.2 =
* Additional language support added for WPML (Portuguese-PT, Chinese/zh-cn/zh-tw)
* License check issues fixed
* Core updates

= 3.7.1 =
* Multilingual fixes (i.e. WPML, requires 3.7.1 of WHMCS-Bridge free)
* Core updates

= 3.7.0 =
* Core patch
* Styling updates

= 3.6.6 = 
* Bridge pages have the correct titles from their associated WHMCS pages (requires WP 4.4+ and a theme that supports WP's pre_get_document_title filter)

= 3.6.5 =
* License updates
* Parsing updates

= 3.6.4 =
* Core updates

= 3.6.3 =
* Bug fix

= 3.6.2 =
* Core license fixes, updates and adjustments
* License failover server check added: See https://i-plugins.com/whmcs-bridge/knowledgebase/1096/How-are-licenses-checked.html/

= 3.6.1 =
* License Updates: See https://i-plugins.com/whmcs-bridge/knowledgebase/1096/How-are-licenses-checked.html/

= 3.6.0 =
* Core updates
* License checking updates

= 3.5.2 =
* Core updates

= 3.5.1 =
* Cache updates
* URL parse fixes

= 3.5.0 =
* Core updates
* Custom JavaScript setting for the bridge
* Introduction of CSS and JS caching

= 3.4.6 =
* Core updates
* URL fixes
* SSO fixes

= 3.4.5 =
* Fixed admin user over-write issue
* Fixed redirect on WP login issue
* Fixed redirect with pretty permalinks
* Added support for WHMCS 6.1 order forms

= 3.4.4 =
* Fixed user sync issue
* Fixed redirect on login issue (ticket responses not logging after following link, etc.)

= 3.4.3 =
* Core updates
* Parsing updates
* Miscellaneous bugfixes.

= 3.4.2 =
* Added Affiliate Tracking functionality to assign an affiliate to your bridge page.
* URL parsing issues fixed
* Miscellaneous bug fixes

= 3.4.1 =
* Minor updates for "Six" theme compatibility issues.

= 3.4.0 =
* Compatibility updates for WHMCS 6 including the new "Six" template
* Please read: https://i-plugins.com/whmcs-bridge/announcements/35/WHMCS-Bridge---Notes-on-WHMCS-6.html/

= 3.3.5 =
* Orderforms JS parser update.

= 3.3.4 =
* Fix URL issues.
* JS/CSS parsing fixes.
* Misc bug fixes.

= 3.3.3 =
* Support for IP unblock module
* Changed custom paths to include CSS files 
* Miscellaneous Bug fixes 
* This version is not guaranteed to work with WHMCS 6 templates, still a work in progress for 6 template support.

= 3.3.2 =
* Added Project Management Addon compatibility for Pro.
* Added "//host" CSS/JS URL compatibility
* Added support for script (.php) generated images
* Added support for ProxMox VPS plugin for Pro.

= 3.3.1 =
* Licensing check optimisation, fix issue that caused the module to check every page load (therefore slow down page loads).
* Addition of Cart contents widget submitted by Northgate Web UK (https://www.northgatewebhosting.co.uk)

= 3.3 =
* ** NB ** Encoding using the current IonCube encoder. Legacy encoder files can be downloaded via Client Zone.
* Updated bridgewp plugin IP fix - please be sure to download from our client zone.
* Updated easyXDM library to load only when required (when using short codes).
* Fixed ticket rating issue on default theme.
* Fixed issue with comparison cart unable to redeem promo codes.
* Modern Cart & AjaxCart now working.

= 3.2.10 =
* License checker optimisation

= 3.2.9 =
* Fixed issue with payment gateway modules (eg: 2Checkout recurring)
* Fixed accepting quote issue
* Added support for qTranslate Pro (Note: qTranslate does not work with Pretty Permalinks, WPML does.)
* Added twitter news feed for Plugin related notices to admin panel.

= 3.2.8 =
* Utilise uninstall function instead of deactivate
* Added custom script path setting to settings page (allows for better custom WHMCS template support)

= 3.2.7 =
* Bugfix for wpusers class database warnings.

= 3.2.6 =
* Bug fixes
* Added option to disable pre-filled information when syncing from WordPress to WHMCS.

= 3.2.5 =
* Fixed issue cutting sync short.

= 3.2.4 =
* Added fix for BootWHMCS order form JavaScript conflict issues.

= 3.2.3 =
* Changed code for IP fix to work on Apache 2.4+ 
* Redirect fix for Apache 2.4+ in WHMCS Addon
* Fixed <templatename>.css 404 issue when using a custom template. 

= 3.2.2 =
* See https://i-plugins.com/whmcs-bridge/knowledgebase/1068/Why-are-WordPress-users-being-assigned-dummy-address-details-when-synced-to-WHMCS.html/

= 3.2.1 =
* Fixed issue where WP Admin users have their user level and role replaced to Subscriber.
* Added ability to sync WHMCS Contacts that have login access.
* Patched a few pretty parser issues.
* Added support for new ajax server status pages. 
* Fixed issue where passwords containing certain special characters were overwritten with the characters removed. 

= 3.2.0 =
* Changed references from zingiri.com to i-plugins.com
* Added local copy of PDF documentation

= 3.1.4 =
* Modified Ioncube build to support older Ioncube Loaders

= 3.1.3 =
* Updated license check
* Moved WHMCS addon to separate repository
 
= 3.1.2 =
* Added option to disable redirect for viewquote

= 3.1.1 =
* Added support for passing URL GET parameters to shortcode pages

= 3.1.0 =
* Removed console.log output in bridgewp javascript causing the redirect not to work on some browsers
* Added debug log option in Bridge Helper addon

= 3.0.9 =
* Fixed resize issue with cross domain iframe integration

= 3.0.8 =
* Fixed small error in wp-plugin-update
* Added workaround for faulty wp_insert_user() function not accepting role attribute
* Verified compatibility with Wordpress 3.6

= 3.0.7 =
* Verified compatibility with Wordpress 3.5.2
* Clarified warning message about Bridge Helper addon
* Fixed issue with viewinvoice redirect option in Bridge Helper addon

= 3.0.6 =
* Added option to disable redirect for viewinvoice
* Changed labelling of helper addon setting fields

= 3.0.5 =
* Included easyXDM libraries with plugin and addon

= 3.0.4 =
* Removed leading and trailign spaces from license key when doing license check
* Improved use of local license key to avoid performance issue due to excessive license checks

= 3.0.3 =
* Fixed issue with sync page not showing although sync enabled

= 3.0.2 =
* Bypass user validation in WHMCS when syncing users from Wordpress to WHMCS
* Added option to sync from the control panel
* Fixed issue with license check when CURL is not installed
* Added possibility to disable auto redirect functionality

= 3.0.1 =
* Added more info on Remote Check Failed message

= 3.0.0 =
* Added shortcodes functionality
* Changed intergration approach to cross domain iframes (for shortcodes only)
* Fixed issue with using WHMCS admin 'Login as Client' option
* Removed obsolete compatibility check

= 2.2.8 =
* Improved debugging info

= 2.2.7 =
* Added instructions on license reset
* Added additional info in case of license check failure

= 2.2.6 =
* Changed references from zingiri.net to zingiri.com
* Improved license check method
* Renamed prepare_request function to avoid conflicts with other plugins
* Added support for HTTP_X_CLUSTER_CLIENT_IP in IP fix

= 2.2.5 =
* Suppressed email from sending when auto registering client in WHMCS

= 2.2.4 =
* Fixed pagination issue when viewing domains, invoices, etc

= 2.2.3 =
* Removed 'secret' option as not used anymore
* Added option to force SSL on bridge page

= 2.2.2 =
* Fixed issue with permalinks and themes or plugins not adhering to WP coding rules
* Fixed issue with popupWindow parsing when using permalinks

= 2.2.1 =
* Verified compatibility with WP 3.5.1

= 2.2.0 =
* Included WHMCS redirect addon and IP fix patch in plugin folder

= 2.1.5=
* Updated license file

= 2.1.4 =
* Verified compatibility with Wordpress 3.5

= 2.1.3 =
* Fixed issue with double slash in links when using in combination with WPML

= 2.1.2 =
* Fixed issue following 2.1.1 upgrade related to WPML

= 2.1.1 =
* Added possibility to set Wordpress role to be used during sync
* Fixed issue with WPML integration

= 2.1.0 =
* Added new WHMCS addon that works in concert with this plugin to improve the user experience
* Added support for multi-site session sharing
* Fixed issue with WPML language selection

= 2.0.4 =
* Updated installation instructions
* Added all language name / code pairs for WHMCS / qtranslate

= 2.0.3 =
* Added option to disable user sync

= 2.0.2 =
* Removed debug display in case of WP to WHMCS sync
* Verified compatibility with Wordpress 3.4.2

= 2.0.1 =
* Fixed parsing issue with pretty permalinks and secure site combination

= 2.0.0 =
* Forced password change in WHMCS when user logs in via Wordpress and single sign on activated
* Made user synchronisation optional
* Added option to sync Wordpress users to WHMCS (experimental)

= 1.9.1 =
* Fixed packaging issue

= 1.9.0 =
* Fixed compatibility issues with WHMCS 5.1.2
* Made single sign on optional

= 1.8.5 =
* Fixed issue when upgrading WHMCS Bridge standard
 
= 1.8.3 =
* Checked compatibility with WP 3.4.1
* Remove spaces in front of XML message received

= 1.8.1 =
* Added display of server IP in settings

= 1.8.0 =
* Added support for pretty permalinks (experimental)

= 1.7.4 =
* Fixed issue with View Ticket link not being parsed correctly in 'default' theme

= 1.7.3 =
* Added more debug info in the log

= 1.7.2 =
* Added support for WPML plugin, chosen language is passed on to WHMCS

= 1.7.1 =
* Added missing portal.css file

= 1.7.0 =
* Fixed issues with WHMCS 5 Default template
* Added support for affiliates (management of cookies)

= 1.6.5 =
* Fixed issue with sync
* Update installation instructions
* Added support for WHMCS 5 Default template (experimental)
* Improved description of license check failure message
* Verified compatibility with Wordpress 3.3
* Improved logging
* Fixed security issue

= 1.6.4 =
* Fixed activation issue

= 1.6.3 =
* Fixed issues with undefined constants

= 1.6.2 =
* Updated installation instructions

= 1.6.1 =
* Fixed issues with the recognition of the user's IP address
* Updated installation instructions

= 1.6.0 =
* Added new feature so that IP address of the user's location is used when connecting to WHMCS, rather than IP of the server hosting Wordpress 
* Check that return message from WHMCS contains an array of users
* Replaced deprecated WP function

= 1.5.0 =
* Added WHMCS admin user and password fields in control panel (moved from standard plugin)

= 1.4.2 =
* Added auto update possibility via Wordpress plugins panel

= 1.4.1 =
* Fixed issue in system message logging

= 1.4.0 =
* Renamed plugin to 'WHMCS Bridge Pro'
* Added option to choose WHMCS customer language
* Fixed issue 'Warning: whmcs::connect() [whmcs.connect]: Node no longer exists in /.../wp-content/plugins/whmcs-bridge-sso/includes/connect.class.php on line 127'
 
= 1.3.2 =
* Improved checking if SSO plugin is active

= 1.3.1 =
* New version of WHMCS-bridge plugin

= 1.3.0 =
* Added more info to debug log to help with installation issues

= 1.2.3 =
* Fixed issue with error or warning displayed during synchronisation: Invalid argument supplied for foreach() in .../wpusers.class.php on line 31
* Added more info to debug log

= 1.2.2 =
* Reset local license when updating the control panel settings
* Fixed single sign on issue following upgrade of HttpRequest class in version 1.2.1

= 1.2.1 =
* Changed packaging so the plugin unzips with the right folder name (without version extension)
* Added compatibility check with standard WHMCS Bridge plugin

= 1.2.0 =
* Added automatic synchronisation of users in round robin fashion
* Fixed issue in license error management
* Fixed UTF-8 encoding issue in WHMCS XML API
* Added WHMCS password update in case user asks for a password reset or the password is reset by the WP administrator
* Various improvements to the synchronisation of log in and out between the 2 systems

= 1.0.2 =
* Fixed license file expired issue

= 1.0.1 =
* Fixed license check issue

= 1.0.0 =
* Added license check

= 0.9.1 =
* First beta release

= 0.9.0 =
* Alpha release