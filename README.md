# ComicControl, but Different

Hi! I'm Mr. Encyclopedia, a web development dilettante attempting to continue the work of Erin Burt, the former Hiveworks developer that produced the ComicControl CMS. This public repository is here to document the changes I've made to ComicControl in the hopes it helps other small creators and developers. I can also try to help troubleshoot your Original Flavor or Extra Crispy version of ComicControl if you're having issues running it on your own server. I can't guarantee these changes will work for you. I can't even guarantee they work for me. I'm terrible at version control so there's a good chance this public copy doesn't match what I'm currently running live but I am doing my best to keep what's here internally consistent and functional. I'd appreciate any support and feedback that anyone else can provide, either in public or in private.

## What's Different

**PHP 8:** ComicControl now runs on PHP 8. The bad news is PHP 8 is now required. *TODO:* QA for PHP 8 bugs especially during install.

**Improved template editing:** ace editor with syntax highlighting and line numbers replaces default text box. Supports HTML/PHP, CSS, and JS files. *TODO:* figure out how to activate more features of Ace, like find/replace.

**Unified RSS:** one file now handles generating RSS feeds for both Comic and Blog posts. Also RSS author is not hard coded to “tech@hiveworks.com” *TODO:* add ability for users to customize RSS feeds, may be as simple as putting the RSS file with the templates rather than in parts.

**Comic scheduling:** ComicControl now supports setting default post times and dates. Comics can be set to always post at the same time of day and default to posting a set interval past the newest post. *TODO:* add sanity check to ensure two comics can not be published at the exact same time.

**Image library improvements:** Images uploaded via the rich text editor now appear in the image library. This allows users to keep better track of what images have been uploaded and delete them if desired. Deleting an image from the image library will now also delete the image file. 

**Comic backend improvements:** You can now add a comic to a storyline directly from the storyline editing interface. When a comic post is deleted or the image file for a comic is changed the old unused image will be deleted.

**Gallery improvements:** When a gallery image is changed or deleted the corresponding gallery post will also be deleted. Galleries can now be set to sort ascending or descending. This means users can choose if newly added images appear at the top or the bottom without affecting the ability to reorder images. In addition, a secondary display mode has been added to galleries, where the text description will be displayed next to the thumbnail instead of below the lightbox view. This is useful for making character profile pages.

## What's Still To Come

* Build a new simple default template for new users.
* Build a Wiki module.
* Build a Twine game module.
* Add support for oEmbed, Open Graph, and Twitter Cards.
* Add support to auto-generate favicons from a user-supplied file.

### What Might Also Be Still To Come

* AWS integration?
* Multiple images per comic?
* Basic non-invasive tracking features?
* Native comments system?

### Legal CYA Statement

This repository is provided to assist self-publishing by individuals and not-for-profit entities in accordance with the Intended Use of the Software as defined in the [ComicControl End User Software License Agreement](http://comicctrl.com/full-free-license-text/full-free-license-text). Per section 6.4 of that agreement all changes demonstrated by this repository are the sole property of ComicControl LLC. Use of the software in this repository is subject to the ComicControl End User Software License Agreement. 
