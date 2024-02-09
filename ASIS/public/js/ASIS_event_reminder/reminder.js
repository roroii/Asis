const reminder_modal = tailwind.Modal.getInstance(document.querySelector("#create_reminder"));
const delete_modal = tailwind.Modal.getInstance(document.querySelector("#btn_delete_event_modal"));
var dt_event = '';
var event_list_id = {GlobalDeleteEvent:''};
var get_title = {GlobalTitle:''};
var event_id = {GlobalEventId:''}, id_group ={GlobalGroupId:''};

$(document).ready(function () {

    bpath = __basepath + "/";

    initialize_event_datatable();
    eventList();
    editor();
    event_select2();
    getProgramList();
    checkLimitSelec2();
    addEvent();
    clickEvents();
    cancel_reminder_modal();
    deleteEventList();
    savedEventList();
    enableStatus();
    triggerDelete();

    //delete modal
    updateStatDel();

    //update the data
    displayDetails();
});


/*================================================================*/
                        //Begin of the initialization

/*Initialize the datatable*/
function initialize_event_datatable()
{
    try{
		/***/
		dt_event = $('#tb_event_list').DataTable({
			dom:
				"<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-6 text_left_1'l><'intro-y col-span-6 text_left_1'f>>" +
				"<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'tr>>" +
				"<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'<'datatable_paging_1'p>>>",
			renderer: 'bootstrap',
			"info": false,
		    "bInfo":true,
		    "bJQueryUI": true,
		    "bProcessing": true,
		    "bPaginate" : true,
		    "aLengthMenu": [[10,25,50,100,150,200,250,300,-1], [10,25,50,100,150,200,250,300,"All"]],
		    "iDisplayLength": 10,
		    "aaSorting": [],

            // columnDefs:
            //     [
            //         { className: "dt-head-center", targets: [8] },
            //     ],
		});
	}catch(err){
        console.log(err);
    }
}

/*Display the list of event*/
function eventList()
{
    $.ajax({
        type: "GET",
        url: bpath + "event/display/list",
        data:{_token},

        success:function(response)
        {
            dt_event.clear().draw();

            if(response !== null || response !== '')
            {
                let data = JSON.parse(response);

                if(data.length > 0)
                {
                    for(let x=0;x<data.length;x++)
                    {
                        let text_color = '',
                            stat = '',
                            check = '',
                            beat = ''

                        let id = data[x]['id'],
                            title = data[x]['title'],
                            desc = data[x]['desc'],
                            status = data[x]['status'];

                        if(status === '0')
                        {
                            stat = 'in-active';
                            text_color = 'text-danger';
                            check = '';
                            beat = '';
                        } else
                        {
                            stat = "active";
                            text_color = 'text-success';
                            check = "checked";
                            beat ="fa-beat-fade"
                        }

                        let cd = `
                            <tr>
                                <td class="font-semibold fs_c_4">${title}</td>
                                <td class="fs_c_4" style="text-align:justify; text-justify:auto; word-break: break-all">${desc}</td>
                                <td>
                                <div class="form-check form-switch">
                                    <input id="enable_stat" class="form-check-input enable_stat ${beat}" data-id="${id}" data-stat="${status}" type="checkbox" ${check}>
                                        <label class="form-check-label" for="product-status-active">
                                    </label>
                                </div>
                                </td>
                                <td class="${text_color} fs_c_4">${stat}</td>
                                <td>
                                <div class="flex justify-center items-center">
                                <div id="drop_down_close_event" class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                                <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>
                                <div class="dropdown-menu w-40 zoom-in tooltip">
                                    <div class="dropdown-content">
                                    <button id="btn_update_event_list" type="button" class="w-full dropdown-item" data-event_id="${id}"data-tw-toggle="modal" data-tw-target="#create_reminder"><i class="fa fa-circle-info text-success"></i><span class="ml-2">Details</span></button>
                                    <button id="btn_delete_event_list" type="button" class="w-full dropdown-item" data-event_id="${id}" data-tw-toggle="modal" data-tw-target="#btn_delete_event_modal"><i class="fa fa-trash text-danger"></i><span class="ml-2">Delete</span></button>
                                </div>
                                </td>
                            </tr>
                            `;

                            // Assuming "desc" contains HTML content, you can set it as innerHTML of the corresponding element.
                            const container = document.createElement("div");
                            container.innerHTML = desc;
                            const descHTML = container.innerHTML;

                            // Now, insert the formatted HTML content into the table row.
                            cd = cd.replace('${desc}', descHTML);

                        dt_event.row.add($(cd)).draw();
                    }
                }
            }
        }
    });
}

