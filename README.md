# new-site

I'm rethinking how my build process should work. I want things it to be more like a web app, with versioning, distributions, etc. This is the start of that project.

## Features

**Modules!**

A number of pre-built modules are included, including:

 - A very nice mobile menu, with a one element menu button
 - [Swiper](https://github.com/nolimits4web/Swiper) integration
 - A simple column system

**Gulp tasks!**

 - Compiles, prefixes, and compresses SCSS
 - Concatenates, and uglifies JS
 - Losslessly compresses images
 - Syncs name, version, license, etc between package.json and style.css
 - Automatically FTPs up to either a develoment or production server

**SMACSS!**

Clearly organized code following a set of guidelines means anyone can jump in!

<small>PS: I'm not SMACSS expert, but it's as close as I can get for now >.>;</small>

**Fast!**

Lots of compression, efficient code, and FontAwesome integration means a leightweight, lean framework.

**Documented!**

Check out [CONTRIBUTING.md](CONTRIBUTING.md) for information on setting up, organziation, etc. I still need to add in proper documentation throughout my code.

## Planned

**Partially synced assets with [new-site-static](https://github.com/revxx14/new-site-static)**

I'd like to keep as much code as possible shared between my WordPress framework and my static framework. This may end up being a sub-module, new-site-assets, where I add `/src/assets/captcha/` to `.gitignore` in new-site. This requires more thought and research before officially syncing the two.

**Improved Documentation**

I don't think I'm going to build out a wiki or anything, but I need to add inline documentation explaining what my code does.

**More Modules**

I need to add in more modules, things like:

 - A better search form
 - A gallery system
 - Breadcrumb navigation
 - Improved responsive tables
 - Light windows
 - Social media icons
 - More stuff as it comes up