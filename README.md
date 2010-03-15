# BlogMenu Module

## Maintainer Contact
Saophalkun Ponlu (Nickname: phalkunz)
<phalkunz (at) silverstripe (dot) com>

## How does it work?

This module adds an ability to display a blog entry in more than one navigation menu. Each blog menu acts as its own blog tree or blog holder meaning that the entries are displayed in the order from the latest date descending. The entries can be displayed using tag, date and pagination in each blog menu item. 

## Requirements

 * SilverStripe 2.3 or newer
 * Blog module 

## Installation

 * Check out from the module (http://svn.silverstripe.com/open/modules/blogmenu/trunk)
 * Update database schema (dev/build?flush=1)

## Usage

By default, this module hides blog trees and blog holders from navigation menu because, by adding this module, blog entries are meant to display in blog menus on the site. 

You would add blog menus in the site tree in the CMS as you would with normal pages and they can be nested. Blog entries would be still organised in blog holders and blog trees but it doesn't affect what displays on the site. For each blog entry, you can assign it to different blog menus using "Menu" tab of blog entry in the CMS.   

**For site with Blogs already in place:**

1. Install the module
2. Uncheck the "Show In Menus" checkboxs on all blog holders
3. Create new blog menu structure (e.g. Parent Blog menu items and any child menu items)
4. Open each blog entry and select which menu items you want the entry to be displayed in
5. Save and publish