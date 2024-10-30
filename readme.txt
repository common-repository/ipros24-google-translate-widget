=== iPROS24 Google Translate widget ===

Contributors: nevis2us
Donate link: http://ipros24.ru/
Tags: iPROS24, google, translate, widget, i18n
Requires at least: 5.0
Tested up to: 5.4
Stable tag: 1.12.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Google Translate widget with flags.

== Description ==

* Allows to translate your website content to many languages.
* Includes a sidebar widget with flags.
* Includes a shortcode for better control of widget placement and styles.
* Includes required attribution.
* Allows to translate login page and administration panel.
* Has basic support for RTL languages.
* Triggers a custom event after the page has been translated.
* Sets WordPress locale to the selected language.
* Loads external scripts asynchronously.

[Demo](http://ipros24.ru/wordpress/)
[Demo 2](http://corde.ipros24.ru/)

Since version 1.11 external scripts are loaded asynchronously, so when Google services are not responsive this won't delay loading your site.
Since version 1.12.2, for security reasons, external scripts won't be loaded if the user is logged into an administrative account. This means the translation won't work until the user logs out.

Plugin and theme developers can hook to a custom event to perform some actions after the page has been translated. This can be used e.g. to adjust element styles and positioning.

Changing WordPress locale allows you to use already installed language files and flip the site content in RTL languages. This feature can also be used by developers to quick check translations and view site layout in RTL. Sometimes it may be necessary to reload the page to set the locale. You can turn this on in the plugin settings.

[Advanced usage and examples](http://ipros24.ru/ipros24-google-translate-advanced-usage-and-examples/)

**Other iPROS24 plugins**

[iPROS24 Notices](https://wordpress.org/plugins/ipros24-notices/)

== Installation ==

1. Download iPROS24-google-translate-1.12.2.zip.
1. Unpack the archive into the plugins directory of your WordPress installation (wp-content/plugins).
1. Activate the plugin through the 'Plugins' screen in WordPress administration panel.
1. Use the Settings -> Google Translate screen to configure the plugin.
1. Add the iPROS24 Google Translate widget to a sidebar and configure it or use the shortcode for better control of widget placement and styles.
1. Log out.

**Notes**

Deactivate the plugin before changing the site language.

Do not turn on administration panel translation before you get it working on the front end.

Known incompatible plugins: simple-notices.

The widget has been tested with WordPress default themes.

[Support](http://ipros24.ru/forums/forum/wordpress/)

== Screenshots ==

1. Google Translate widget with flags.
2. Plugin settings.
3. Widget settings.

== Changelog ==

= 1.12.2 =
* Confirmed WordPress 5.4 compatible.
* Fixed external scripts vulnerability.
* Updated libraries.
* Updated readme.txt.

= 1.12.1 =
* Confirmed WordPress 5 compatible.

= 1.12 =
* Added required attribution.
* Added reload page setting.
* Fixed cookie domains.

= 1.11 =
* Added shortcode.
* Added async script loading.
* Fixed XSS vulnerability.
* Updated libraries.

= 1.10 =
* Updated libraries and translations.

= 1.9 =
* Added custom event.

= 1.8 =
* Fixed text domain.

= 1.7 =
* Fixed readme.txt and screenshots.

= 1.6 =
* Fixed widget styles in WordPress default themes.

= 1.5 =
* Released on July 1, 2017.

