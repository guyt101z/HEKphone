This is what it should look like to the user.


 app/auth                  # Log in
    /auth/logout           # Log out
     
    /calls/index           # List the logged in users calls and bills
    /vm/index              # List the logged in users vm-messages
    /settings/index        # Let the user modify his settings and the ones of his VM
    
    /resident/index        # List all users to edit them
             /list         -> /resident/index
             /list/by[...] #order the list by room or alphabetically
             
             /xxx/edit     # Edit the user with id xxx's details (such as unlocked, password, bankinfo)  |=> requires credential "hekphone"
             /xxx/phone    # Edit the user with id xxx's phone settings                                  |/
             /xxx/lock     # Shortcut to lock a user                                                     ||
             
             /xxx/index    -> /calls/index    (for the user with id xxx)|= => view as if you were logged in as the user xxx
             /xxx/calls    -> /calls/index    (for the user with id xxx)|==/  requires credential "hekphone"
             /xxx/vm       -> /vm/index       (for the user with id xxx)|=/   
             /xxx/settings -> /settings/index (for the user with id xxx)||
             
   /phone/edit/room/1     # edit the phone in room no nnn  |= => requires credential "hekphone"
   /phone/edit/id/xxx     # edit the phone with id xxx     |==/  easy to implement, because it's
   /phone/new             # add new phone                  |=/   a basic crud operation
   /phone/delete          # delete a phone                 ||                  
    

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
   * includes: completely disable delete&new action
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