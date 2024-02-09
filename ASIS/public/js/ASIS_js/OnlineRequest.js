
$(document).ready(function() {

    bpath = __basepath + "/";
    manage_list_of_services_offices();
    load_tbl_load_requested_dashboard('');
    load_tbl_my_requested_dashboard('');
    load_office_departmenttable('');
    load_list_of_offices_and_services('');
    load_set_office_account('');
  


});


var  _token = $('meta[name="csrf-token"]').attr('content');

var tbl_my_dashboard_table;
var tbl_requested_dashboard_table;
var tbl_offices_departmentlist ;
var tbl_list_of_offices_and_services;
var tbl_list_set_account_office;



function manage_list_of_services_offices() {

    try{
        /**data table for admin dashboard*/
        tbl_requested_dashboard_table = $('#requested_dashboard_table').DataTable({
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
            "aLengthMenu": [[5,10,15,20,25,30,35,50,-1], [5,10,15,20,25,30,35,50,"All"]],
            "iDisplayLength": 10,
            "aaSorting": [],

            columnDefs:
                [
                    { className: "dt-head-center", targets: [ 8 ] },
                ],
        });


         /** end data table for admin dashboard*/


          /**data table for my dashboard*/
        tbl_my_dashboard_table = $('#my_dashboard_table').DataTable({
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
                    { className: "dt-head-center", targets: [ 6 ] },
                ],
        });


          tbl_offices_departmentlist = $('#office_departmentlist_table').DataTable({
            dom:
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-3 text_left_1'><'intro-y col-span-6 text_left_1'f>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'tr>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'<'datatable_paging_1'p>>>",
            renderer: 'bootstrap',
            "info": false,
            "bInfo":true,
            "bJQueryUI": true,
            "bProcessing": true,
            "bPaginate" : true,
            "aLengthMenu": [[5,10,15, 20, -1], [5,10,15, 20,"All"]],
            "iDisplayLength": 5,
            "aaSorting": [],

            columnDefs:
                [
                    { className: "dt-head-center", targets: [ 1 ] },
                ],
        });


          tbl_list_of_offices_and_services = $('#offices_and_services_table').DataTable({
               dom:
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-6 text_left_1'><'intro-y col-span-6 text_left_1'f>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'tr>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'<'datatable_paging_1'p>>>",
            renderer: 'bootstrap',

            "info": false,
            "bInfo":true,
            "bJQueryUI": true,
            "bProcessing": true,
            "bPaginate" : true,
            "aLengthMenu": [[5,10,15, 20, -1], [5,10,15, 20,"All"]],
            "iDisplayLength": 3,
            "aaSorting": [],

            columnDefs:
                [
                    { className: "dt-head-center", targets: [ 4 ] },
                ],
        });





        tbl_list_set_account_office = $('#set_account_offices_table').DataTable({
           dom:
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-6 text_left_1'><'intro-y col-span-6 text_left_1'f>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'tr>>" +
                "<'grid grid-cols-12 gap-6 mt-5'<'intro-y col-span-12'<'datatable_paging_1'p>>>",
            renderer: 'bootstrap',

        "info": false,
        "bInfo":true,
        "bJQueryUI": true,
        "bProcessing": true,
        "bPaginate" : true,
        "aLengthMenu": [[5,10,15, 20, -1], [5,10,15, 20,"All"]],
        "iDisplayLength": 5,
        "aaSorting": [],

        columnDefs:
            [
                { className: "dt-head-center", targets: [3 ] },
            ],
    });


         /** end data table for my dashboard*/



    }catch(err){  }
}

//load user acount/manage set account 

