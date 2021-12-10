require(['core/first', 'jquery', 'core/ajax'], function(core, $, Ajax) {
    $(document).ready(function() {
        $("#eventid").on('change', function() {
            // $.ajax({
            //     type: "POST",
            //     url: "/lms/local/schedule/classes/manager.php",
            //     data: {
            //         id: this.value,
            //         wsfunction: 'getdates'
            //     },
            //     success: function(data) {
            //         alert("hello");
            //     }
            // });

            var eventid = this.value;
            let request = {
                methodname: 'local_schedule_getdates',
                args: {id: eventid},
            };
            Ajax.call([request])[0].done(function(data) {
                $("#selecteddate").val(data);
            }).fail();


        });
    });
});