/*Initialize the check editor*/
function editor()
{
    ClassicEditor
        .create(document.querySelector('#desc'), {
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'undo',
                    'redo'
                ]
            },
            language: 'en'
        })
        .then(editor => {
            event_desc = editor
        })
        .catch(error => {
            console.error('Error initializing editor:', error);
        });
}

/*Initialize the select2*/
function event_select2()
{
    $('#title_emoji').select2({
        placeholder: "Select icon to display",
        closeOnSelect: true,
        allowClear:true,
    });

    $('#message_emoji').select2({
        placeholder: "Select icon to display",
        closeOnSelect: true,
        allowClear:true,
    });

    $('#event_department').select2({
        placeholder: "Select program",
        closeOnSelect: true,
        allowClear:true,
    });

}

                //End of the initialization
/*================================================================*/

/*Extract the data in the table*/
function getEventListData()
{
    let temp_data = [];


    $("#tb_list_events tr").each(function(i){

        let event_title = $(this).find("td #lbl_event_title").text();
        let id =$(this).find("td #event_id").text();
            desc = $(this).find("td #event_desc").val(),
            title_emoji = $(this).find("td #title_icon").text(),
            message_emoji = $(this).find("td #message_icon").text(),
            group = $(this).find("td #event_group").text(),
            group_id = $(this).find("td #id_group").text();
            console.log(group_id);
        if(((event_title !== null && event_title !== '') && (desc !== null && desc !== '') &&(id!==null && id!=='')))
        {
                let data = {
                    id:id,
                    title:event_title,
                    desc:desc,
                    title_icon:title_emoji,
                    message:message_emoji,
                    group:group.split(','),
                    group_id:group_id.split(','),
                }

                temp_data.push(data);
        }

    });
    return temp_data;
}

/*Check for an empty value in the title*/
function checkEmpty(id_name)
{
    let id = '#'+id_name;
    let val = $(id).val();

    if(val.trim() === '' || val.trim() === null)
    {
        $(id).addClass('border border-danger');

        return false;
    } else
    {
        $(id).removeClass('border border-danger');
        return true;
    }
}

/*Check for an empty value in the check editor description*/
function checkEventDesc()
{
    if(event_desc.getData() === '' || event_desc.getData() === null)
    {
        $("#chk_editor").addClass('border border-danger');
        return false;

    }else
    {
        $("#chk_editor").removeClass('border border-danger');
        return true;

    }
}

/*Count the row of the table if empty or not*/
function checkTable()
{
    let row = $("#tb_list_events tr").length;

    if(row !== 0)
    {
        return true;

    } else
    {
        __notif_show(-1,'',"Please fill the information above");
        return false;
    }
}

/*Clear the input fields*/
function clearFields()
{
    $("#reminder_form")[0].reset();
    event_desc.setData("");
    $("#title_emoji").val('').trigger('change');
    $("#message_emoji").val('').trigger('change');
    $("#event_department").val('').trigger('change');
    $("#tb_list_events").find('tr#tr_events').empty();
    $("#desc").val('');
}

/*Clear the input excepts the table*/
function clear()
{
    $("#reminder_form")[0].reset();
    $("#title_emoji").val('').trigger('change');
    $("#message_emoji").val('').trigger('change');
    $("#event_department").val('').trigger('change');
    event_desc.setData("");
}

/*Cancel the modal*/
function  cancel_reminder_modal()
{
    $("#cancel_reminder_modal").on("click",function(){

        //clear the data in the modal
        clearFields();
    });
}

