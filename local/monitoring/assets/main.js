require(['core/first', 'jquery', 'core/ajax', 'core/modal_factory', 'core/modal_events', 'core/notification'], function(core, $, Ajax, ModalFactory, ModalEvents, Notification) {
    $(document).ready(function() {
        $('.local_monitoring_group_button').on('click', function() {
            var courseid = this.value;
            let request = {
                methodname: 'local_monitoring_getgroups',
                args: {id: courseid},
            };
            Ajax.call([request])[0].done(function(data) {
                $("#data").html(data);
            }).fail();
        });
        $('.local_monitoring_schedule_button').on('click', function() {
            var courseid = this.value;
            let request = {
                methodname: 'local_monitoring_getschedules',
                args: {id: courseid},
            };
            Ajax.call([request])[0].done(function(data) {
                $("#data").html(data);
            }).fail();
        });        
    });
});