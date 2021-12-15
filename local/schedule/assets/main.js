require(['core/first', 'jquery', 'core/ajax', 'core/modal_factory', 'core/modal_events', 'core/notification'], function(core, $, Ajax, ModalFactory, ModalEvents, Notification) {
    $(document).ready(function() {
        $("#eventid").on('change', function() {
            var eventid = this.value;
            let request = {
                methodname: 'local_schedule_getdates',
                args: {id: eventid},
            };
            Ajax.call([request])[0].done(function(data) {
                const obj = JSON.parse(data);
                var startint = parseInt(obj.timestart);
                //var startdate = new Date(1000*startdate);
                //var enddate = new Date(1000*(parseInt(obj.timestart) + parseInt(obj.timeduration)));
                var endint = startint + parseInt(obj.timeduration);
                $("#selecteddate").val(startint);

                $("#availabledates").empty();

                for(var d = new Date(1000*startint); d <= new Date(1000*endint); d.setDate(d.getDate() + 1 ) ) {
                    $("#availabledates").append("<option value='"+new Date(d).getTime()/1000+"'>"+new Date(d).toLocaleDateString()+"</option>");
                }
            }).fail();
        });

        $("#availabledates").on('change', function() {
            $("#selecteddate").val(this.value);
        });

        var trigger = $('.local_schedule_delete_button');
        ModalFactory.create({
           type: ModalFactory.types.SAVE_CANCEL,
           title: 'Delete schedule',
           body: '<p>Are you sure to delete this schedule ?</p>',
           preShowCallback: function(triggerElement, modal) {
              triggerElement = $(triggerElement);
     
              let id = triggerElement[0].value;
     
              modal.params = {'id': id};
              modal.setSaveButtonText('Delete schedule');
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
                    methodname: 'local_schedule_delete_schedule',
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
});