/*Click the tr in the table and display its information on their respective fields*/
function clickEvents()
{
    $("body").on("click","#tr_events",function()
    {
         let id = $(this).find("td #event_id").text();
             title = $(this).find("td #lbl_event_title").text(),
             desc = $(this).find("td #event_desc").text(),
             title_icon = $(this).find("td #title_icon").text(),
             message_icon = $(this).find("td #message_icon").text(),
             group = $(this).find("td #event_group").text();
             group_id = $(this).find("td #id_group").text();
             dept = group.split(',');

             //append the data in the table
             event_id.GlobalEventId = id;
             id_group.GlobalGroupId = group_id;
             get_title.GlobalTitle = title;
             $("#event_title").val(title);
             $("#title_emoji").val(title_icon).trigger('change');
             $("#message_emoji").val(message_icon).trigger('change');
             $("#event_department").val(dept).trigger('change');
             event_desc.setData(desc);

             //remove the event in the list
             $(this).remove();
    });
}

/*Delete the selected data in the table*/
function deleteEventList()
{
    $("body").on("click","#btn_delete_list_event",function(e)
    {
        e.preventDefault();

        let id = $(this).data("id");

        if(id === 0)
        {
            $(this).closest('tr').remove();
        } else
        {
            deleteEvent(id);
            $(this).closest('tr').remove();
            eventList();
        }

    });
}

/*Saved the data*/
function savedEventList()
{
    $("#btn_saved_event").on("click",function(){

       let datas =  getEventListData();
           check_id = '';

       if(checkTable())
        {
            getEventList(datas);
            eventList();
        }
    });
}

/*Add the newly input data in the datatable*/
function addEvent()
{
    $("#btn_add_event").on("click",function(){
        // appendData(event_title,desc);

        let title = $("#event_title").val(),
            desc = event_desc.getData(),
            title_icon = $("#title_emoji").val(),
            message_icon = $("#message_emoji").val(),
            group = $("#event_department").val();

            if(checkEmpty("event_title"))
            {
                if(checkEventDesc())
                {
                    if(title === get_title.GlobalTitle)
                    {
                        //remove the event
                        appendData(title,desc,title_icon,message_icon,group);
                        clear();
                    } else
                    {
                        //else append the tr
                        appendData(title,desc,title_icon,message_icon,group);
                        clear();
                    }

                }
            }
    });
}

/*Append the data*/
function appendData(event_title,desc,title,message,group)
{
    let cd = '';

        if(event_id.GlobalEventId === '' || event_id.GlobalEventId === null)
        {
            event_id.GlobalEventId = 0;
        }

        if(id_group.GlobalGroupId === '' || id_group.GlobalGroupId === null)
        {
            id_group.GlobalGroupId = 0;
        }

        cd = `<tr id="tr_events" class="text-center tr_events">
                <td class="hidden"><label id="event_id">${event_id.GlobalEventId}</label></td>
                <td class="hidden"><label id="id_group">${id_group.GlobalGroupId}</label></td>
                <td><label id="lbl_event_title" class="lbl_event_title">${event_title}</label></td>
                <td style="text-align:justify; text-justify:auto; word-break: break-all">${desc}</td>
                <td class="hidden"><label id="title_icon">${title}</label></td>
                <td class="hidden"><label id="message_icon">${message}</label></td>
                <td class="hidden"><label id="event_group">${group}</label></td>
                <td class="hidden"><textarea id="event_desc" class="event_desc">${desc}</textarea></td>
                <td id="btn_delete_list_event" class="text-danger" data-id="${event_id.GlobalEventId}" data-title="${title}"><button><i class="fa-solid fa-trash"></i></button></td>
            </tr>`;

        $("#tb_list_events").append(cd);
        event_id.GlobalEventId = '';
        id_group.GlobalGroupId = '';
}

/*Change the status of the event*/
function enableStatus()
{
    $("body").on("click",".enable_stat",function(){

        let id = $(this).data("id"),
            status =$(this).data("stat");


            updateStat(id,status);
            eventList();
    });
}

/*Trigger to open the delete modal*/
function triggerDelete()
{
    $("body").on("click","#btn_delete_event_list",function(){

        let id = $(this).data("event_id");
        event_list_id.GlobalDeleteEvent = id;
        __dropdown_close("#drop_down_close_event");

    });
}

/*Delete the data in the database*/
function updateStatDel()
{
    $("#btn_delete_list").on("click",function(){
        delete_modal.hide();
        deleteEvent(event_list_id.GlobalDeleteEvent);
        eventList();
    });
}

