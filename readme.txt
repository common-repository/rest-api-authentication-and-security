=== REST API Authentication and Security ===
Contributors: rfsecurity
Tags: api, rest api, jwt, secure api, api authentication, jwt auth, jason web tokens, oauth
Requires at least: 4.7
Tested up to: 6.6
Stable tag: 1.0.0
Requires PHP: 7.0
License: GPLv2

Add a security layer to your WordPress site, and protect your WordPress rest endpoints with various authentication methods.

== Description ==
**WordPress Rest APIs** can be used for various integrations however they are not secured by default, which can lead to security issues and data leaks.
Adding an **authentication layer** is a simple method to make sure that your APIs are protected from any unauthorized access. Adding a basic authentication layer is the first step towards making your site secure.
You can use this authentication for various third-party integrations like Android/IOS app integrations, REST API integrations for your headless WordPress setup, data sync solutions, etc.
You can choose from various authentication methods like JWT authentication, API key authentication, OAuth authentication, etc to have a secure API.
This plugin makes sure that you have secure API and that your data stays where it should and is never compromised.
The WordPress REST API authentication and WordPress REST API Security plugin will make sure that users are only able to access your site resources after successful authentication with the method of your choice such as JWT authentication, OAuth authentication, API key authentication, basic authentication, etc. 

== WordPress REST API Authentication methods available in the plugin ==
**Basic Authentication**: This method allows you to use a WordPress user's username and password to securely authenticate REST API requests and protect your WordPress REST API.

**JWT Authentication**: With this method, you can use JWT (JSON Web Token) to authenticate and secure your REST API. The JWT token is verified by the plugin to check the user's authorization before they can access the API. The WordPress REST API authentication plugin issues a JWT token to a user by passing valid user credentials, this JWT token can then be used to authenticate further REST API calls.

*Note: We are constantly adding support for new authentication methods, if you are looking for a method and can't find it in the plugin please reach out to us at <a href="mailto:support@rainforestsecurity.com">support@rainforestsecurity.com</a>*

== Features ==
FREE PLUGIN
* Protect all or select WordPress REST API.
* Basic authentication with WordPress username and password, this can also be converted into a token by base64 encoding the credentials to have a secure API.
* Allow or deny public access to your Rest API and make the critical REST APIs secure.
* Authentication for standard WordPress REST API.
* [Coming Soon] JWT token based authentication, the plugin can issue a JWT token to the user which can then be used for WordPress rest API authentication.
* [Coming Soon] An REST API that can issue JWT (JASON web tokens) to users. You can use this to access all the WordPress Rest APIs.

== Installation ==
1. Download the plugin.
2. From the WordPress Admin Panel, click on Plugins => Add New.
3. Click on Upload, so you can directly upload your plugin zip file.
4. Use the browse button to select the plugin zip file that was downloaded, and then click on Install Now.
5. Once installed, click "Activate".

== Frequently Asked Questions == 
= Why should I use REST API Authentication =
REST API Authentication protects your site against data leaks and security issues.

= The authentication method I want is not listed =
We are working on adding new authentication methods like JWT, OAuth, API Key, etc. And will add those in future releases you can reach out to us at <a href="mailto:support@rainforestsecurity.com">support@rainforestsecurity.com</a> to get early access to some of these features.

= I have a headless WordPress setup can I use this plugin =
Yes, you can definitely use this plugin to integrate with a headless SSO setup, feel free to reach out to us at <a href="mailto:support@rainforestsecurity.com">support@rainforestsecurity.com</a> if you need any assistance with this solution.

= What WordPress REST API authentication method should I choose =
While the choice of authentication method is subjective to your use case we recommend at least using the JWT authentication as it offers more security than the Basic Authentication. 

== Screenshots ==
1. Protect selected APIs.
2. Authentication method configuration.

== Changelog ==
= 1.0.0 =
* Initial Release: REST API Protection with Basic Authentication Method.

== Upgrade Notice ==
= 1.0.0 =
* Initial Release: REST API Protection with Basic Authentication Method.