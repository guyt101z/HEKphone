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
   /phone/delete          # delete a phone                 ||    (-> done)              
    

# TODO for the frontend #
  * <strike>Login/Logout Use symfony-default module</strike>
  * **Calls/Bills listing:**
    * <strike>Display Bill Detail</strike> _(implemented but template does not look nice)_
    * What's the cost of a call at (default: now) to ...?
  * **Voicemail:**
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
    * VM settings:
      * [option:] number of seconds till the machine answears
      * [option:] send and email on new message
        * [option:]  attach message to email
      * [option:] send email on missed call
    * Display which bank information is provided
  * **Symfony**
    * <strike>Adapt routing so we have clean urls</strike>
    * Provide a "stay signed in" option?
    * Provide a "your last login" option?
  * **Use i18n**
  * _**WRITE TESTS!**_

# TODO for the backend #
 * List users and edit details
   * <strike> includes: Unlock a user </strike>
   * ... write eMail for the resident (constantin)
   * <strike>includes: manage comments</strike> 
   * <strike>includes: change pin</strike>
   * **attach to asterisk-tables!**
   * </strike>Edit a users phone</strike>
   * Asynchronous lookup of the banknumber->bankname relation? :)
 * View, edit and delete a users cdrs and bills
 * View and edit group-calls (hannes)
 * Execute Tasks? (Create Bills,...?) (hannes)
 * Edit Rates/Prefixes

# TODO for the commandline #
  * Always use symfony-Exceptions and produce a nice output 
  * <strike>Bill Call _(done)_</strike>
  * <strike>enable call billing for SIP-Phones</strike>
  * <strike> Create Bills (migrate old script to symfony)</strike>
  * <strike>Create Bill Mails (in progres)</strike> 
  * <strike>Create the DHCP-Config from the phones-Table</strike>
  * <strike>Sync the residents data between hekdb and hekphone</strike> _Refractor and write unit test_
  * <strike>Delete old billing information and cdrs (privacy) (skeleton exists) (Hannes)</strike>
  * Warn in case of unallocated calls via eMail (Constantin)
  * <strike>Task to lock all residents moving out today and notify the user via eMail (Constantin)</strike>
  * <strike>Create Warning mails when limit is reached (Constantin/Hannes)</strike>
  * <strike>Write migration scripts from the old database to the new one (Constantin/Hannes)<strike>