function load_set_office_account(id) {

    $.ajax({
       url: bpath + 'onlinerequest/dashboard/set_account_inoffice',
        type: "POST",
        data: {
            _token: _token,
            id: id
        },
       
        success: function(data) {

    
            tbl_list_set_account_office.clear().draw();
            /***/

            var data = JSON.parse(data);
            
            if(data.length > 0) {

                for(var i=0;i<data.length;i++) {
                    /***/
                    var id = data[i]['id'];
                    var fullname = data[i]['fullname'];
                    var email = data[i]['email'];
                    var role = data[i]['role'];
                    var office_name = data[i]['office_name'];

                    var cd = "";
                    /***/

                    cd = '' +
                        '<tr >' +

                        '<td style="display: none" class="id">' +
                        id+
                        '</td>' +
                    
                        '<td>' +
                        fullname+
                        '</td>' +

                        '<td>' +
                        email+
                        '</td>' +

                        '<td>' +
                        role+
                        '</td>'+

                        '<td>'+
                        office_name+
                        '</td>'+

                        '</td>' +

                        '</tr>' +
                        '';

                        tbl_list_set_account_office.row.add($(cd)).draw();

                    /***/

                }

            }
        }

    });

}

//
$('body').on('click', '#userAccount_update_btn', function (){

    let form_data = {

        _token,
        id : $('#User_ID').val(),
        office : $('#office').val(),

    }

    $.ajax({
        url: bpath + 'onlinerequest/dashboard/set_user_account_update',
        type: "post",
        data: form_data,
        success: function (response) {
            if (response)
            {
                let data = JSON.parse(response);
                let approval_status = data['approval_status'];

                if(approval_status == 200)
                {
                    __notif_show(1, 'Success', 'Success');
                    $('#set_Account_office form')[0].reset();
                    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#set_Account_office'));
                    mdl.hide();
                    load_set_office_account('');
                }
            }
        }
    });

});





//Start load my requested data

function load_tbl_load_requested_dashboard(id) {

    $.ajax({
        url: bpath + 'onlinerequest/dashboard/student/load_requested_data',
        type: "POST",
        data: {
            _token: _token,
            id: id,
        },
        success: function(data) {

            tbl_requested_dashboard_table.clear().draw();
            /***/
            var data = JSON.parse(data);

            if(data.length > 0) {
                for(var i=0;i<data.length;i++) {

                    /***/
                    var id = data[i]['id'];
                    var fullname = data[i]['fullname'];
                    var program =data[i]['studmajor'];
                    var course = data[i]['course'];
                    var request_type = data[i]['request_type'];
                    var purpose =data[i]['purpose'];
                    var no_of_copies = data[i]['no_of_copies'];
                    var request_date = data[i]['created_at'];
                    var approved_date = data[i]['approvedate'];
                    var claim_date = data[i]['claim_date'];
                    var status = data[i]['status'];
                    var status_class = 'pending';

                    if(status === 'Approved'){

                        status_class = 'success';
                        
                    }else if(status === 'Disapproved'){
                        status_class = 'danger';
                    
                    }

                    var cd = "";
                    /***/

                    cd = '' +
                        '<tr >' +

                        '<td style="display: none" class="id">' +
                        id+
                        '</td>' +

                        '<td>' +
                        fullname+
                        '</td>' +

                        '<td>' +
                        request_type+
                        '</td>' +

                        '<td>' +
                        purpose+
                        '</td>' +

                        '<td>' +
                        no_of_copies+
                        '</td>' +

                        '<td>' +
                        request_date+
                        '</td>' +

                        '<td>'+
                        approved_date+
                        '</td>'+


                        '<td>'+
                        claim_date+
                        '</td>'+


                       '<td class="text-'+status_class+'">' +
                        status+
                        '</td>'+


                        '<td class="w-auto">' +
                        '<div class="flex justify-center items-center">'+
                        ' <div> <button id="'+id+'" data-theme="light" class="get_approval_action_btn tooltip" href="javascript:;" data-id="id"  data-tw-toggle="modal" data-tw-target="#approval_action_modal"><i class="fa fa-edit text-primary"></i>&nbsp &nbsp &nbsp '+
                        '</div>'+
                        '</td>' +

                        '</tr>' +
                        '';

                        tbl_requested_dashboard_table.row.add($(cd)).draw();


                    /***/

                }

            }
        }

    });

}
//End load my requested data



