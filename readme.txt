=== Mailbob ===

Stable tag:        0.1.1
Contributors:      Kafleg, soulseekah, kovshenin, mailbob
Tags:              blocks, editor, gutenberg, gutenberg blocks, Mailbob, subscription, newsletter
Requires at least: 6.1
Tested up to:      6.6
Requires PHP:      7.0
License:           GPLv2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

This plugin adds Block Editor blocks and a floating subscription widget for Mailbob.io

=== Installation ===

Download, activate. Head over to the Mailbob Settings section as an administrator and click "Connect" to authorize your Mailbob account.

=== Contributing ===

The plugin source code is available at https://github.com/mailbob-io/mailbob-wp

=== External service disclosure ===

This official Mailbob.io integration plugin relies the following external URIs for proper operation:

 - https://mailbob.io/connect/ to authenticate your Mailbob.io account, we store your WordPress website domain and your Mailbob.io account
 - https://api.mailbob.io/subscribe/ to initiate your users' subscribption to your newsletter (double opt-in is required), the email address and the API key is sent
 - https://mailbob.io/static/embed.js to embed the floating subscription widget on any website, be it WordPress or not

When requesting these resources the following information will be logged: IP address, browser User-Agent, the time the request was made.

API reference: https://mailbob-docs.notion.site/API-Reference-f647d36f0bc14d1cb07ab75dab50aa4d
Privacy policy: https://mailbob.io/privacy/
