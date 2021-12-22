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

});