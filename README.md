# Sefaria Text Insert
A WordPress plugin for inserting text from the [Sefaria](http://sefaria.org) database into the post editor.

[![powered-by-sefaria](/readme-images/powered_by_sefaria_badge_182.png)](http://sefaria.org)

**Note:** This plugin is a work-in-progress. Though we don't think it does anything that could mess-up your site, please know that you're installing it at your own risk.

##Installation
1. Download the repository as a ZIP file, or clone it to your desktop using git.
2. **Web Install:** From your site's WordPress dashboard, select "Add New" under the Plugins menu item. Click the "Upload Plugin" button, and upload the plugin's ZIP file.<br/>**FTP Install:** Extract the ZIP file and upload it via FTP to your site's Plugins directory (/wp-content/plugins/).
3. Once installed, click "Activate" to activate the plugin.

##Usage
1. To use the plugin, select any post, page, or custom post type to edit. (Or create a new one.) On the edit screen, you'll have a button labeled "Add Text", right next to the add media button.<br/><br/>![button](/readme-images/text-button.png)

2. Click the button to open the dialogue box. In the field, type/paste a text reference (see below), and then click "Add Source."<br/><br/>![text-ref](/readme-images/enter-text-ref.png)<br/>

###About References
In order to designate which text you'd like the plugin to "fetch", you'll need to provide a **text reference**, which in most cases the book, chapter, and verse. For example, the text reference <span style="color: rgb(90, 153, 183);">Genesis 22:7</span> will yield:
<blockquote style="text-align:center;width: 80%;margin-left:auto;margin-right:auto;"><span style="font-size: 120%;font-weight: 500; display: block;padding-bottom: 10px;	margin-top:12px;font-style: normal;line-height:1.6;	direction: rtl;">וַיֹּ֨אמֶר יִצְחָ֜ק אֶל־אַבְרָהָ֤ם אָבִיו֙ וַיֹּ֣אמֶר אָבִ֔י וַיֹּ֖אמֶר הִנֶּ֣נִּֽי בְנִ֑י וַיֹּ֗אמֶר הִנֵּ֤ה הָאֵשׁ֙ וְהָ֣עֵצִ֔ים וְאַיֵּ֥ה הַשֶּׂ֖ה לְעֹלָֽה׃</span> <span style="display: block;
	font-size: 100%; font-style: normal;font-weight: 300;text-transform: none;font-family: Georgia, serif;	line-height: 1.4;">Then Isaac said to his father Abraham, “Father!” And he answered, “Yes, my son.” And he said, “Here are the firestone and the wood; but where is the sheep for the burnt offering?”</span><cite style="display: inline-block;	font-family: proxima-nova, 'Helvetica Neue', Helvetica, sans-serif;	font-size: 85%;height: auto;letter-spacing: 1px;line-height: 21px;text-align: center;visibility: visible;	width: auto;display: inline-block;font-weight: 300;padding-top: 6px;
">Genesis 22:7</cite></blockquote>
Alternatively, the reference <span style="color: rgb(90, 153, 183);">Genesis 22</span> will return the entire 22nd chapter of Genesis, and <span style="color: rgb(90, 153, 183);">Genesis</span> will return the book of Genesis in its entirety.

In general, a single verse is the smallest unit of information you can reference. However, since the text fetched by the plugin is simply inserted into your editor (rather than being embedded), you can shorten it to meet your own needs.

Sefaria's text referencing system is one of its most robust features. Though they're the primary means of communication with Sefaria's repository database, text references are intended to be "human readable," and should flexibly accommodate human variation, such as alternate spellings. For example, the following are all valid references:
* <span style="color: rgb(90, 153, 183);">Genesis 22:7</span>
* <span style="color: rgb(90, 153, 183);">Gen 22:7</span>
* <span style="color: rgb(90, 153, 183);">Bereishit 22.7</span>
 
Documentation on text references in Sefaria can be found [on Sefaria's GitHub wiki](https://github.com/Sefaria/Sefaria-Project/wiki/Text-References). 


