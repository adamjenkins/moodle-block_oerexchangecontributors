# OER Exchange: contributors

A Moodle Dashboard block for the [OER Exchange](https://github.com/adamjenkins/moodle-local_oerexchange)
platform. It shows the people who publish to the Exchange as cards, ordered by
what they have contributed, and links each card to that contributor's profile.

## What it shows

One card per contributor:

- profile picture and name;
- any badges they hold, such as **Trusted Contributor**;
- up to three expertise tags from their profile;
- how many resources and how many courses they have shared;
- how recently they last shared something.

The whole card is clickable and opens that contributor's public profile.

A sort control at the top offers **Most resources shared**, **Most courses
shared** and **Recently shared**. It re-sorts the list in place; with
JavaScript turned off the same control still works as an ordinary form that
reloads the page. A footer link opens the full listing of every contributor at
`/local_oerexchange/contributors`.

## Who appears

- Only people with at least one resource **currently published** in the
  catalogue. Someone whose resources are all pending, hidden or taken down does
  not appear.
- Only people who have left their Exchange profile **publicly visible**. Hiding
  your profile removes you from the listing.
- **Co-authors count.** A co-author holds exactly the same rights over a
  resource as its creator, so they earn the same recognition, and a resource
  counts once for each of them.
- Deleted and suspended accounts never appear.

## Settings

Site-wide, under *Site administration ▸ Plugins ▸ Blocks ▸ OER Exchange:
contributors*:

| Setting | Default | Meaning |
|---|---|---|
| Contributors to show | 6 | How many cards a block shows |
| Sort on load | Most resources shared | The order before the viewer changes it |

Every block instance can override both on its own configuration form, or leave
them set to *Use the site default*.

## Where it can go

The Dashboard (`/my/`) and the site front page. Note that if
`local_oerexchange`'s **public landing** setting is on, anonymous visitors are
served the catalogue at the site root and never reach the normal front page, so
on such a site this block reaches logged-in visitors only.

## Requirements

- Moodle 5.0–5.2, PHP 8.2–8.4.
- `local_oerexchange` 2026082200 or later. The block renders that plugin's
  `contributor_list` class and cannot work without it; the installer enforces
  the dependency.

## Privacy

The block stores no data of its own. It displays information
`local_oerexchange` already stores, and the sort choice is transient — a URL
parameter and an AJAX call, never a saved preference.

## Licence

GPL-3.0-or-later. See [LICENSE](LICENSE).