$(document).on('change', '.office_name', function(e) {
    // Get the selected office_id
    var office_id = $(this).val();
    var div = $(this).closest('.modal-body');
    var op = '';

    $.ajax({
        url: '/onlinerequest/dashboard/get_offices_services',
        method: 'get',
        data: {
            id: office_id,
            _token: '{{ csrf_token() }}'
        },
        
        success: function(data) {
         
          op+='<option value="0" selected disabled>Choose Request</option>';
         
            for (var i = 0; i < data.length; i++) {
         
                op += '<option value="' + data[i].services + '">' + data[i].services + '</option>';
         
            }

            div.find('.services').html("");
            div.find('.services').append(op);

        },
        error: function(xhr, status, error) {

            console.error(error);

        }
    });
});





//*get requested student data*/
$(document).on('click', '.get_approval_action_btn', function(e) {
   
    e.preventDefault();
    let id = $(this).attr('id');

    $.ajax({
    url: '/onlinerequest/dashboard/get_requested_action/' + id + '/edit',
    method: 'get',
    data: {
        id: id,

    _token: '{{ csrf_token() }}'

},

  success:  function(data){

                $("#status").val(data.status);
                $("#std_id").val(data.id);    
                $("#studid").val(data.studid);
                $("#claim_date").val(data.claim_date);
                $("#std_fullname_txt").text(data.get_student_fullname.fullname);
                $("#messages").text(data.message);

                }

            });

});


$('body').on('click', '#approve_request_btn', function (){

    let form_data = {

        _token,
        std_id : $('#std_id').val(),
        studid: $('#studid').val(),
        status : $('#status').val(),
        claim_date : $('#claim_date').val(),
        messages: $('#messages').val(),
   


    }

    $.ajax({
        url: bpath + 'onlinerequest/dashboard/requested_action_approval',
        type: "post",
        data: form_data,
        success: function (response) {
            if (response)
            {
                let data = JSON.parse(response);
                let approval_status = data['approval_status'];

                if(approval_status == 200)
                {
                    __notif_show(1, 'Success', 'Success');
                    $('#approval_action_modal form')[0].reset();
                    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#approval_action_modal'));
                    mdl.hide();
                    load_tbl_load_requested_dashboard();
                }
            }
        }
    });

});



//Start load my requested data

function load_tbl_my_requested_dashboard(id) {

    $.ajax({
        url: bpath + 'onlinerequest/dashboard/load_student_request',
        type: "POST",
        data: {
            _token: _token,
            id: id,
        },
        success: function(data) {

            tbl_my_dashboard_table.clear().draw();
            /***/
            var data = JSON.parse(data);

            if(data.length > 0) {
                for(var i=0;i<data.length;i++) {

                    /***/
                    var id = data[i]['id'];
                    var office_name = data[i]['office_name'];
                    var reqeuest_type = data[i]['request_type'];
                    var purpose = data[i]['purpose'];
                    var no_of_copies = data[i]['no_of_copies'];
                    var created_at = data[i]['created_at'];
                    var approved_date = data[i]['approved_date'];
                    var recieved_date = data[i]['recieved_date'];
                    var status = data[i]['status'];
                    var checkfile = data[i]['checkfile'];
                    var attachment_file = data[i]['request_type'];


                     var status_class = 'pending';

                    if(status === 'Approved'){

                        status_class = 'success';
                        
                    }else if(status === 'Disapproved'){
                        status_class = 'danger';
                    
                    }


                    var printR = data[i]['printR'];
            
          

                    var cd = "";
                    /***/

                    cd = '' +
                        '<tr >' +

                        '<td style="display: none" class="id">' +
                        id+
                        '</td>' +

                        '<td>' +
                        office_name+
                        '</td>' +

                        '<td>'+
                        reqeuest_type+
                        '</td>'+

                        '<td>' +
                        purpose+
                        '</td>' +

                        '<td>' +
                        no_of_copies+
                        '</td>' +

                        '<td>' +
                        created_at+
                        '</td>' +

                        '<td>' +
                        approved_date+
                        '</td>' +

                        '<td>'+ 
                        recieved_date+
                        '</td>'+

                       '<td class="text-'+status_class+'">' +
                        status+
                        '</td>'+

                        '<td>'+
                         ' <div> <button id="'+id+'" class="get_attachment_file" href="javascript:;"><i class="fa fa-download text-secondary" class="tooltip cursor-pointer "title="Download File"></i>&nbsp &nbsp'+
                        checkfile +  attachment_file+
                        '</td>' +


                        '<td class="w-auto">' +
                        '<div class="flex justify-center items-center">'+
                        ' <div> <button id="'+id+'" class="recive_action_btn" href="javascript:;" data-id="id"  data-tw-toggle="modal" data-tw-target="#recieve_action_modal"><i class="fa fa-edit text-primary"></i>&nbsp &nbsp '+
                         printR +
                        '</div>'+
                        '</td>' +

                        '</tr>' +
                        '';

                        tbl_my_dashboard_table.row.add($(cd)).draw();


                    /***/

                }

            }
        }

    });

}
//End load my requested data


