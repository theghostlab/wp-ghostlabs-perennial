=== Dynamic Copyright – Auto-Updating Copyright Year Block ===
Contributors: ghostlabs
Tags: copyright, copyright year, current year, footer, year
Requires at least: 6.4
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Keeps your footer's copyright year current automatically — server-rendered, no JavaScript. Never edit a footer on New Year's Day again.

== Description ==

Every site has a copyright line in the footer, and every site eventually has the wrong one —
because the year was typed in by hand and nobody remembered to change it.

This plugin adds a single block that works the year out when the page is served, so the notice
is right on 1 January without anyone touching it.

**What it does**

* Shows the current year, resolved in **your site's timezone** — not the visitor's browser.
* Optionally shows a range — `© 2001 – 2026` in English. Set the start year to the current
  year and it shows that year on its own rather than a range of one. The format is
  translatable, so a locale can set its own separator, numerals or placement for the © symbol.
* Uses your **site title** as the copyright holder by default, so renaming the site updates
  every notice at once. Type a different name if you want one.
* Optionally appends "All rights reserved.", punctuated correctly.
* Lets you style the **year separately from the rest of the notice** — its own color, font
  size and weight. The © symbol follows the year's styling.

**Built to stay correct**

The notice is rendered on the server, which matters more than it sounds:

* The year is never written into your post content, so it cannot go stale, and your saved
  posts never break when the year rolls over.
* Search engines see the finished text in the page source, with no JavaScript to run first.
* **No JavaScript is loaded on the front end at all** — on any theme. On a block theme the
  stylesheet is inlined into only the pages that use the block; on a classic theme WordPress
  loads every registered block's stylesheet site-wide, including this one.

The one thing server rendering cannot fix is somebody else's copy of the finished page. So when
the year turns over, the plugin clears the cache for you on **WP Rocket, W3 Total Cache, WP Super
Cache and LiteSpeed Cache** — those four. Any other cache can clear itself by hooking the rollover
action; see the FAQ.

Alignment, color, spacing, font size and line height all come from the standard WordPress block
controls, so the notice inherits your theme's palette and type scale rather than fighting it.

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/`, or install it through the Plugins screen.
2. Activate it through the **Plugins** screen.
3. In any post, page or template, add the **Dynamic Copyright: Notice** block.

Block themes: add it to your footer template in the Site Editor and every page picks it up.

== Frequently Asked Questions ==

= Do I have to do anything on 1 January? =

No. The year is worked out each time the page is served.

= I use a caching plugin. Will the year still update? =

The notice itself is always right — it is worked out when the page is served. What can go stale
is a cached copy of the finished page: one cached on 31 December keeps serving last year's
notice until that cache is cleared.

So the plugin clears it, on four caching plugins by name. The first request of the new year that
WordPress actually builds notices the year has changed and clears the cache. There is no
scheduled task and nothing to configure — a cached page is served without WordPress ever loading
this plugin, so the only thing that can trigger the check is the next request that is not served
from cache: an admin opening the dashboard, a logged-in reader, a crawler, or any page the cache
is not already holding.

**Cleared for you:** WP Rocket, W3 Total Cache, WP Super Cache and LiteSpeed Cache — those four,
and no others. Each is asked for a full flush, so on W3 Total Cache and LiteSpeed that clears
their object caches too; once a year, deliberately. Each one ties this plugin to somebody else's
code, so the list stays deliberately short; the hook in the next question is what scales.

**Any other cache:** if it expires at least once a year, it corrects itself the next time it
expires — which with a twelve-month lifetime can be most of a year. With very long or indefinite
lifetimes, clear your page cache once after New Year, or set your caching plugin to purge on a
schedule.

= Can I clear my own cache when the year rolls over? =

Yes — two hooks, both reached on that same first request of the new year. Neither fires on a
brand-new install, which has no previous year on record to compare against.

The `ghostlabs_dynamic_copyright_year_rolled_over` action is passed the new year and the year
before it. It fires whether or not this plugin clears anything, so it is the place to purge a
cache, CDN or host layer this plugin does not know about.

`add_action( 'ghostlabs_dynamic_copyright_year_rolled_over', function ( $current, $stored ) {
    // Clear your own cache here.
}, 10, 2 );`

The `ghostlabs_dynamic_copyright_purge_on_rollover` filter defaults to `true`. Return `false`
and the plugin clears nothing itself. The action above still fires, so you can decline the
built-in purge and still handle it your own way.

= Which year does it use if my visitors are in other countries? =

Your site's, as set in **Settings → General → Timezone**. Working it out in the visitor's
browser instead would mean someone in Auckland and someone in Los Angeles could see different
years for a few hours around New Year.

= What if I leave the name blank? =

The notice uses your site title, and keeps using it — so if you rename the site later, every
notice updates. Type a name only if you want it to differ from the site title.

= Can I make the year a different color or size from the rest of the line? =

Yes. Select the block, open the **Styles** tab, and use **Year typography** and **Year color**.
These affect only the year and the © symbol. The rest of the notice uses the block's normal
color and typography controls.

The year's font size is offered in `rem`, `em`, `ch` and `%` rather than pixels, so it scales
with your theme and with a reader's text-size settings. The block's own font size control offers
whatever units your theme does.

== Screenshots ==

1. The rendered notice in a site footer. The year is worked out when the page is served, so it turns over on 1 January by itself — nothing is stored in your content.
2. Set a start year and the notice reads as a range — © 2016 – 2026 — with the end always the current year. The Statement of rights toggle appends "All rights reserved.", punctuated for you.
3. The year and its © symbol get their own size, weight and color, set separately from the rest of the line — so it can carry the footer without the notice shouting.
4. Add it once to your block theme's footer template part in the Site Editor, and every page that uses that footer carries the notice.

== Changelog ==

= 1.0.0 =
* First release.
* The notice is rendered on the server, so a saved year can never go stale and posts do not
  break when the year changes.
* Separate color and typography controls for the year and © symbol.
* The copyright holder follows the site title when left blank, rather than being fixed at the
  moment the block was inserted.
* Alignment, color and typography settings apply on the front end.
* The cache is cleared when the year turns over, on WP Rocket, W3 Total Cache, WP Super Cache
  and LiteSpeed Cache. The check runs on the first request of the new year that WordPress
  handles itself rather than serving from cache — a page view, an admin screen, a REST call or
  a crawler. There is no scheduled task.
* Added an action, `ghostlabs_dynamic_copyright_year_rolled_over`, passed the new and previous
  year, so any other cache, CDN or host layer can clear itself.
* Added a filter, `ghostlabs_dynamic_copyright_purge_on_rollover` (default true), to turn the
  plugin's own purging off. The action fires either way.
* The year range uses an en dash — © 2001 – 2026 — which is the correct punctuation for a
  range, and the year format is translatable.

== Upgrade Notice ==

= 1.0.0 =
First release.
