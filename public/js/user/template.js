var Template = function () {

    // ------------------------------------------------------------------------

    this.__construct = function () {
        console.log('Template Created');
    };

    // ------------------------------------------------------------------------

    this.user = function (obj) {
        var output = '';
        if (obj.completed == 1) {
            output += '<div id="user_' + obj.iduser + '" class="user_complete">';
        } else {
            output += '<div id="user_' + obj.iduser + '">';
        }
//        output += '<span>' + obj.content + '</span>';

        var data_completed = (obj.completed == 1) ? 0 : 1;
        var data_completed_text = (obj.completed == 1) ? '<i class="icon-share-alt"></i>' : '<i class="icon-ok"></i>';

        output += '<span class="options">';
        output += '<a data-id="' + obj.iduser + '" class="user_update" data-completed ="' + data_completed + '" href= "api/update_user">' + obj.name + '</a>';
        output += '<a data-id="' + obj.iduser + '" class="user_delete" href= "api/delete_user/"><i class="icon-remove"></i></a>';
        output += '</span>';
        output += '</div>';
        return output;
    };

    // ------------------------------------------------------------------------

    this.user_table = function (num, obj) {
        var output = '';
//        if (obj.completed == 1) {
//            output += '<div id="user_' + obj.iduser + '" class="user_complete">';
//        } else {
//            output += '<div id="user_' + obj.iduser + '">';
//        }
//        output += '<span>' + obj.content + '</span>';

//        var data_completed = (obj.completed == 1) ? 0 : 1;
//        var data_completed_text = (obj.completed == 1) ? '<i class="icon-share-alt"></i>' : '<i class="icon-ok"></i>';

//        output += '<span class="options">';
//        output += '<a data-id="' + obj.iduser + '" class="user_update" data-completed ="' + data_completed + '" href= "api/update_user">' + obj.name + '</a>';
//        output += '<a data-id="' + obj.iduser + '" class="user_delete" href= "api/delete_user/"><i class="icon-remove"></i></a>';

        output += '<th scope="row">' + num + '</th>';
        output += '<td>' + obj.name + '</td>';
        output += '<td>' + obj.login + '</td>';
        output += '<td>' + obj.email + '</td>';


//        output += '</span>';
//        output += '</div>';
        return output;
    };

    // ------------------------------------------------------------------------

    this.note = function (obj) {
        var output = '';
        output += '<div id="note_' + obj.note_id + '">';
        output += '<span><a class="note_toggle" data-id="' + obj.note_id + '" id="note_title_' + obj.note_id + '" hfre="#">' + obj.title + '</a></span> ';
        output += '<span class="options">';
        output += '<a data-id="' + obj.note_id + '" class="note_update_display" href= "#"><i class="icon-pencil"></i></a>';
        output += '<a data-id="' + obj.note_id + '" class="note_delete" href= "api/delete_note/"><i class="icon-remove"></i></a>';
        output += '</span>';
        output += '<div id ="note_edit_container_' + obj.note_id + '" class="note_edit_container"></div>';
        output += '<div class="hide" id="note_content_' + obj.note_id + '">' + obj.content + '</div>';
        output += '</div>';
        return output;
    };

    this.note_edit = function (note_id) {
        var output = '';
        output += '<form method="post" class="note_edit_form form-horizontal" action="api/update_note">';
        output += '<input class="note_id" type="hidden" name="note_id" value = "' + note_id + '"/>';
        output += '<div class="input-append">';
        output += '<input tabindex="1" type="text" name="title" class="title" placeholder="Note Title" />';
        output += '<input tabindex="3" type="submit" class="btn btn-success" value="Update" />';
        output += '<input type="submit" class="note_edit_cancel btn" value="Cancel" />';
        output += '</div>';
        output += '<div class="clearfix"></div>';
        output += '<textarea tabindex="2" class="content" name="content"></textarea>';
        output += '</form>';
        return output;
    }

    // ------------------------------------------------------------------------

    this.__construct();

};
