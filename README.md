# phpBB Extension — Purge cache from any page

[Topic on phpbbguru.net](https://www.phpbbguru.net/community/viewtopic.php?t=51185)

This phpBB extension allows you to purge phpBB cache with one click (no confirmation popup) from any page using small button in the top left corner of the window. It is intended to be used by an administrator for development/debugging purposes; the button is visible to administrators only.

## Requirements

* phpBB 3.3+
* PHP 7.1+

## Quick Install

You can install this on the latest release of phpBB 3.3 by following the steps below:

* Create `nekstati/purgify` in the `ext` directory.
* Download and unpack the repository into `ext/nekstati/purgify`
* Enable `Purge cache from any page` in the ACP at `Customise -> Manage extensions`.

## Uninstall

* Disable `Purge cache from any page` in the ACP at `Customise -> Extension Management -> Extensions`.
* To permanently uninstall, click `Delete Data`. Optionally delete the `/ext/nekstati/purgify` directory.

## Support

* Report bugs and other issues to the [Issue Tracker](https://github.com/nekstati/phpBB-Purgify/issues).

## License

[GPL-2.0](license.txt)

## Screenshots

### Button

![Button](/doc/screenshot.png)
