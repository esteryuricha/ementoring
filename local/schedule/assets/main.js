require(['core/first', 'jquery', 'core/ajax'], function(core, $, Ajax) {
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

                $("#availabledates").empty();

                for(var d = new Date(1000*startint); d <= new Date(1000*endint); d.setDate(d.getDate() + 1 ) ) {
                    $("#availabledates").append("<option value='"+new Date(d)+"'>"+new Date(d).toLocaleDateString()+"</option>");
                }
            }).fail();
        });

        $("#availabledates").on('change', function() {
            $("#selecteddate").val(this.value);
        });
    });
});