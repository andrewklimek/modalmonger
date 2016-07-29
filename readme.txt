=== Modal Monger ===
Contributors: andrewklimek
Donate link: http://ambientsleepingpill.com/
Tags: modal, popup, pop up
Requires at least: 2.5
Tested up to: 4.5
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

a very light modal shortcode that isn't that ugly

== Description ==

Create a fairly elegant modal out of anything... [modalmonger]like this[/modalmonger]

Works with multple modals on a page.

Uses just a small amount of JavaScript, no extra scripts or libraries to load.

Simply wrap the shortcode around any content you want, for example:

[modalmonger text='Click Here' href='//getjavascript.com']<h1>Register</h1>[formidable id=25][/modalmonger]

Here's an overview of the attributes.  All are optional.

* width = include units (px, %, whatever)
* height = same
* suffix = normally the modal gets a random unique id, like id='modalmonger-7869348756' but if you want to change the numeric portion you can specify it here.

These 4 relate to the link that launches the modal:

* label = the text of the link (can include html, just make sure you alternate quotes)
* href = the url for the link.  This is just an optional a fallback in case someone doesn't have javascript enabled, so maybe a link to a page with the form.
* id = if you want to an an id to the link
* class = if you want to add any class to the link

Also there's a login attribute if you want to make a login form.  just do login=1.

== Installation ==

1. Install as you would any plugin.

== Frequently Asked Questions ==

Nothing's been asked yet!

== Screenshots ==

== Changelog ==

= 0.1 =
* Initial Release