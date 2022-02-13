/* eslint-disable linebreak-style */
/* eslint-disable no-unused-vars */
require(['jquery', 'core/modal_factory', 'core/modal_events', 'core/ajax', 'core/notification'], function($, ModalFactory, ModalEvents, Ajax, Notification) {
   $(document).ready(function() {
      $("#id_submitbutton").attr('disabled','disabled');
   })
   
   $("#email").blur(function() {
      var email = this.value;
      let request = {
          methodname: 'local_sponsor_check_email',
          args: {email: email},
      };
      Ajax.call([request])[0].done(function(data) {      

         if(data == "Allowed") {
            $("#id_submitbutton").removeAttr('disabled');
         }else{
            $("#id_submitbutton").attr('disabled','disabled');
         }

         $("#email_check").html(data);

      }).fail();
   }); 
});