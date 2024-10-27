=== Guild Wars 2 Screenshot Riddle ===
Contributors: arnefi
Donate link: https://www.paypal.com/cgi-bin/webscr?hosted_button_id=9G7Q8VJ5YVJYU&item_name=GW2riddle&cmd=_s-xclick
Tags: GW2, Guild Wars 2, Screenshot, Riddle, Tyria
Requires at least: 3.5
Tested up to: 3.7
Stable tag: 1.2.8
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl

Users upload screenshots that are partially displayed and other users have to guess the location where it's taken.

== Description ==

= Languages =

Game and waypoints currently available in

* English
* German

= Game =

The game works as follows: one player uploads a screenshot. This will be displayed only covered. Every day one part will be removed so you can see every day more of the screenshot.

The other players have to guess where the screenshot was taken by selecting the nearest waypoint. Once a player guessed right he earns points, the more points the more parts are still covered. So a player can earn between 1 and 17 points. A player can guess every 10 hours at most.

The player who guessed right has to upload the picture for the next round.

The player who reaches %d points first, wins the game.

= Winnings =

Every player who ever guessed counts as participant of the game, even if he never guessed right. When a player reached at least %d points every participant has to pay the winner the amount of one gold. So the winnings are the higher the more players take part.

= Take Part =

You have to be registered to this site and the administrator must give you the right to upload files.

= Rules For Screenshots =

It's only allowed to take screenshots in not instanciated regions, so not in dungeons or in the personal story quest and things like that. And of course a player has to be able to solve the riddle when he sees the whole screenshot. So just don't make close-ups of daisies or the sky but include enough of the environment so that the players get enough hints for the correct solution.

= Screenshots =

If you have won a round you have to upload your own screenshot. To do so, press [Ctrl] + [Shift] + [H] in the game to fade out the interface. This is important so that nobody can see your minimap and other hints. After that press [prtscr] (over [ins]) and the screenshot is done. You can find it in your home directory in the subfolder Documents\GUILD WARS 2\Screens. (e. g. C:\Users\Arne\Documents\GUILD WARS 2\Screens) Please do not resize or convert the images to another format before the upload. Don't forget to select the nearest waypoint, so the winner can be determined automatically.

= Copyright =

The Plugin is licensed under the GPLv3.

But it uses graphics and logos from the game *Guild Wars 2*. For these the following copyright applies.

©2010–2013 ArenaNet, LLC. and NC Interactive, Inc. All rights reserved. Guild Wars, Guild Wars 2, ArenaNet, NCSOFT, the Interlocking NC Logo, and all associated logos and designs are trademarks or registered trademarks of NCSOFT Corporation. All other trademarks are the property of their respective owners.

ArenaNet allows to use the graphics (and therefore this plugin) on non-commercial sites for private use. You can find the complete »Guild Wars 2 Content Terms of Use« under the following URL:

[https://www.guildwars2.com/en/legal/guild-wars-2-content-terms-of-use/][gw2ctou]
[gw2ctou]:https://www.guildwars2.com/en/legal/guild-wars-2-content-terms-of-use/
    "Guild Wars 2 Content Terms of Use"

== Installation ==

1. Upload all files to the `/wp-content/plugins/arnes-gw2-riddle` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Do I really have to use it =

Yes, of course!


== Screenshots ==

1. Screenshot of a running game

== Changelog ==

= 1.2.8 =
* [fix] corrected the calculation of points

= 1.2.7 =
* [loc] changed German translation for "Iron Marches", already running riddles in that zone might be unsolvable after the path, if server WP language set to German

= 1.2.5 =
* [loc] found untranslated string

= 1.2.4 =
* [fix] regions disappeared while uploading

= 1.2.3 =
* [mod] if a hint is visible all not matching zones will be removed from the list of zones
* [mod] a zone will not show up in the list of zones if all waypoints already have been guessed

= 1.2.2 =
* [fix] problems with upload

= 1.2.1 =
* [fix] problem with new installation solved
* [fix] should be ready for 3.6

= 1.2.0 =
* [mod] combining multiple options into one
* [add] uninstallation now removes all options and images
* [add] keeping track of guesses: already tried waypoints will be removed from the list of possible waypoints

= 1.1.4 =
* [mod] using global setting of time zone, no need to specify it any more
* [loc] added singular to "points"

= 1.1.3 =
* [fix] corrected shotcodes in settings dialog
* [fix] sorting highscores correctly now
* [fix] since AJAX-update it was possible to not select any waypoint

= 1.1.2 =
* [fix] updating the plugin removed actual riddle files

= 1.1.1 =
* [fix] hinting system

= 1.1 =
* [mod] loading zones via AJAX now
* [add] adding new waypoints
* [loc] corrected some strings
* [add] possibility to store and display old images

= 1.0 =
* first release

== Upgrade Notice ==

= 1.1.2 =
Updating the plugin removed the actual riddle files. Updating from version 1.1.1 or smaller to 1.1.2 or later will do it once again. Make a backup of your `$PLUGIN_DIR/source/upload.jpg` and `$PLUGIN_DIR/riddle.jpg` and copy them to the same directories in `$UPLOAD_DIR/arne_riddle` after the update process is completed. Sorry for the inconvenience.
