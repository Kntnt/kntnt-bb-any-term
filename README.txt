=== Kntnt's Any Term for Beaver Builder Page Builder ===
Contributors: TBarregren
Tags: beaver builder,related posts,taxonomy,category,tags
Requires at least: 4.6
Tested up to: 4.9
Requires PHP: 7.0
Stable tag: 1.0.4
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

WordPress plugin that adds special purpose term to every taxonomy (including categories and tags) that makes taxonomy filters in post modules of *Beaver Builder Page Builder* (e.g. *Post Grid*, *Post Slider*, *Post Carousel*) to match posts that has at least on term in that taxonomy in common with the post that the module appears on. It can for instance be used to create reading recommendations at the end of a blog post.

== Description ==

This WordPress plugin extends the functionality of both the [free](https://wordpress.org/plugins/beaver-builder-lite-version/) and the [paid](https://www.wpbeaverbuilder.com/) versions of the *Beaver Builder Page Builder*.

= How to use the plugin =

When you configure a Page Builder module that allows you to filter posts based on category, tag or any other [taxonomy](https://codex.wordpress.org/Taxonomies), you will also find a special purpose term called `Any term of the post`. If you select it for a taxonomy, it will match posts that has at least on term in that taxonomy in common with the post that the module appears on. This is also true for pages and other [built in or custom post types](https://codex.wordpress.org/Post_Types).

This can be used for instead to create reading recommendations at the end of a blog post. For an example, scroll down to the bottom of any article in [the online magazine of Word Trade Center in Malmö](https://www.wtcmalmo.se/magasinet/sex-tips-att-lyckas-internationellt/2599) (in Swedish).

= Detailed description =

For each existing or in the future added taxonomy, including *category* and *tags*, this plugin adds a term with the human readable name `Any term of the post` and the machine readable name (a.k.a. slug) `kntnt-bb-any-term`.

The human readable name can be translated (or altered) through [localization](https://developer.wordpress.org/plugins/internationalization/localization/). The easiest way might be [Loco Translate](https://wordpress.org/plugins/loco-translate/).

The special terms are hidden in the user interface, except for Beaver Builder Page Builder plugin, as long as the plugin is active.

If you deactivate the plugin (but not uninstall it), the special terms will be visible in the user interface as regular terms. They will be hidden again if you re-actiavate the plugin.

The special terms are completely removed when the plugin is [properly uninstalled](https://codex.wordpress.org/Managing_Plugins#Uninstalling_Plugins).

== Installation ==

Install the plugin the [usually way](https://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

== Frequently Asked Questions ==

= Where is the setting page? =

There is no setting page.

= Does it work with PowerPack Addon for Beaver Builder? =

I don't know. I have not test it with either the [free](https://wordpress.org/plugins/ultimate-addons-for-beaver-builder-lite/) or [paid](https://wpbeaveraddons.com/) version of *PowerPack Addon for Beaver Builder*. If you test, please let me know if it works or not.

= Does it work with Ultimate Addons for Beaver Builder? =

I don't know. I have not test it with either the [free](https://wordpress.org/plugins/powerpack-addon-for-beaver-builder/) or [paid](https://www.ultimatebeaver.com/) version of *Ultimate Addons for Beaver Builder*. If you test, please let me know if it works or not.

= Does it work with PHP 5? =

I have not test it with PHP 5, but I don't think so.

= How can I get help? =

If you have a questions about the plugin, and cannot find an answer here, start by [issues](https://github.com/Kntnt/kntnt-bb-any-term/issues) and [pull requests](https://github.com/Kntnt/kntnt-bb-any-term/pulls). If you still cannot find the answer, feel free to ask in the the plugin's issue tracker at Github: [https://github.com/Kntnt/kntnt-bb-any-term/issues](https://github.com/Kntnt/kntnt-bb-any-term/issues).

= How can I report a bug? =

If you have found a potential bug, please report it on the plugin's issue tracker at Github: [https://github.com/Kntnt/kntnt-bb-any-term/issues](https://github.com/Kntnt/kntnt-bb-any-term/issues).

= How can I contribute? =

Contributions to the code or documentation are much appreciated.

If you are unfamiliar with Git, please post it as a new issue on the plugin's issue tracker at Github: [https://github.com/Kntnt/kntnt-bb-any-term/issues](https://github.com/Kntnt/kntnt-bb-any-term/issues).

If you are familiar with Git, please do a pull request.

== Screenshots ==

1. Example of how the special purpose term `Any term of the post` can be used in the Post Grid module of Beaver Builder Page Builder plugin.
2. Example of how the special purpose term `Any term of the post` can be used in the Post Grid module of Beaver Builder Page Builder plugin.

== Changelog ==

= 1.0.4 =

Stricter control of database query that retrieves terms to see if it possible to remove any term (i.e. if `fields`is `all` or `ids`).

= 1.0.3 =

Added support for Beaver Builder Page Builder plugin version 2.x.

= 1.0.2 =

Corrected the version number in the plugin file.

= 1.0.1 =

Fixed minor mistakes (e.g. spelling).

= 1.0.0 =

Initial release. Fully functional plugin.
