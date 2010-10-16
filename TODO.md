# TODO for the frontend #
  * Login/Logout Use symfony-default module
  * **Calls/Bills listing:**
    * Display Bill Detail _(implemented but template does not look nice)_
      * ... using AJAX
      * ... routes for simple access
    * What's the cost of a call at (default: now) to ...?
  * **Answearing Machine:**
    * List Messages:
      * ... distinguish between read and unread messages
      * ... mark as read & delete messages
      * ... only 25 messages per page
      * ... download option
      * ... embedded player
      * ... newsfeed?
    * Link to settings
  * **Settings:** 
    * Change email-adress
      * confirm email adress
    * Change password (should this equal the pin?)
    * AM settings:
      * [option:] number of seconds till the machine answears
      * [option:] send and email on new message
        * [option:]  attach message to email
      * [option:] send email on missed call
    * Display which bank information is provided
  * **Symfony**
    * Adapt routing so we have clean urls
    * Provide a "stay signed in" option?
    * Provide a "your last login" option?
  * **Use i18n**
  * _**WRITE TESTS!**_

# TODO for the backend #
 * Implement singel sign in for frontend&backend using credentials
   * could be kind of tricky if frontend and backend are seperated applications
   * but why seperate them?
 * List users and edit details (doctrine:generate-admin)
   * includes: Unlock a user
   * includes: manage comments
   * includes: change pin
   * **attach to asterisk-tables!**
   * Edit a users phone
   * Asynchronous lookup of the banknumber->bankname relation? :)
 * View, edit and delete a users cdrs and bills
 * View and edit group-calls
 * Execute Tasks? (Create Bills,...?)
 * Edit Rates/Prefixes

# TODO for the commandline #
  * Always use symfony-Exceptions and produce a nice output 
  * <strike>Bill Call _(done)_</strike>
    * enable call billing for SIP-Phones
  * Create Bills (migrate old script to symfony)
  * Create Bill Mails (keep using the MailTemplate-Enginge or migrate to symfony) (skeleton exists; merge with create bills?)
  * Create one singel bill (skeleton exists)
  * <strike>Create the DHCP-Config from the phones-Table</strike>
  * <strike>Sync the residents data between hekdb and hekphone</strike>
  * Delete old billing information and cdrs (privacy) (skeleton exists)