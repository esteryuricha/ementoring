/* eslint-disable linebreak-style */
/* eslint-disable no-unused-vars */
require(['jquery', 'core/modal_factory', 'core/modal_events', 'core/ajax', 'core/notification'], function($, ModalFactory, ModalEvents, Ajax, Notification) {
    var trigger = $('.local_event_delete_button');
    ModalFactory.create({
       type: ModalFactory.types.SAVE_CANCEL,
       title: 'Delete Program',
       body: '<p>Are you sure to delete this program ?</p>',
       preShowCallback: function(triggerElement, modal) {
          triggerElement = $(triggerElement);
 
          let id = triggerElement[0].value;
 
          modal.params = {'id': id};
          modal.setSaveButtonText('Delete Program');
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
                methodname: 'local_event_delete_event',
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