$(document).on('click', '.get_attachment_file', function(e) {
    e.preventDefault();
    var id = $(this).attr('id');
  
   var csrf = '{{ csrf_token() }}';
    Swal.fire({
        icon: 'info',
        title: 'Download',
        text: 'Do you want to downlaod?',
        showCancelButton: true,
        confirmButtonColor: '#1e40af',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes,download'

    }).then((result) => {

      if (result.value==true) {
        $.ajax({
          url: '/onlinerequest/dashboard/download_attachment_documents/' + id + '/download',
          method: 'get',
          data: {
            id: id,
            _token: csrf
          },

          success: function(response) {
               Swal.fire(
              'Success!',
              'Your file has been Downloaded.',
              'success'
            )
            window.open("/onlinerequest/dashboard/download_attachment_documents/" + id + "/download");
          }
        });
      }
    })

  });


//print my Request

$(document).on('click', '.print_btn', function(e) {
    e.preventDefault();
    var id = $(this).attr('id');
    var csrf = '{{ csrf_token() }}';

    Swal.fire({
        icon: 'info',
        title: 'Print',
        text: 'Do you want to Print?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1e40af',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, print it!'
    
    }).then((result) => {
        if (result.value) {
            var url = '/onlinerequest/dashboard/printR/' + id + '/print';
            window.open(url, "_blank");
        }
    });


});

/*End print My Request */ 


/*get receive request function*/

$(document).on('click', '.recive_action_btn', function(e) {
    e.preventDefault();
    let id = $(this).attr('id');

    $.ajax({
    url: '/onlinerequest/dashboard/get_receive_date_f/' + id,
    method: 'get',
    data: {
        id: id,

    _token: '{{ csrf_token() }}'

},
  success:  function(data){


                $("#r_id").val(data.id);
            
                }

            });

});

//end get receive request function


//received function
$('body').on('click', '#receive_request_btn', function (){

    let form_data = {

        _token,
        r_id : $('#r_id').val(),

    }

    $.ajax({
        url: bpath + 'onlinerequest/dashboard/receive_date_function',
        type: "post",
        data: form_data,
        success: function (response) {
            if (response)
            {
                let data = JSON.parse(response);
                let approval_status = data['approval_status'];

                if(approval_status == 200)
                {
                    __notif_show(1, 'Success', 'Successfully Received');

                    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector('#recieve_action_modal'));
                    mdl.hide();
                   load_tbl_my_requested_dashboard('');

                }else{


                    __notif_show(-1, 'Not Yet Approve', 'Please wait for the Approval');

                    return;

                }
            }
        }
    });

});

//end recieve function


/**Online Request Application*/

