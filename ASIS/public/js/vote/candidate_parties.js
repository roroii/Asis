
var  _token = $('meta[name="csrf-token"]').attr('content');
var parties_tbl;
var member_select;
$(document).ready(function() {
    bpath = __basepath + "/";
    loadData_table();

    load_candidate_partiesDatas();

    onSubmit();
    edit_click();
    on_click();
    onSelect();
    onchange_function();
    // addMember_to_meberTable();

});

function onSelect(){

    member_select = $('#member_select').select2({
        placeholder: "Select Member",
        closeOnSelect: true,
    });
}

function loadData_table() {
    parties_tbl = $('#parties_tbl').DataTable({
        dom:
        "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-6 text_left_1'l><'intro-y col-span-6 text_left_1'f>>"+
        "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'tr>>"+
        "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'<'datatable_paging_1'p>>>",
        renderer: 'bootstrap',
        "info": false,
        "bInfo":true,
        "bJQueryUI": true,
        "bProcessing": true,
        "bPaginate" : true,
        "aLengthMenu": [[5,10,25,50,100,150,200,250,300,-1], [5,10,25,50,100,150,200,250,300,"All"]],
        "iDisplayLength": 10,
        "aaSorting": [],

    });
}

$.fn.extend({
    load_candidate_partiesData: function(){
        $.ajax({
            type: "get",
            url: bpath + "vote/load-candidate-parties",
            data: _token,
            dataType: 'json',
            success: function (response) {
                parties_tbl.clear().draw();


                var data = response;


                if (data.length > 0) {
                    for(let i=0; i < data.length; i++){
                        var parties_id = data[i]['id'];
                        var parties_name = data[i]['parties'];
                        var parties_desc = data[i]['desc'];
                        var parties_memberCount = data[i]['parties_memberCount'];

                        var ii = i+1;
                        var member_icon = '';
                        if (parties_memberCount != 0) {
                            member_icon = parties_memberCount;
                        } else {
                            member_icon = '<i class="fa fa-plus items-center text-center text-primary"></i>';
                        }

                        var cd = '';
                                /***/

                                    cd = '' +
                                            '<tr class="whitespace-wrap">'+

                                                '<td>' +
                                                        ii+
                                                '</td>' +


                                                '<td>'+
                                                    '<a href="#" class="font-medium whitespace-nowrap text-right">'+parties_name+'</a>'+
                                                    '<div class="text-slate-500 text-xs text-justify mt-0.5">'+parties_desc+'</div>'+
                                                '</td>'+

                                                '<td>'+
                                                    '<div class="flex justify-center items-center">'+
                                                        '<a id="'+parties_id+'" data-paties-name="'+parties_name+'" class="flex justify-center items-center addMember" href="javascript:;">'+
                                                            '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="Add Member">'+
                                                            member_icon+
                                                            '</div>'+
                                                        '</a>'+
                                                    '</div>'+
                                                '</td>'+


                                                '<td>' +

                                                    '<div class="flex justify-center items-center">'+

                                                        '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">'+
                                                            '<a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>'+
                                                            '<div class="dropdown-menu w-40">'+
                                                                '<div class="dropdown-content">'+
                                                                    '<a id="'+parties_id+'" data-parties-name="'+parties_name+'" data-parties-desc="'+parties_desc+'"'+
                                                                        'class="dropdown-item editcandidateParty" href="javascript:;">'+
                                                                        '<i class="fa fa-edit text-success" aria-hidden="true"></i>'+
                                                                        '<span class="ml-2">Edit</span>'+
                                                                    '</a>'+
                                                                    '<a id="'+parties_id+'"'+
                                                                        'class="dropdown-item deletecandidateParty" href="javascript:;">'+
                                                                        '<i class="fa fa-trash text-danger"></i>'+
                                                                        '<span class="ml-2">Delete</span>'
                                                                    '</a>'+
                                                                '</div>'+
                                                            '</div>'+
                                                        '</div>'+


                                                    '</div>'+
                                                '</td>' +



                                            '</tr>' +
                                    '';

                                    parties_tbl.row.add($(cd)).draw();

                    }
                }

            }
        });
    }
});
window.load_candidate_partiesDatas = $.fn.load_candidate_partiesData;

function edit_click(){
    $("body").on('click', '.editcandidateParty', function () {
        let party_id = $(this).attr('id');
        let party_name = $(this).data('parties-name');
        let party_desc = $(this).data('parties-desc');

        // alert(party_id);

        $('#parties_id').val(party_id);
        $('#parties_name').val(party_name);
        $('#partiesDescription').val(party_desc);

        const addParties_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#parties_modal"));
        addParties_modal.show();
    });
}

