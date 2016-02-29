var Load = function () {

    // ------------------------------------------------------------------------

    this.__construct = function () {
        console.log('Load Created');
        Template = new Template();
        Event = new Event();
//        load_load();
//        load_note();
//        Result  = new Result();

//        console.log(Template.todo({todo_id: 1, content: "this is life"}));
    };

    // ------------------------------------------------------------------------

    var load_load = function () {
        
        $.get('load/get_load_view', function (o) {
            var num = 0;
            var output = '';
            for (var i = 0; i < o.length; i++) {
                output += '<tr>';
                num++;
                output += Template.load_table(num, o[i]);
                output += '</tr>';
            }

            $('#list_load tbody').append(output);
        }, 'json');

    };

    // ------------------------------------------------------------------------

    var load_note = function () {
        $.get('api/get_note', function (o) {
            var output = '';
            for (var i = 0; i < o.length; i++) {
                output += Template.note(o[i]);
            }

            $('#list_note').html(output);
        }, 'json');

    };

    // ------------------------------------------------------------------------

    this.__construct();

};