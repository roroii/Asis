var base_url = window.location.origin;
var doc_file_id;
var conversation_id = '';
var current_user_id = $('meta[name="current-user-id"]').attr('content');
var _token = $('meta[name="csrf-token"]').attr('content');

$(document).ready(function () {

    bpath = __basepath + "/";
    // load_document_count();
    getNotification();
});

function load_document_count() {

    $.ajax({
        url: bpath + 'admin/load/document/count',
        type: "POST",
        data: {
            _token: _token,
        },
        success: function (re) {

            var data = JSON.parse(re);
            $('#my_documents_count_div').empty();
            $('#my_documents_count_div').append(data.my_documents_count_div);

            $('#my_incoming_count_div').empty();
            $('#my_incoming_count_div').append(data.my_incoming_count_div);

            $('#my_received_count_div').empty();
            $('#my_received_count_div').append(data.my_received_count_div);


            $('#my_outgoing_count_div').empty();
            $('#my_outgoing_count_div').append(data.my_outgoing_count_div);

            $('#my_hold_count_div').empty();
            $('#my_hold_count_div').append(data.my_hold_count_div);


            $('#my_returned_count_div').empty();
            $('#my_returned_count_div').append(data.my_returned_count_div);

            $('#my_trash_count_div').empty();
            $('#my_trash_count_div').append(data.my_trash_count_div);

            $('#load_unread_messages').empty();
            $('#load_unread_messages').append(data.messages_count_div);

            $('#load_clearance_requests').empty();
            $('#load_clearance_requests').append(data.clearance_count_div);

            // console.log(data.current_user_id);
        }
    });

}


Echo.channel('channel-have-message')
    .listen('load_have_message', (e) => {

        // console.log(current_user_id);

        if (e.message_sent_to == 'msg-sent-' + current_user_id) {
            // if(e.conversation_id == conversation_id){
            //     // console.log(data.conversation_id);
            //     load_conversation_content(e.conversation_id)
            // }else{
            //     load_my_conversations();
            // }
            load_notification(e.message_id);
        }

    });

function load_notification(message_id) {

    $.ajax({
        url: base_url + '/chat/load/message/id',
        type: "POST",
        data: {
            _token: _token,
            message_id: message_id,
        },
        success: function (data) {
            var data = JSON.parse(data);

            // $('#adminNotification-with-avatar-content').empty();
            // $('#adminNotification-with-avatar-content').append(data.load_message);
            $('#append_global_notification').empty();
            $('#append_global_notification').append(data.load_message);

            let avatarNotification = Toastify({ node: $("#adminNotification-with-avatar-content-" + data.message_id).clone().removeClass("hidden")[0], duration: -1, newWindow: true, close: true, gravity: "top", position: "right", stopOnFocus: true, }).showToast();
            $(avatarNotification.toastElement).find('[data-dismiss="adminNotification"]').on("click", function () { avatarNotification.hideToast(); });
        }
    });

}

/*Load the notification*/
function getNotification()
{
    $.ajax({
        type: "GET",
        url: bpath + "event/notif/load",
        data:{_token},

        success:function(response)
        {
            $("#append_notif").empty();

            if(response !== null && response !== '')
            {
                let data = JSON.parse(response);

                if(data !== null && data !== '')
                {
                    if(data.length > 0)
                    {
                        for(let x=0;x<data.length;x++)
                        {
                            if(data[x]!==null)
                            {
                                const id = data[x]['id'],
                                title = data[x]['title'],
                                desc = data[x]['desc'],
                                title_icon = data[x]['title_icon'],
                                message_icon = data[x]['message_icon'],
                                status = data[x]['status'],
                                check_dismiss = data[x]['check_dismiss'];

                            if(check_dismiss !== true)
                            {
                                const cd = `<div class="toastify-content flex">
                                            <div class="ml-4">
                                                <div class="font-medium ">${title} <span class="ml-2">${title_icon}</span></div>
                                                <div class="text-slate-500 mt-1 text-clip overflow-hidden fs_c_4 w-60"  style="text-align:justify; text-justify:auto; word-break: break-all">${message_icon} ${desc}</div>
                                                <div class="mt-3 font-medium text-right">
                                                    <a id="btn_cancel_event_notif"  data-dismiss="notification" data-id="${id}" data-stats="${status}" class="text-primary dark:text-slate-400 cursor-pointer hover:underline">Dismiss</a>
                                                </div>
                                            </div>
                                        </div>`;

                            let notif = Toastify({
                                                    node: $(cd).clone().removeClass("hidden")[0],
                                                    duration: -1,
                                                    newWindow: true,
                                                    close: false,
                                                    gravity: "top",
                                                    position: "right",
                                                    stopOnFocus: true,
                                                    positionLeft: false, // Add this line to display on the right side of the screen
                                                    positionTop: false, // Add this line to display at the top of the screen
                                                }).showToast();

                                $(notif.toastElement) .find('[data-dismiss="notification"]') .on("click", function () {

                                            let id = $(this).data("id"),
                                                stat = $(this).data("stats");

                                                notif.hideToast();
                                                savedViewNotif(id,stat);
                                });
                                }
                            }
                        }
                    }
                }
            }
        }

    });
}

/*Saved the user who view the notification*/
function savedViewNotif(id,stat)
{
    $.ajax({
        type: "POST",
        url: bpath + "event/saved/notif/view",
        data:{_token,id,stat},

        success:function(reponse){
            if(response.status === true)
            {
                getNotification();
            }
        }
    });
}




/*  FOR MODALS HERE */
function __modal_toggle(modal_id){

    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#'+modal_id));
    mdl.toggle();

}

function __modal_hide(modal_id){

    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#'+modal_id));
    mdl.hide();

}

