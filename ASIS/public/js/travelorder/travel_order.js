var  _token = $('meta[name="csrf-token"]').attr('content');

$(document).ready(function (){

    bpath = __basepath + "/";
    load_travel_order();

    load_travel_order_data();
    load_travel_order_data_list();
    load_travel_order_data_rated();
});
$(document).on('select2:open', function(e) {
    document.querySelector(`[aria-controls="select2-${e.target.id}-results"]`).focus();
  });
//Initialize all My Documents DataTables
function load_travel_order(){
    try{
        /***/
        dt__created_travel_order = $('#dt__created_travel_order').DataTable({
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

            columnDefs:
                [
                    {
                        className: "dt-head-center",
                        targets: [  8, ],
                        "orderable": false,
                    },
                ],
        });

        dt__created_travel_order_list = $('#dt__created_travel_order_list').DataTable({
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

            columnDefs:
                [
                    { className: "dt-head-center", targets: [  8,1 ] },
                ],
        });

        dt__created_travel_order_rated = $('#dt__created_travel_order_rated').DataTable({
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

            columnDefs:
                [
                    { className: "dt-head-center", targets: [  8,1 ] },
                ],
        });


        pos_des = $('#pos_des').select2({
            placeholder: "",
            allowClear: true,
            closeOnSelect: false,
            width: "100%",
        });

        trav_emp_list = $('#trav_emp_list').select2({
            placeholder: "Select Employee",
            allowClear: true,
            closeOnSelect: false,
            width: "100%",
        });

        name_modal = $('#name_modal').select2({
            placeholder: "Select Employee",
            allowClear: true,
            closeOnSelect: false,
            width: "100%",
        });


        /***/
    }catch(err){  }
}


function load_travel_order_data_list() {
    showLoading();
    $.ajax({
        url: bpath + 'travel/order/load/travel/order/list',
        type: "POST",
        data: {
            _token: _token,
        },
        success: function(data) {

            dt__created_travel_order_list.clear().draw();
            /***/
            var data = JSON.parse(data);
            if(data.length > 0) {
                for(var i=0;i<data.length;i++) {

                    /***/

                    var id = data[i]['id'];
                    var name_id = data[i]['name_id'];
                    var name = data[i]['name'];
                    var date = data[i]['date'];
                    var departure_date = data[i]['departure_date'];
                    var return_date = data[i]['return_date'];
                    var pos_des_id = data[i]['pos_des_id'];
                    var pos_des_type = data[i]['pos_des_type'];
                    var station = data[i]['station'];
                    var station_id = data[i]['station_id'];
                    var destination = data[i]['destination'];
                    var purpose = data[i]['purpose'];
                    var created_at = data[i]['created_at'];
                    var interval = data[i]['interval'];
                    var days = data[i]['days'];

                    var can_view = data[i]['can_view'];
                    var can_update = data[i]['can_update'];
                    var can_release = data[i]['can_release'];
                    var status = data[i]['status'];
                    var class_sss = data[i]['class'];
                    var to_status = data[i]['to_status'];
                    var doc_type = data[i]['doc_type'];
                    var doc_type_id = data[i]['doc_type_id'];

                    var limit_update ='';

                    if(to_status == '1'){
                        var can_delete = data[i]['can_delete'];
                    }else{
                        var can_delete = '';
                    }

                    if(to_status == '11'){
                        limit_update = '';
                    }else{
                        limit_update = can_update;
                    }

                    /***/

                    cd = '' +
                        '<tr >' +

                    //to_id
                        '<td style="display: none" class="to_id">' +
                        id+
                        '</td>' +

                    //user_id
                        '<td style="display: none" class="name_id">' +
                        name_id+
                        '</td>' +

                    //name_created_by
                        '<td  class="text-'+class_sss+'">'+
                        '<div class="flex justify-center items-center" >'+
                                '<a id="for_action_button" data-doc-typ="'+doc_type+'" data-doc-tid="'+doc_type_id+'" href="javascript:;" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium" data-tw-toggle="modal" data-tw-target="#view_signatories_modal"> <div class="w-2 h-2 bg-'+class_sss+' rounded-full mr-3"></div> '+ status+' </a>'+
                            '</div>'+

                        '</td>' +

                    //purpose
                        '<td class="name text-justify">' +

                            '<div data-to-prps="'+purpose+'">'+

                            '<span class="text">'+purpose+'</span>'+

                            '</div>'+

                            '<div class="text-slate-500 text-xs whitespace-nowrap text-secondary mt-0.5 level">'+created_at+'</div>'+

                        '</td>' +

                    //number of days
                        '<td ' +

                        '<div class="whitespace-nowrap type">'+

                        '<span class="text">'+days+'</span>'+

                        '</div>'+

                            '<span class="hidden">'+days+'</span>'+

                        '</td>' +

                    //departure
                        '<td ' +

                        '<div class="whitespace-nowrap type">'+

                        '<span class="text">'+departure_date+'</span>'+

                        '</div>'+

                            '<span class="hidden">'+departure_date+'</span>'+

                        '</td>' +

                    //return
                        '<td >'+
                                '<div class="whitespace-nowrap type">'+
                                '<span class="text">'+return_date+'</span>'+
                                '</div>'+

                                '<span class="hidden">'+return_date+'</span>'+

                        '</td>' +

                    //station
                        '<td class="station">'+

                            '<div class="flex items-center whitespace-nowrap text-'+station+'"><div class="w-2 h-2 bg-'+station+' rounded-full mr-3"></div>'+station+'</div>' +
                            '<span class="hidden">'+station+'</span>'+

                        '</td>' +

                    //destination
                        '<td class="destination">' +

                        '<div class="flex items-center whitespace-nowrap text-'+destination+'"><div class="w-2 h-2 bg-'+destination+' rounded-full mr-3"></div>'+destination+'</div>' +
                        '<span class="hidden">'+destination+'</span>'+

                        '</td>' +
                    //actions
                        '<td>' +
                            '<div class="flex justify-center items-center">'+
                                can_view+
                            '</div>'+
                        '</td>' +

                        '</tr>' +
                        '';

                        dt__created_travel_order_list.row.add($(cd)).draw();
                    /***/
                }
            }
            hideLoading();
        }
    });
}


