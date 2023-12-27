=== Smooth Scroll ===

Contributors: troytempleman
Tags: customizer, translation-ready
Stable tag: 1.0.0
Requires at least: 4.9
Tested up to: 5.3.2
Requires PHP: 5.3
License: GNU General Public License v2 or later
License URI: LICENSE

== Description ==

When any on page link is clicked, smoothly scroll to the link location, giving you a sense of where they are on the page and where they are going. 

== Installation ==

= Install via WordPress =
If you have this plugin as a .zip file, you can manually upload it and install it through the Plugins admin screen.

1. Login to WordPress.
2. Navigate to **Plugins** > **Add New**.
3. On the **Add Plugins** page, click **Upload Plugin**.
4. Click **Choose File** to locate the .zip file and click **Open**. 
5. Click **Install Now**.
6. On the **Installing Plugin from uploaded file** page, click **Activate Plugin**.

= Install via FTP =
This procedure requires you to have access to your WordPress installation on your server and familiar with the process of transferring files using an FTP client, such as FileZilla or WinSCP.

1. If you have this plugin as a .zip file, unzip it with a program such as StuffIt Expander or WinZip.
2. Connect to your WordPress directory on your server with a FTP client.
3. Copy the plugin folder to the `wp-content/plugins` folder in your WordPress directory. This installs the plugin to your WordPress site.
4. Login to WordPress.
5. Navigate to **Plugins**.
6. Locate the plugin in the list.
7. Click the plugin's **Activate** link.

= Include in a Theme =
If you want to include this plugin in your theme, instead of a plugin.

1. Place the plugin folder in your theme's `inc` folder, such as `wp-content/my-theme/inc/my-plugin/`.
2. Open your theme's `functions.php` file in a text/code editor, such as Notepad or Visual Studio Code.
3. In your `functions.php` file, add `require get_stylesheet_directory() . '/inc/my-plugin/my-plugin.php';`, replacing `my-plugin` with the name of the plugin.
4. Save and close your `functions.php` file.

== Frequently Asked Questions ==

= How do you install this plugin? =
See **Installation** section.

== Changelog ==

= 1.0.0 - November 1, 2019 =
* Initial release

== Credits ==