function on_click(){

    $("body").on('click', '.addMember', function () {

        let party_id = $(this).attr('id');
        let party_name = $(this).data('paties-name');

        $('#member_Header').text(party_name);
        $('#partiesss_id').val(party_id);
        const parties_Memeber_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#addMember_modal"));
        parties_Memeber_modal.show();
        // alert(party_id+' Party Name -- '+party_name);
        loadMember(party_id);
    });

    $("body").on('click', '.remove-candidate-member', function () {
        // alert('123')
        $(this).closest('tr').remove();
    });

    

    $("body").on('click', '#addMember', function () {
        var selectedText = $('#member_select option:selected').text();
        var selectedVal = $('#member_select option:selected').val();

        // Check if an element with the same id already exists

        
        if (blockEmptyMembers()) {
            
            var row = $('<tr>')
                .append($('<td>').append(
                    $('<input>').attr({
                        'type': 'hidden',
                        'id': 'party_member_id',
                        'name': 'party_member_id[]',
                        'value': 0
                    }),
                    $('<input>').attr({
                        'type': 'hidden',
                        'id': 'candidate_member_id',
                        'name': 'candidate_member_id[]',
                        'value': selectedVal
                    }),
                    selectedText
                ))
                .append($('<td>').append(
                    $('<a>').attr({
                        'href': 'javascript:;',
                        'class': 'remove-candidate-member',
                    }).append(
                        $('<i>').addClass('fa fa-trash text-danger').attr('aria-hidden', 'true')
                    )
                ));

            $('#members_modal_tbl>tbody').append(row);

            $('#member_select').val('').trigger('change');
        }
    });



}

// function addMember_to_meberTable(){

//  // Capture Enter key press on the input field and prevent default behavior
// $('#member_select').on('keydown', function(event) {
//     if (event.keyCode === 13) { // 13 is the key code for Enter
//         event.preventDefault(); // Prevent the default Enter key behavior

//         // Prevent the Select2 dropdown from opening on Enter key press
// $('#member_select').on('select2:opening', function (event) {
//     var keyCode = event.originalEvent.keyCode;
//     if (keyCode === 13) { // Check if Enter key is pressed
//         event.preventDefault(); // Prevent the default Select2 behavior
//     }
// });

//       // Capture Enter key press within the Select2 dropdown
// $('#member_select').on('select2:selecting', function (event) {
//     var keyCode = event.originalEvent.keyCode;
//     if (keyCode === 13) { // Check if Enter key is pressed
//         event.preventDefault(); // Prevent the default Select2 behavior
//         var selectedText = $('#member_select option:selected').text();
//         var row = $('<tr>')
//             .append($('<td>').append(
//                 $('<input>').attr({
//                     'type': 'hidden',
//                     'id': 'party_member_id',
//                     'name': 'party_member_id',
//                     'value': 0
//                 }),
//                 $('<input>').attr({
//                     'type': 'hidden',
//                     'id': 'candidate_member_id',
//                     'name': 'candidate_member_id',
//                     'value': 0
//                 }),
//                 selectedText
//             ))
//             .append($('<td>').append(
//                 $('<a>').attr({
//                     'href': 'javascript:;',
//                     'class': 'remove-candidate-member',
//                 }).append(
//                     $('<i>').addClass('fa fa-trash text-danger').attr('aria-hidden', 'true')
//                 )
//             ));

//         $('#members_modal_tbl>tbody').append(row);
//     }
// });
//     }
// });

//     // // Event handler for Select2 opening and closing
//     // $('#member_select').on('select2:open', function () {
//     //     isSelect2Open = true;
//     // });

//     // $('#member_select').on('select2:close', function () {
//     //     isSelect2Open = false;
//     // });

//     // // Your existing click event handler
//     // $("body").on('click', '#addMember', function () {
//     //     var selectedText = $('#member_select option:selected').text();
//     //     var row = $('<tr>')
//     //         .append($('<td>').append(
//     //             $('<input>').attr({
//     //                 'type': 'hidden',
//     //                 'id': 'party_member_id',
//     //                 'name': 'party_member_id',
//     //                 'value': 0
//     //             }),
//     //             $('<input>').attr({
//     //                 'type': 'hidden',
//     //                 'id': 'candidate_member_id',
//     //                 'name': 'candidate_member_id',
//     //                 'value': 0
//     //             }),
//     //             selectedText
//     //         ))
//     //         .append($('<td>').append(
//     //             $('<a>').attr({
//     //                 'href': 'javascript:;',
//     //                 'class': 'remove-candidate-member',
//     //             }).append(
//     //                 $('<i>').addClass('fa fa-trash text-danger').attr('aria-hidden', 'true')
//     //             )
//     //         ));

