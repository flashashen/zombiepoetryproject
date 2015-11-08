=== vanilla-pdf-embed ===
Contributors: _doherty
Tags: pdf, embed
Donate link: https://flattr.com/profile/doherty
Requires at least: 3.0.1
Tested up to: 4.2.0
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Embeds PDFs in your pages and posts, without using JS.

== Description ==

### Basic use

To embed a PDF you've uploaded to your Wordpress site's media
library, simply put the URL for the attachment page in your
post on its own line. The PDF will be embedded with the
default settings at that location, as if it were using oEmbed.

#### Examples:

    Post short URL:

    http://localhost/?p=9

    Attachment default URL:

    http://localhost/?attachment_id=9

    Attachment pretty URL:

    http://localhost/test/report1/

    Media direct URL:

    http://localhost/wp-content/uploads/2013/11/report1.pdf

This doesn't work for PDFs hosted on other websites, or if you
need to change the parameters.

### Using the `[pdf]` shorttag

If the PDF isn't in your Wordpress site's media library, or if
you want to customize any parameters for the embed, then use
the `[pdf]...[/pdf]` shorttag. Between the tags, you'll provide
the URL for the PDF to embed. If the PDF is in your Wordpress
site's media library, you can either give the attachment page
URL, or the URL to the PDF file directly.

The `[pdf]` shorttag accepts several optional parameters:

  - `width` - sets the width of the frame the PDF is embedded in.
    By default, this is set to 100%.
  - `height` - sets the height of the frame the PDF is embedded
    in. By default, this is unset.
  - `title` - sets the title of the PDF, for use in the fallback
    link text.

#### Examples:

    Post short URL: [pdf width="200px"]http://localhost/?p=9[/pdf]
    Attachment default URL: [pdf height="500em"]http://localhost/?attachment_id=9[/pdf]
    Attachment pretty URL: [pdf title="Report 1"]http://localhost/test/report1/[/pdf]
    Media direct URL: [pdf]http://localhost/wp-content/uploads/2013/11/report1.pdf[/pdf]

### Compatibility

The PDF should be embedded in the page, with the document scaled so it fills the
embed frame horizontally. Unfortunately, embedding PDFs is not well-supported.

#### Auto-loading embedded PDFs

Unlike with images, web browsers may not automatically download and display
embedded PDFs when the page is loaded. For security reasons, some users prefer
not to allow the PDF plugin to run unless they trust the website the PDF comes
from. This generally leaves a grey rectangle that the user may click on to allow
the PDF to be downloaded and displayed.

#### PDF open parameters

There is currently no way to customize the [PDF open parameters](http://partners.adobe.com/public/developer/en/acrobat/PDFOpenParameters.pdf).

#### Chrome

The PDF should be scaled/zoomed within the embed frame so that the full
horizontal width of the paper fills the frame. This is [not
supported](https://code.google.com/p/chromium/issues/detail?id=64309) in
Chrome's default PDF viewer, so the document will probably be scaled to 100%,
which may either mean the document doesn't fill the frame, or, more likely, the
document is too wide for the frame, and the right-hand side of the document is
hidden.

#### Internet Explorer

Internet Explorer requires a PDF plugin to render embedded PDFs. Generally,
that's Adobe Reader. Without such a plugin, the fallback download link will be
used.

#### Mobile browsers

In particular, mobile browsers may show a grey box instead of the embedded PDF,
and will download the file when it is clicked. Other mobile browsers might embed
the PDF, but won't allow it to scroll.

### Alternatives

Your best alternative is to **not** embed PDFs. PDFs are bad for many reasons:
not easily indexed by search engines, not easily accessible by readers who use
assistive technologies, poorly supported by web browsers (as seen above) and so
on. They're just **bad** and you should avoid embedding PDFs if you can.

If you *really* can't, then you might consider using another solution like
<http://pdfobject.com/> or [PDF.js](https://mozillalabs.com/en-US/pdfjs/).

== Installation ==
1. Upload `vanilla-pdf-embed.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the "Plugins" menu in the WordPress admin panel

== Changelog ==

= 0.0.7 =
  - Fix a couple corner cases - thanks AngelinaBelle!

= 0.0.6 =
  - Set a default height of 500em

= 0.0.5 =
  - Fix a simple programming error; thanks to firedog341 for the report

= 0.0.4 =
  - By default, use a 100% width embed frame
  - Expanded readme

= 0.0.3 =
  - Embed PDFs on attachment pages
  - Fix a spacing issue for PDFs with no title
  - Don't use PDF open parameters for the fallback link

= 0.0.2 =
  - Don't embed non-PDFs from the media library

= 0.0.1 =
  - Initial release