function load_travel_order_data_rated() {
    showLoading();
    $.ajax({
        url: bpath + 'travel/order/load/travel/order/rated',
        type: "POST",
        data: {
            _token: _token,
        },
        success: function(data) {

            dt__created_travel_order_rated.clear().draw();
            /***/
            var data = JSON.parse(data);
            if(data.length > 0) {
                for(var i=0;i<data.length;i++) {

                    /***/

                    var id = data[i]['id'];
                    var name_id = data[i]['name_id'];
                    var name = data[i]['name'];
                    var date = data[i]['date'];
                    var departure_date = data[i]['departure_date'];
                    var return_date = data[i]['return_date'];
                    var pos_des_id = data[i]['pos_des_id'];
                    var pos_des_type = data[i]['pos_des_type'];
                    var station = data[i]['station'];
                    var station_id = data[i]['station_id'];
                    var destination = data[i]['destination'];
                    var purpose = data[i]['purpose'];
                    var created_at = data[i]['created_at'];
                    var interval = data[i]['interval'];
                    var days = data[i]['days'];

                    var can_view = data[i]['can_view'];
                    var can_update = data[i]['can_update'];
                    var can_release = data[i]['can_release'];
                    var status = data[i]['status'];
                    var class_sss = data[i]['class'];
                    var to_status = data[i]['to_status'];
                    var doc_type = data[i]['doc_type'];
                    var doc_type_id = data[i]['doc_type_id'];

                    var limit_update ='';

                    if(to_status == '1'){
                        var can_delete = data[i]['can_delete'];
                    }else{
                        var can_delete = '';
                    }

                    if(to_status == '11'){
                        limit_update = '';
                    }else{
                        limit_update = can_update;
                    }

                    /***/

                    cd = '' +
                        '<tr >' +

                    //to_id
                        '<td style="display: none" class="to_id">' +
                        id+
                        '</td>' +

                    //user_id
                        '<td style="display: none" class="name_id">' +
                        name_id+
                        '</td>' +

                    //name_created_by
                        '<td  class="text-'+class_sss+'">'+
                        '<div class="flex justify-center items-center" >'+
                                '<a id="for_action_button" data-doc-typ="'+doc_type+'" data-doc-tid="'+doc_type_id+'" href="javascript:;" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium" data-tw-toggle="modal" data-tw-target="#view_signatories_modal"> <div class="w-2 h-2 bg-'+class_sss+' rounded-full mr-3"></div> '+ status+' </a>'+
                            '</div>'+

                        '</td>' +

                    //purpose
                        '<td class="name text-justify">' +

                            '<div data-to-prps="'+purpose+'">'+

                            '<span class="text">'+purpose+'</span>'+

                            '</div>'+

                            '<div class="text-slate-500 text-xs whitespace-nowrap text-secondary mt-0.5 level">'+created_at+'</div>'+

                        '</td>' +

                    //number of days
                        '<td ' +

                        '<div class="whitespace-nowrap type">'+

                        '<span class="text">'+days+'</span>'+

                        '</div>'+

                            '<span class="hidden">'+days+'</span>'+

                        '</td>' +

                    //departure
                        '<td ' +

                        '<div class="whitespace-nowrap type">'+

                        '<span class="text">'+departure_date+'</span>'+

                        '</div>'+

                            '<span class="hidden">'+departure_date+'</span>'+

                        '</td>' +

                    //return
                        '<td >'+
                                '<div class="whitespace-nowrap type">'+
                                '<span class="text">'+return_date+'</span>'+
                                '</div>'+

                                '<span class="hidden">'+return_date+'</span>'+

                        '</td>' +

                    //station
                        '<td class="station">'+

                            '<div class="flex items-center whitespace-nowrap text-'+station+'"><div class="w-2 h-2 bg-'+station+' rounded-full mr-3"></div>'+station+'</div>' +
                            '<span class="hidden">'+station+'</span>'+

                        '</td>' +

                    //destination
                        '<td class="destination">' +

                        '<div class="flex items-center whitespace-nowrap text-'+destination+'"><div class="w-2 h-2 bg-'+destination+' rounded-full mr-3"></div>'+destination+'</div>' +
                        '<span class="hidden">'+destination+'</span>'+

                        '</td>' +
                    //actions
                        '<td>' +
                            '<div class="flex justify-center items-center">'+
                                can_view+
                            '</div>'+
                        '</td>' +

                        '</tr>' +
                        '';

                        dt__created_travel_order_rated.row.add($(cd)).draw();
                    /***/
                }
            }
            hideLoading();
        }
    });
}



