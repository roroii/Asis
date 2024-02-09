$(document).ready(function (){

    bpath = __basepath + "/";
    load_travel_order();
    load_system_settings_data();
});



var  _token = $('meta[name="csrf-token"]').attr('content');
var  file_path = "";

function load_path(fakepath){
    file_path = fakepath;

}
//Initialize datatable system settings
function load_travel_order(){
    try{
        /***/
        dt__system_settings = $('#dt__system_settings').DataTable({
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
                    { className: "dt-head-center", targets: [  5 ] },
                ],
        });


        /***/
    }catch(err){  }
}

function load_system_settings_data() {

    $.ajax({
        url: bpath + 'admin/load/system/settings',
        type: "POST",
        data: {
            _token: _token,
        },
        success: function(data) {

            dt__system_settings.clear().draw();
            /***/
            var data = JSON.parse(data);
            if(data.length > 0) {
                for(var i=0;i<data.length;i++) {

                    /***/

                    var id = data[i]['id'];
                    var key = data[i]['key'];
                    var value = data[i]['value'];
                    var description = data[i]['description'];
                    var link = data[i]['link'];
                    var image = data[i]['image'];
                    var write = data[i]['write'];
                    var delete_ = data[i]['delete'];


                    var has_image = '';
                    if(image){
                         has_image = '<a href="'+bpath +'uploads/settings/'+image+'" target="blank"><div class="w-10 h-10 image-fit zoom-in -ml-5"><img  src="'+bpath +'uploads/settings/'+image+'"  class="tooltip rounded-full "></div></a>';
                    }else{
                         has_image = '<div class="w-10 h-10 image-fit zoom-in -ml-5"></div>';
                    }
                    /***/

                    cd = '' +
                        '<tr >' +

                    //return
                        '<td >'+
                                '<div class="whitespace-nowrap type">'+
                                '<span class="text">'+id+'</span>'+
                                '</div>'+

                                '<span class="hidden">'+id+'</span>'+

                        '</td>' +

                    //station
                        '<td class="station">'+

                            '<div class="flex items-center whitespace-nowrap text-'+key+'"><div class="w-2 h-2 bg-'+key+' rounded-full mr-3"></div>'+key+'</div>' +
                            '<span class="hidden">'+key+'</span>'+

                        '</td>' +

                    //destination
                        '<td class="destination">' +

                        '<div class="flex items-center whitespace-nowrap text-'+value+'"><div class="w-2 h-2 bg-'+value+' rounded-full mr-3"></div>'+value+'</div>' +
                        '<span class="hidden">'+value+'</span>'+

                        '</td>' +

                        //destination
                        '<td class="destination">' +

                        '<div class="flex items-center whitespace-nowrap text-'+description+'"><div class="w-2 h-2 bg-'+description+' rounded-full mr-3"></div>'+description+'</div>' +
                        '<span class="hidden">'+description+'</span>'+

                        '</td>' +

                        //destination
                        '<td class="destination">' +

                        '<div class="flex items-center whitespace-nowrap text-'+image+'"><div class="w-2 h-2 bg-'+image+' rounded-full mr-3"></div>'+has_image+'</div>' +
                        '<span class="hidden">'+description+'</span>'+

                        '</td>' +
                    //actions
                        '<td>' +
                            '<div class="flex justify-center items-center">'+
                                '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">'+
                                    '<a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>'+
                                    '<div class="dropdown-menu w-40">'+
                                        '<div class="dropdown-content">'+
                                            write+
                                            delete_+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</td>' +

                        '</tr>' +
                        '';

                        dt__system_settings.row.add($(cd)).draw();
                    /***/
                }
            }
        }
    });
}

$("body").on("click", "#btn_delete_ss", function (ev) {
    ss_id = $(this).data('ss-id');

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
                text:"System setting deleted permanently!",
                type:"success",
                confirmButtonColor: '#1e40af',
                confirmButtonColor: '#1e40af',
                timer: 1000
            });

            $.ajax({
                url: "remove/ss",
                type: "POST",
                data: {
                    _token:_token,
                    ss_id: ss_id,
                },
                cache: false,
                success: function (data) {
                    var data = JSON.parse(data);

                    __notif_load_data(__basepath + "/");
                    load_system_settings_data();
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

$("body").on("click", "#btn_update_ss", function (ev) {
    ss_id = $(this).data('ss-id');

    document.getElementById('save_system_setting').innerText = "Update"
    $('#modal_set_update_create').val("Update");
    $.ajax({
        url: "/admin/load/ss/details",
        type: "POST",
        data: {
            _token:_token,
            ss_id: ss_id,
        },
        cache: false,
        success: function (data) {
            clear_add_update_modal();
            var data = JSON.parse(data);

            console.log(data);
            $('#modal_set_update_id').val(data['get_ss']['id']);
            $('#modal_set_key').val(data['get_ss']['key']);
            $('#modal_set_value').val(data['get_ss']['value']);
            $('#modal_set_desc').val(data['get_ss']['description']);
            $('#modal_set_link').val(data['get_ss']['link']);
            $('#modal_set_current_logo').val(data['get_ss']['image']);


            const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#add_new_parameter_modal'));
                mdl.toggle();


        }
    });
});

$("body").on("click", "#add_new_parameter_btn", function (ev) {
    document.getElementById('save_system_setting').innerText = "Save"

    $('#modal_set_update_create').val("Save");

    clear_add_update_modal();
});
function clear_add_update_modal(){

}


    // $("body").on("click", "#save_system_setting", function (ev) {

    //     let key_id = $('#modal_set_update_id').val();

    //     let modal_set_key = $('#modal_set_key').val();
    //     let modal_set_value = $('#modal_set_value').val();
    //     let modal_set_desc = $('#modal_set_desc').val();
    //     let modal_set_link = $('#modal_set_link').val();
    //     let modal_set_imageUpload = document.getElementById("modal_set_imageUpload").files[0].name;
    //     // let modal_set_imageUpload = $('#modal_set_imageUpload').val();

    //     $.ajax({
    //         url: "/admin/add/setting",
    //         type: "POST",
    //         data: {
    //             _token:_token,
    //             modal_set_key:modal_set_key,
    //             modal_set_value:modal_set_value,
    //             modal_set_desc:modal_set_desc,
    //             modal_set_link:modal_set_link,
    //             modal_set_imageUpload:modal_set_imageUpload,
    //             file_path:file_path,
    //         },
    //         cache: false,
    //         success: function (data) {
    //             //console.log(data);

    //         }
    //     });

    // });
