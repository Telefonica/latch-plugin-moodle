#LATCH INSTALLATION GUIDE FOR MOODLE


##PREREQUISITES 

 * Any version of Moodle between 2.3.11 and 2.7.1.
 
 * Curl extensions active in PHP (uncomment "extension=php_curl.dll" or "extension=curl.so" in Windows or Linux php.ini respectively. 

 * To get the **"Application ID"** and **"Secret"**, (fundamental values for integrating Latch in any application), it’s necessary to register a developer account in [Latch's website](https://latch.elevenpaths.com"https://latch.elevenpaths.com"). On the upper right side, click on **"Developer area"**.

 
##DOWNLOADING THE MOODLE PLUGIN
 * When the account is activated, the user will be able to create applications with Latch and access to developer documentation, including existing SDKs and plugins. The user has to access again to [Developer area](https://latch.elevenpaths.com/www/developerArea"https://latch.elevenpaths.com/www/developerArea"), and browse his applications from **"My applications"** section in the side menu.

* When creating an application, two fundamental fields are shown: **"Application ID"** and **"Secret"**, keep these for later use. There are some additional parameters to be chosen, as the application icon (that will be shown in Latch) and whether the application will support OTP  (One Time Password) or not. Moodle OTP functionality must be disabled.

* From the side menu in developers area, the user can access the **"Documentation & SDKs"** section. Inside it, there is a **"Plugins and SDKs"** menu. Links to different SDKs in different programming languages and plugins developed so far, are shown.


##INSTALLING THE PLUGIN IN MOODLE
* When the administrator has obtained the plugin, it should be installed in Moodle. To do so, they should be logged out of Moodle and the content of the uncompressed file should be copied to the Moodle root directory.
 
* After copying the plugin, access Moodle with your username and password, and it will indicate that the Latch plugin is pending installation.

* After tapping the button on the lower part of the screen the plugin installation will take place. 


###Configuring the installed plugin

* Following installation, the installed plugin must be set up. To do so, the administrator should go to the **"Manage authentication"** section, under the **"Site administration - Plugins - Authentication"** menu and enable the Latch plugin, by tapping the eye shaped icon under the **"Enable"** column. The Latch plugin should be the last item on the plugin list.	

* After enabling the plugin, enter the *"Application ID"* and the *"Secret"* that were generated when the application was created. To do so, enter the section corresponding to **"Latch"** under the **"Site administration - Plugins - Authentication"** menu. After entering such data tap the **"Save changes"** button. 

* Latch is ready to be used by the user. 


##UNINSTALLING THE PLUGIN IN MOODLE
* Uninstalling the plugin from Moodle is very simple. To do so the administrator should go to the **"Manage authentication"** section, under the **"Site administration - Plugins - Authentication"** menu and tap the **"Uninstall"** link for the Latch plugin.

* After tapping the **"Continue"** button, the uninstallation of the plugin will begin. 


##USE OF LATCH MODULE FOR THE USERS
**Latch does not affect in any case or in any way the usual operations with an account. It just allows or denies actions over it, acting as an independent extra layer of security that, once removed or without effect, will have no effect over the accounts, that will remain with its original state.**

###Pairing a user in Moodle
The user needs the Latch application installed on the phone, and follow these steps:

* **Step 1:** While in your Moodle account go to the “My Profile settings – Edit profile” section, and access the "Latch" section.

* **Step 2:** From the Latch app on the phone, the user has to generate the token, pressing on **“Add a new service"** at the bottom of the application, and pressing **"Generate new code"** will take the user to a new screen where the pairing code will be displayed.

* **Step 3:** The user has to type the characters generated on the phone into the text box displayed on the web page. Click on **"Update Profile"** button.

* **Step 4:** Now the user may lock and unlock the account, preventing any unauthorized access.

###Unpairing a user in Moodle
* The user should access their Moodle account and under the **“My Profile settings – Edit profile”** section, access the **“Latch”** section. Check the verification box **“Click here to unpair”**, then tap the button **“Update profile”**. Finally, an alert indicating that the service has been unpaired will be displayed.




##RESOURCES
- You can access Latch´s use and installation manuals, together with a list of all available plugins here: [https://latch.elevenpaths.com/www/developers/resources](https://latch.elevenpaths.com/www/developers/resources)

- Further information on de Latch´s API can be found here: [https://latch.elevenpaths.com/www/developers/doc_api](https://latch.elevenpaths.com/www/developers/doc_api)

- For more information about how to use Latch and testing more free features, please refer to the user guide in Spanish and English:
	1. [English version](https://latch.elevenpaths.com/www/public/documents/howToUseLatchNevele_EN.pdf)
	1. [Spanish version](https://latch.elevenpaths.com/www/public/documents/howToUseLatchNevele_ES.pdf)