function load_travel_order_data() {
    showLoading();
    $.ajax({
        url: bpath + 'travel/order/load/travel/order',
        type: "POST",
        data: {
            _token: _token,
        },
        success: function(data) {

            dt__created_travel_order.clear().draw();
            /***/
            var data = JSON.parse(data);
            if(data.length > 0) {
                for(var i=0;i<data.length;i++) {

                    /***/

                    var id = data[i]['id'];
                    var name_id = data[i]['name_id'];
                    var name = data[i]['name'];
                    var date = data[i]['date'];
                    var departure_date = data[i]['departure_date'];
                    var return_date = data[i]['return_date'];
                    var pos_des_id = data[i]['pos_des_id'];
                    var pos_des_type = data[i]['pos_des_type'];
                    var station = data[i]['station'];
                    var station_id = data[i]['station_id'];
                    var destination = data[i]['destination'];
                    var purpose = data[i]['purpose'];
                    var created_at = data[i]['created_at'];
                    var interval = data[i]['interval'];
                    var days = data[i]['days'];

                    var can_view = data[i]['can_view'];
                    var can_update = data[i]['can_update'];
                    var can_release = data[i]['can_release'];
                    var status = data[i]['status'];
                    var class_sss = data[i]['class'];
                    var to_status = data[i]['to_status'];
                    var doc_type = data[i]['doc_type'];
                    var doc_type_id = data[i]['doc_type_id'];

                    var limit_update ='';

                    if(to_status == '1'){
                        var can_delete = data[i]['can_delete'];
                    }else{
                        var can_delete = '';
                    }

                    if(to_status == '11'){
                        limit_update = '';
                    }else{
                        limit_update = can_update;
                    }

                    /***/

                    cd = '' +
                        '<tr >' +

                    //to_id
                        '<td style="display: none" class="to_id">' +
                        id+
                        '</td>' +

                    //user_id
                        '<td style="display: none" class="name_id">' +
                        name_id+
                        '</td>' +

                    //name_created_by
                        '<td  class="text-'+class_sss+'">'+
                        '<div class="flex justify-center items-center" >'+
                                '<a id="for_action_button" data-doc-typ="'+doc_type+'" data-doc-tid="'+doc_type_id+'" href="javascript:;" class="box flex items-center px-3 py-2 rounded-md bg-white/10 dark:bg-darkmode-700 font-medium" data-tw-toggle="modal" data-tw-target="#view_signatories_modal"> <div class="w-2 h-2 bg-'+class_sss+' rounded-full mr-3"></div> '+ status+' </a>'+
                            '</div>'+

                        '</td>' +

                    //purpose
                        '<td class="name text-justify">' +

                            '<div data-to-prps="'+purpose+'">'+

                            '<span class="text">'+purpose+'</span>'+

                            '</div>'+

                            '<div class="text-slate-500 text-xs whitespace-nowrap text-secondary mt-0.5 level">'+created_at+'</div>'+

                        '</td>' +

                    //number of days
                        '<td ' +

                        '<div class="whitespace-nowrap type">'+

                        '<span class="text">'+days+'</span>'+

                        '</div>'+

                            '<span class="hidden">'+days+'</span>'+

                        '</td>' +

                    //departure
                        '<td ' +

                        '<div class="whitespace-nowrap type">'+

                        '<span class="text">'+departure_date+'</span>'+

                        '</div>'+

                            '<span class="hidden">'+departure_date+'</span>'+

                        '</td>' +

                    //return
                        '<td >'+
                                '<div class="whitespace-nowrap type">'+
                                '<span class="text">'+return_date+'</span>'+
                                '</div>'+

                                '<span class="hidden">'+return_date+'</span>'+

                        '</td>' +

                    //station
                        '<td class="station">'+

                            '<div class="flex items-center whitespace-nowrap text-'+station+'"><div class="w-2 h-2 bg-'+station+' rounded-full mr-3"></div>'+station+'</div>' +
                            '<span class="hidden">'+station+'</span>'+

                        '</td>' +

                    //destination
                        '<td class="destination">' +

                        '<div class="flex items-center whitespace-nowrap text-'+destination+'"><div class="w-2 h-2 bg-'+destination+' rounded-full mr-3"></div>'+destination+'</div>' +
                        '<span class="hidden">'+destination+'</span>'+

                        '</td>' +
                    //actions
                        '<td>' +
                            '<div class="flex justify-center items-center">'+
                                    can_release+
                                '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">'+
                                    '<a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>'+
                                    '<div class="dropdown-menu w-40">'+
                                        '<div class="dropdown-content">'+
                                                limit_update+
                                                can_view+
                                                can_delete+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</td>' +

                        '</tr>' +
                        '';

                        dt__created_travel_order.row.add($(cd)).draw();
                    /***/
                }
            }
            hideLoading();
        }
    });
}




    $("body").on("click", "#add_row_signatories", function (ev) {
        if($('#trav_emp_list').val()){
            add_row_sig();
        }else{

        }
    });


    function add_row_sig(){
        var tr=
            '<tr class="hover:bg-gray-200">'+
            '<td style="display:none">'+$('#trav_emp_list').val()+'</td>'+
            '<td style="display:none"><input type="text" style="display: none" name="table_signatory_id[]" class="form-control "  value=""</td>'+
            '<td><input type="text" style="display: none" name="table_signatory_emp_id[]" class="form-control "  value="'+$('#trav_emp_list').val()+'">'+$('#trav_emp_list option:selected').text()+'<input type="text" name="table_signatory_suffix[]" class="form-control w-24"  value="'+$('#sd_modal_suffix').val()+'"</td>'+
            '<td><input type="text" name="table_signatory_description[]" class="form-control "  value="'+$('#sd_modal_sd').val()+'"></td>'+
            '<td><a href="javascript:void(0);" class="flex items-center text-theme-6 delete"><i  class="w-4 h-4 mr-1 far fa-trash-alt">Remove</i></a></td>'+
        '</tr>';
        $('.sig_modal_table tbody').append(tr);
        $('#sd_modal_sd').val('');
        $('#sd_modal_suffix').val('');

        trav_emp_list.val(null).trigger('change');
    };

    $('.sig_modal_table tbody').on('click','.delete',function(){
        var last=$('.sig_modal_table tbody tr').length;

        var table_signatory_id = $(this).closest('tr').find('.table_signatory_id').val();

        if (table_signatory_id) {
            $.ajax({
                url: "order/remove/signatory/travel/order",
                type: "POST",
                data: {
                    _token:_token,
                    table_signatory_id:table_signatory_id,
                },
                cache: false,
                success: function (data) {


                    __notif_load_data(__basepath + "/");
                }
            });
        }
            $(this).parent().parent().remove();

    });

    $('.sig_modal_table tbody').on('click','.delete',function(){
        var last=$('.sig_modal_table tbody tr').length;
            $(this).parent().parent().remove();
    });

    $("body").on('click', '.not_allowed_to_take_action', function (){

        $.ajax({
            url: bpath + 'admin/manage/load/priv/notif',
            type: "POST",
            data: {
                _token: _token,


            },
            success: function(data) {
                var data = JSON.parse(data);

                __notif_load_data(__basepath + "/");

            }

        });

       });

    $('#add_travel_order').on('click',function(){


        document.getElementById("add_travel_order").style.pointerEvents = "none";


        let save_or_update = document.getElementById('add_travel_order').innerText;
        let to_id = $('#modal_update_to_id').val();
        let name_modal = '';
        let name_modal_text = '';
        let modal_date_now = $('#modal_date_now').val();
        let modal_departure_date = $('#modal_departure_date').val();
        let modal_return_date = $('#modal_return_date').val();
        let pos_des = $('#pos_des').val();
        var pos_des_type = $('#pos_des').find(":selected").attr('data-ass-type');
        let modal_station = $('#modal_station').val();
        let modal_destination = $('#modal_destination').val();
        let modal_purpose = $('#modal_purpose').val();
        var table_signatory_emp_id = [];
        var table_signatory_description = [];
        var table_signatory_suffix = [];
        var table_signatory_id = [];

        var to_memberList = [];

        $('#name_modal :selected').each(function(i, selected) {
            to_memberList[i] = $(selected).val();
        });

        $('input[name="table_signatory_emp_id[]"]').each(function (index, emp_id) {
            table_signatory_emp_id[index] = $(emp_id).val();
        });


        $('input[name="table_signatory_description[]"]').each(function (i, desc) {
            table_signatory_description[i] = $(desc).val();

        });

        $('input[name="table_signatory_suffix[]"]').each(function (i, suff) {
            table_signatory_suffix[i] = $(suff).val();

        });

        $('input[name="table_signatory_id[]"]').each(function (i, sig_id) {
            table_signatory_id[i] = $(sig_id).val();

        });


        $.ajax({
            type: "POST",
            url: bpath + 'travel/order/add/travel/order',
            data: {
                _token: _token,
                name_modal:name_modal,
                name_modal_text:name_modal_text,
                to_memberList:to_memberList,
                modal_date_now:modal_date_now,
                modal_departure_date:modal_departure_date,
                modal_return_date:modal_return_date,
                pos_des:pos_des,
                pos_des_type:pos_des_type,
                modal_station:modal_station,
                modal_destination:modal_destination,
                modal_purpose:modal_purpose,
                table_signatory_emp_id:table_signatory_emp_id,
                table_signatory_description:table_signatory_description,
                table_signatory_suffix:table_signatory_suffix,
                table_signatory_id:table_signatory_id,
                save_or_update:save_or_update,
                to_id:to_id,

            },
            success:function (response) {
                var data = JSON.parse(response);
                if(data.no_signatory){
                    __notif_load_data(__basepath + "/");
                    document.getElementById("add_travel_order").style.pointerEvents = "";
                }else{
                    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#make_travel_order_modal'));
                    mdl.hide();
                    document.getElementById("add_travel_order").style.pointerEvents = "";
                    $(".btn").prop('disabled', false);
                    clear_add_update_modal();
                    load_travel_order_data();
                    __notif_load_data(__basepath + "/");
                }

            }
        });


    });

    $("body").on("click", "#btn_delete_to", function (ev) {
        to_id = $(this).data('to-id');
        // console.log( to_id);
        swal({
            container: 'my-swal',
            title: 'Are you sure?',
            text: "It will permanently deleted!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1e40af',
            cancelButtonColor: '#6e6e6e',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value == true) {
                swal({
                    title:"Deleted!",
                    text:"Travel Order deleted permanently!",
                    type:"success",
                    confirmButtonColor: '#1e40af',
                    confirmButtonColor: '#1e40af',
                    timer: 1000
                });

                $.ajax({
                    url: "order/remove",
                    type: "POST",
                    data: {
                        _token:_token,
                        to_id: to_id,
                    },
                    cache: false,
                    success: function (data) {
                        //console.log(data);
                        var data = JSON.parse(data);
                        __notif_load_data(__basepath + "/");
                        load_travel_order_data();
                    }
                });
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swal({
                    title:"Cancelled",
                    text:"No action taken!",
                    type:"error",
                    confirmButtonColor: '#1e40af',
                    confirmButtonColor: '#1e40af',
                    timer: 500
                });
            }
        })
    });


    $("body").on("click", "#btn_update_to", function (ev) {
        to_id = $(this).data('to-id');

        document.getElementById('add_travel_order').innerText = "Update"

        $.ajax({
            url: "order/load/details",
            type: "POST",
            data: {
                _token:_token,
                to_id: to_id,
            },
            cache: false,
            success: function (data) {
                clear_add_update_modal();
                var data = JSON.parse(data);

                    console.log(data.selected_values_members);

                    $('#modal_update_to_id').val(data['get_to']['id']);

                    $('#modal_date_now').val(data['get_to']['date']);
                    $('#modal_departure_date').val(data['get_to']['departure_date']);
                    $('#modal_return_date').val(data['get_to']['return_date']);
                    $('#modal_station').val(data['get_to']['station']);
                    $('#modal_destination').val(data['get_to']['destination']);
                    $('#modal_purpose').val(data['get_to']['purpose']);

                    $('.sig_modal_table tbody').append(data['sig_for_table']);

                    //  name_modal.select2(data.selected_values_members, null, false);
                    $('#name_modal').val(data.selected_values_members).change();

                    if(data['get_to']['status'] == 1){
                        $(".delete").css("display", "block");
                        $("#div_hide_if_not_pending").css("display", "block");

                    }else{
                        // $('.delete').hide();
                        $(".delete").css("display", "none");
                        $("#div_hide_if_not_pending").css("display", "none");

                    }

                    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#make_travel_order_modal'));
                    mdl.toggle();

            }
        });
    });

    $("body").on("click", "#release_travel_order", function (ev) {
        to_id = $(this).data('to-id');

        $.ajax({
            url: "order/load/details",
            type: "POST",
            data: {
                _token:_token,
                to_id: to_id,
            },
            cache: false,
            success: function (data) {
                var data = JSON.parse(data);

                    $('#modal_release_to_id').val(data['get_to']['id']);
                    $('.sig_modal_table tbody tr').detach();
                    $('.sig_modal_table tbody').append(data['sig_for_table']);

                    $('.sig_modal_table_modal tbody tr').detach();
                    $('.sig_modal_table_modal tbody').append(data['sig_for_table_modal']);
                    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#release_travel_order_modal'));

                    __notif_load_data(__basepath + "/");

                if(data['get_to']['status'] != 1){
                    mdl.hide();
                }else{
                    mdl.toggle();
                }
                 load_travel_order_data();
            }
        });
    });

    $("body").on("click", "#make_travel_order", function (ev) {

        document.getElementById('add_travel_order').innerText = "Save";
        clear_add_update_modal();
        $(".delete").css("display", "block");
        $("#div_hide_if_not_pending").css("display", "block");
    });

    $("body").on("click", "#btn_release_travel_order_modal", function (ev) {
        const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#release_travel_order_modal'));
                mdl.hide();

        to_id = $('#modal_release_to_id').val();
        message = $('#message').val();

        //  console.log(message)

        $.ajax({
            url: "order/release/travel/order",
            type: "POST",
            data: {
                _token:_token,
                to_id: to_id,
                message: message,
            },
            cache: false,
            success: function (data) {
                var data = JSON.parse(data);
                __notif_load_data(__basepath + "/");
                load_travel_order_data();
                //  console.log(data);
            }
        });

    });


    function clear_add_update_modal() {
        $('.sig_modal_table tbody tr').detach();
        trav_emp_list.val(null).trigger('change');
        name_modal.val(null).trigger('change');
        $('#sd_modal_sd').val('');
        $('#sd_modal_suffix').val('');
        $('#modal_date_now').val('');
        $('#modal_departure_date').val('');
        $('#modal_return_date').val('');
        $('#modal_station').val('');
        $('#modal_destination').val('');
        $('#modal_purpose').val('');

        $('#modal_update_to_id').val('');


    }