/*trigger update details*/
function displayDetails()
{
    $("body").on("click","#btn_update_event_list",function(){

        let id = $(this).data("event_id");
            retrievedEvent(id);
            __dropdown_close("#drop_down_close_event");

    });
}

/*==========================================================================*/
                                /*Disabling the select 2 */

/*Trigger the select 2 to limit the drop down list when selected*/
function checkLimitSelec2()
{
    let all = $("#event_department option[value='all']");

        $("#event_department").on('select2:select',function(){

            let data = $(this).val();

                $.each(data,function(index,value){

                    if(value === 'all')
                    {
                        $("#event_department").select2({
                            maximumSelectionLength: 1
                        });
                    }
                    else
                    {
                        $("#event_department").select2({
                            maximumSelectionLength: null
                        });

                        all.prop('disabled', true);
                    }

                });

        });
}

/*================================================================*/
            /*Begin: Pass data into the server side*/

/*get the list of the program*/
function getProgramList()
{
    $.ajax({
        type: "POST",
        url: bpath + "event/list/program",
        data:{_token},

        success: function(response)
        {
            $("#event_department").val(null).trigger('change');

            if(response !== null || response !== '')
            {
                let data = JSON.parse(response);

                if(data.length > 0)
                {
                    for(let i=0;i<data.length;i++)
                    {
                        let program = data[i]['program'],
                            desc = data[i]['desc'];
                        let prog = program +'-'+ desc;

                        let option = new Option(prog,program,false,false);

                        $("#event_department").append(option).trigger('change');
                    }
                }
            }
        }
    });
}

/*Pass the data form the client side into the server side*/
function getEventList(data)
{
    $.ajax({
        type:"POST",
        url: bpath + "event/saved/event/list",
        data:{_token,data},
        dataType:"json",

        success:function(response){

            if(response.status === true)
            {
                __notif_show(1,'',response.message);
                clearFields();
                reminder_modal.hide();
            } else
            {
                __notif_show(-1,'',response.message);
            }
        }
    });
}

/*Update the status*/
function updateStat(id,stat)
{
    $.ajax({
        type:"POST",
        url: bpath + "event/update/status",
        data:{_token,id,stat},
        dataType: 'json',

        success:function(response){

            if(response.status === true)
            {
                __notif_show(1,'',"Successfully activate");
            }
            else
            {
                __notif_show(-1,'',"Unable to activate");
            }
        }
    })
}

/*Delete the event in the list*/
function deleteEvent(id)
{
    $.ajax({
        type: "POST",
        url: bpath + "event/delete/event/list",
        data:{_token,id},

        success:function(response)
        {
            if(response.status === true)
            {
                __notif_show(1,'',response.message);
            }else
            {
                __notif_show(-1,'',response.message);
            }
        }
    });
}

/*Get the data of the event list*/
function retrievedEvent(id)
{
    $.ajax({
        type: "GET",
        url: bpath + "event/retrieved/event",
        data:{_token,id},

        success:function(response)
        {
            if(response)
            {
                let data = JSON.parse(response);

                $.each(data,function(index,event){

                    const cd =`<tr id="tr_events" class="text-center tr_events">
                                <td class="hidden"><label id="event_id">${event.id}</label></td>
                                <td class="hidden"><label id="id_group">${event.groupid}</label></td>
                                <td><label id="lbl_event_title" class="lbl_event_title">${event.title}</label></td>
                                <td style="text-align:justify; text-justify:auto; word-break: break-all">${event.event_desc}</td>
                                <td class="hidden"><label id="title_icon">${event.title_icon}</label></td>
                                <td class="hidden"><label id="message_icon">${event.message_icon}</label></td>
                                <td class="hidden"><label id="event_group" data-group="${event.group}">${event.group}</label></td>
                                <td class="hidden"><textarea id="event_desc" class="event_desc">${event.event_desc}</textarea></td>
                                <td id="btn_delete_list_event" class="text-danger" data-id="${event.id}"><button><i class="fa-solid fa-trash"></i></button></td>
                            </tr>`;

                    $("#tb_list_events").append(cd);
                })
            }
        }
    });
}
