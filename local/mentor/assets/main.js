/* eslint-disable linebreak-style */
/* eslint-disable no-unused-vars */
require(['jquery', 'core/modal_factory', 'core/modal_events', 'core/ajax', 'core/notification'], function($, ModalFactory, ModalEvents, Ajax, Notification) {
   $(document).ready(function() {
      $("#id_submitbutton").attr('disabled','disabled');
   })
   
   $("#email").blur(function() {
      var email = this.value;
      let request = {
          methodname: 'local_mentor_check_email',
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
   
   var trigger = $('.local_mentor_delete_button');
    ModalFactory.create({
       type: ModalFactory.types.SAVE_CANCEL,
       title: 'Delete Mentor',
       body: '<p>Are you sure to delete this mentor ?</p>',
       preShowCallback: function(triggerElement, modal) {
          triggerElement = $(triggerElement);
 
          let id = triggerElement[0].value;
 
          modal.params = {'id': id};
          modal.setSaveButtonText('Delete Mentor');
       },
       large: true
    }, trigger)
    .done(function(modal) {
       // Do what you want with your new modal.
       modal.getRoot().on(ModalEvents.save, function(e) {
          // Stop the default save button behaviour which is to close the modal.
          e.preventDefault();
 
          let footer = Y.one('.modal-footer');
          footer.setContent('Deleting...');
          let spinner = M.util.add_spinner(Y, footer);
          spinner.show();
          let request = {
                methodname: 'local_mentor_delete_mentor',
                args: modal.params,
          };
          Ajax.call([request])[0].done(function(data) {
                if (data === true) {
                   // Redirect to manage page.
                   window.location.reload();
                } else {
                   Notification.addNotification({
                      message: 'fail',
                      type: 'error',
                   });
                }
          }).fail(Notification.exception);
       });
    });
 });