//     //     $('#members_modal_tbl>tbody').append(row);
//     // });
// }

function onSubmit() {
    $("#parties_form").submit(function (e) {
        e.preventDefault();

        const fd = $(this);
        $.ajax({
            type: "post",
            url: bpath + "vote/add-candidate-parties",
            data: fd.serialize(),
            success: function (response) {

                if(response.status == "updated") {
                    __notif_show( 1, "Party Updated Successfully");
                    $('#parties_id').val('');
                    $('#parties_form')[0].reset();
                    const addParties_modal = tailwind.Modal.getOrCreateInstance(document.querySelector("#parties_modal"));
                    addParties_modal.hide();
                    load_candidate_partiesDatas();
                }else if(response.status == "error"){

                    __notif_show( 1, response.message);
                }else{

                    __notif_show( 1, "New Party Added Successfully");
                    $('#parties_form')[0].reset();
                    load_candidate_partiesDatas();
                }

            }
        });
    });


    $('#addMember_form').submit(function (e) {
        e.preventDefault();

        var exist_member = $('#members_modal_tbl').find('#candidate_member_id');

        // if (exist_member.length > 0) {
            const fd = $(this);
            $.ajax({
                type: "post",
                url: bpath + "vote/add-parties-member",
                data: fd.serialize(),
                dataType: "json",
                success: function (response) {
                    if (response.status === 200) {
                        __notif_show( 1, "New Member Successfully");
                        loadMember(response.parties_id)
                        load_candidate_partiesDatas();
                        // alert('good');
                    }else{
                        __notif_show( -1, response.error);
                    }
                }
            });
        // }else{
        //     __notif_show(-1, "No Member to Save");
        // }

    });


}

function blockEmptyMembers() {

    if($('#member_select').val() == '') {
        $('#member_select').select2({
            theme: "error",
            placeholder: "Member is required",
        });

        return false;
    }else{
        $('#member_select').select2({
            placeholder: "Select Member",
            closeOnSelect: true,
            allowClear:true,
        });
        return true;


    }
}

function loadMember(parties_id){
    $.ajax({
        type: "get",
        url: bpath + "vote/get-parties-member",
        data: {_token: _token, parties_id: parties_id},
        success: function (response) {

            // console.log(response);

            try {
                $('#members_modal_tbl>tbody').empty(); // Clear existing rows
                var data = JSON.parse(response);
                console.log(data);

                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        var party_member_id = data[i]['party_member_id'];
                        var candidate_member_id = data[i]['candidate_member_id'];
                        var members_name = data[i]['members_name'];

                        var row = $('<tr>')
                            .append($('<td>').append(
                                $('<input>').attr({
                                    'type': 'hidden',
                                    'id': 'party_member_id',
                                    'name': 'party_member_id[]',
                                    'value': party_member_id
                                }),
                                $('<input>').attr({
                                    'type': 'hidden',
                                    'id': 'candidate_member_id',
                                    'name': 'candidate_member_id[]',
                                    'value': candidate_member_id
                                }),
                                members_name
                            ))

                            .append($('<td>').append(
                                $('<a>').attr({
                                    'href': 'javascript:;',
                                    'class': 'remove-candidate-member',
                                    // 'id': party_member_id
                                }).append(
                                    $('<i>').addClass('fa fa-trash text-danger').attr('aria-hidden', 'true')
                                )
                            ));

                        $('#members_modal_tbl>tbody').append(row);
                    }
                }

            } catch (error) {
                console.log(error);
            }
        }
    });
}

function onchange_function(){
    $("#member_select").change(function (e) {
        e.preventDefault();

        var thisValue = $(this).val();

        var exist_member = $('#members_modal_tbl').find('#candidate_member_id[value="' + thisValue + '"]');
        var addMember_btn = $('#addMember');
        var iconElement = addMember_btn.find('.add_icon'); // Assuming this is where the icon is located

        if (exist_member.length > 0) {
            addMember_btn.prop('disabled', true);
            addMember_btn.css('border-color', 'red');
            iconElement.removeClass('fas fa-plus text-success').addClass('fas fa-times text-danger');
        } else {
            addMember_btn.prop('disabled', false);
            addMember_btn.css('border-color', 'rgb(33, 218, 33)');
            iconElement.removeClass('fas fa-times text-danger').addClass('fas fa-plus text-success');
        }
    });
}