$("body").on("click", "#store_online_request_btn", function () {

    var course = $('#course').val();
    var office = $('#office_name').val();
    var request_type = $('#request_type').val();
    var purpose = $('#purpose').val();
    var no_of_copies = $('#no_of_copies').val();
    var message = $('#message').val();

     if (!office) {

    const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector("#online_request_modal"));
    mdl.hide();
     
     Swal.fire({
        

        icon:'info',
        title:"Please Select Office",
        text:" to Request!",
        type:'warning',
        confirmButtonText:'OK',

        });

    return;


    }

    $.ajax({
        url: bpath + 'onlinerequest/dashboard/store_student_request',
        type: "post",
        data: {

            _token: _token,

         course:course,   
         office:office,
         request_type:request_type,
         purpose:purpose,
         no_of_copies:no_of_copies,
         message:message

        },
        success: function(data) {

            var data = JSON.parse(data);

            $('#online_request_modal form')[0].reset();
                __notif_load_data(__basepath + "/");
                load_tbl_my_requested_dashboard('');
                const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector("#online_request_modal"));
                mdl.hide();

            }

        });

});



function load_office_departmenttable(id) {

    $.ajax({
       url: bpath + 'onlinerequest/dashboard/get_offices',
        type: "POST",
        data: {
            _token: _token,
            id: id
        },
       
        success: function(data) {

    
            tbl_offices_departmentlist.clear().draw();
            /***/

            var data = JSON.parse(data);
            if(data.length > 0) {
                for(var i=0;i<data.length;i++) {

                    /***/

                    var id = data[i]['id'];
                    var office_name = data[i]['office_name'];

                    var cd = "";
                    /***/

                    cd = '' +
                        '<tr >' +

                        '<td style="display: none" class="id">' +
                        id+
                        '</td>' +
                    
                        '<td>' +
                        office_name+
                        '</td>' +

                        '<td class="table-report__action w-56">' +
                        ' <div class="flex justify-center items-center">'+
                        ' <a id="'+id+'" class="edit_offices_btn flex items-center mr-3  text-primary tooltip cursor-pointer" title="Edit" href="javascript:;"data-tw-toggle="modal" data-tw-target="#add_office_services_modal"><i class="fa-solid fa-pen-to-square"></i> </a>&nbsp&nbsp&nbsp&nbsp '+
                        ' <a id="'+id+'" class="delete_office_btn flex items-center text-danger tooltip cursor-pointer" title="Remove" href="javascript:;"><i class="fa-solid fa-xmark"></i> </a>'+
                        '</div>'+

                        '</td>' +

                        '</tr>' +
                        '';

                        tbl_offices_departmentlist.row.add($(cd)).draw();


                    /***/

                }

            }
        }

});

// 


$(document).on('click', '.edit_offices_btn', function(e) {
    e.preventDefault();
    let id = $(this).attr('id');
    $.ajax({
    url: '/onlinerequest/dashboard/edit_offices/' + id + '/edit',
    method: 'get',
    data: {
        id: id,

    _token: '{{ csrf_token() }}'

},

  success:  function(data){

                $("#office_name").val(data.office_name);
                $("#office_id").text(data.id);
         

                }

            });

});




$(document).on('click', '.delete_office_btn', function(e) {
    e.preventDefault();
    var id = $(this).attr('id');
   
    var csrf = '{{ csrf_token() }}';
    Swal.fire({

        icon: 'warning',
        title: 'Are you sure',
        text: "Do you want to remove?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1e40af',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it',

    }).then((result) => {

      if (result.value==true) {
        $.ajax({
          url: '/onlinerequest/dashboard/delete_offices/' + id + '/delete',
          method: 'get',
          data: {
            id: id,
            _token: csrf
          },
          success: function(response) {
            Swal.fire(
              'Removed',
              'Your file has been Removed.',
              'error'
            )

            __notif_load_data(__basepath + "/");

            load_office_departmenttable('');

          }
        });
      }
    })
  });


/**add office*/

$("body").on("click", "#store_new_office_btn", function () {

    var office_name = $('#officename').val();

    $.ajax({
        url: bpath + 'onlinerequest/dashboard/store_new_office',
        type: "post",
        data: {

            _token: _token,

         office_name:office_name

        },
        success: function(data) {

            var data = JSON.parse(data);

            $('#add_new_office_modal form')[0].reset();
                const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector("#add_new_office_modal"));
                mdl.hide();
            __notif_load_data(__basepath + "/");
            load_office_departmenttable('');
            location.reload(true);

            }

        });

    });
}



