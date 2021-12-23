require(['core/first', 'jquery', 'core/ajax', 'core/modal_factory', 'core/modal_events', 'core/notification'], function(core, $, Ajax, ModalFactory, ModalEvents, Notification) {
    $("#call_modal").on('click', function() {
        let request = {
            methodname: 'mod_schedule_get_schedules',
            args: {'id' : this.value},
        };
        Ajax.call([request])[0].done(function(data) {
            var obj = data.split("|");
            var ids = JSON.parse(obj[0]);
            var clickedLink = $('#call_modal');
            ModalFactory.create({
                type: ModalFactory.types.SAVE_CANCEL,
                title: 'Choose team schedule',
                body: obj[1],
            })
            .then(function(modal) {
                modal.setSaveButtonText('Save');
                var root = modal.getRoot();
                root.on(ModalEvents.save, function() {
                    var selected_id = "";
                    ids.forEach(element => {
                        if( $("#choose"+element).is(":checked") ) {
                            selected_id = $("#choose"+element).val();
                        }
                    });
                    save_schedule(selected_id);
                });
                modal.show();
            })
        });
    });

    function save_schedule(id) {
        let request = {
            methodname: 'mod_schedule_save_schedule',
            args: {'id' : id},
        };
        Ajax.call([request])[0].done(function(data) {
            window.location.reload();
        });
    }

    var trigger = $('#check_in_button');
    ModalFactory.create({
       type: ModalFactory.types.SAVE_CANCEL,
       title: 'Check-in now',
       body: '<p>By clicking this button. You claim that you\'ve joined the online meeting</p>',
       preShowCallback: function(triggerElement, modal) {
          triggerElement = $(triggerElement);
 
          let id = triggerElement[0].value;
 
          modal.params = {'eventid': $("#check_in_button").val()};
          modal.setSaveButtonText('Sure!');
       },
       large: true
    }, trigger)
    .done(function(modal) {
       // Do what you want with your new modal.
       modal.getRoot().on(ModalEvents.save, function(e) {
          // Stop the default save button behaviour which is to close the modal.
          e.preventDefault();
 
          let footer = Y.one('.modal-footer');
          footer.setContent('Checking-in');
          let spinner = M.util.add_spinner(Y, footer);
          spinner.show();
          let request = {
                methodname: 'mod_schedule_checkin',
                args: modal.params,
          };
          Ajax.call([request])[0].done(function(data) {
            // Redirect to manage page.
            window.location.reload();
          });
       });
    });


    //at mentor view
    $(".mod_schedule_view_detail_button").on('click', function() {
        let request = {
            methodname: 'mod_schedule_view_detail',
            args: {'id' : this.value},
        };
        Ajax.call([request])[0].done(function(data) {
            var clickedLink = $('.mod_schedule_view_detail_button');
            ModalFactory.create({
                type: ModalFactory.types.SAVE_CANCEL,
                title: 'View Detail',
                body: data,
            })
            .then(function(modal) {
                modal.setSaveButtonText('Save');
                var root = modal.getRoot();
                root.on(ModalEvents.save, function() {
                    // var selected_id = "";
                    // ids.forEach(element => {
                    //     if( $("#choose"+element).is(":checked") ) {
                    //         selected_id = $("#choose"+element).val();
                    //     }
                    // });
                    // save_schedule(selected_id);
                });
                modal.show();
            })
        });
    });
});