function load_list_of_offices_and_services(id) {

    $.ajax({
       url: bpath + 'onlinerequest/dashboard/list_of_offices_and_services',
        type: "POST",
        data: {
            _token: _token,
            id: id
        },
       
        success: function(data) {
    
           tbl_list_of_offices_and_services.clear().draw();
            /***/

            var data = JSON.parse(data);
            if(data.length > 0) {
                for(var i=0;i<data.length;i++) {

                    /***/

                    var id = data[i]['id'];
                    var office_name = data[i]['office_name'];
                    var services = data[i]['services'];
                    var added_by = data[i]['added_by'];
                    var created_at = data[i]['created_at'];

                    var cd = "";
                    /***/

                    cd = '' +
                        '<tr >' +

                        '<td style="display: none" class="id">' +
                        id+
                        '</td>' +
                    
                        '<td>' +
                        office_name+
                        '</td>' +

                        '<td>' +
                        services+
                        '</td>' +

                        '<td>' +
                        added_by+
                        '</td>' +

                        '<td>' +
                        created_at+
                        '</td>' +

                        '<td class="table-report__action w-56">' +
                        ' <div class="flex justify-center items-center">'+
                        ' <a id="'+id+'" class="delete_services_btn flex items-center text-danger tooltip cursor-pointer" title="Remove" href="javascript:;"><i class="fa-solid fa-xmark"></i> </a>'+
                        '</div>'+

                        '</td>' +

                        '</tr>' +
                        '';

                        tbl_list_of_offices_and_services.row.add($(cd)).draw();


                    /***/

                }

            }
        }

    });


//*add services*/

$("body").on("click", "#store_officeServices_btn", function () {

    var office_id = $("#office_id").text();
    var services = $('#office_services').val();

    $.ajax({
        url: bpath + 'onlinerequest/dashboard/store_officeServices',
        type: "post",
        data: {

            _token: _token,

         office_id:office_id,
         services:services,

    },
        success: function(data) {

            var data = JSON.parse(data);

                $('#add_office_services_modal form')[0].reset();
                const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector("#add_office_services_modal"));
                mdl.hide();
                 __notif_load_data(__basepath + "/");
                location.reload(true);

            }

        });

    });



$('body').on('click', '#program_Course_btn', function () {
    let form_data = {
        _token,
        date_from_req: $('#date_from_req').val(),
        date_to_req: $('#date_to_req').val(),
        programCourse: $('#programCourse').val(),
    }


    $.ajax({
        url: bpath + 'onlinerequest/dashboard/printRequestList_byProgram',
        type: "get",
        data: form_data,
        success: function (response) {
         
            
            
         }
    });
});





$(document).on('click', '.delete_services_btn', function(e) {
    e.preventDefault();
    var id = $(this).attr('id');
   
    var csrf = '{{ csrf_token() }}';
    Swal.fire({

        icon: 'warning',
        title: 'Are you sure?',
        text: "Do you want to remove?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1e40af',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it',

    }).then((result) => {

      if (result.value==true) {
        $.ajax({
          url: '/onlinerequest/dashboard/delete_services_f/' + id + '/delete',
          method: 'get',
          data: {
            id: id,
            _token: csrf
          },
          success: function(response) {
            Swal.fire(
              'Removed',
              'Your file has been Removed.',
              'error'
            )

            __notif_load_data(__basepath + "/");

          load_list_of_offices_and_services('');

          }
        });
      }
    })
  });


}




