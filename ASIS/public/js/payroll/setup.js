$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {

    bpath = __basepath + "/";

    load_setup_dt();
    load_incentive_dt();
    load_contribution_dt();

    load_setup();

    $(".Div2").hide();
    $(".Div3").hide();

});


var  _token = $('meta[name="csrf-token"]').attr('content');
var setup_tbldata;
var incentive_tbldata;
var contribution_tbldata;
var loan_tbldata;
var ded_id;
var loan_id;
var salary_action;
var deduction_action;
var incentive_id;



function load_setup_dt() {

    try{
        /***/
        setup_tbldata = $('#dt_pr_setup').DataTable({
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
        });
        /***/
    }catch(err){  }
}
function load_setup() {

    $.ajax({
        url: bpath + 'payroll/setup/load',
        type: "POST",
        data: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data) {
            setup_tbldata.clear().draw();
            /***/

            var data = JSON.parse(data);
            if(data.length > 0) {
                for(var i=0;i<data.length;i++) {

                    /***/
                    var id = data[i]['id'];
                    var name = data[i]['name'];
                    let salary = data[i]['salary'];
                    let incentive = data[i]['incentive'];
                    let contribution = data[i]['contribution'];
                    let deduction = data[i]['deduction'];




                    var cd = "";

                    /***/
                    cd = '' +
                        '<tr>' +

                        '<td class="hidden">' +
                        id+
                        '</td>' +

                        '<td>' +
                        '<a class="whitespace-nowrap" style="text-transform:uppercase">'+name+'</a>'+
                        '</td>' +


                        '<td class="w-40 !py-4 text-right">'+
                        salary+
                        '</td>'+

                        '<td class="w-40 !py-4 text-right">'+
                        incentive+
                        '</td>'+


                        '<td class="w-40 !py-4 text-right">' +
                        '<a href="javascript:;" class="underline decoration-dotted whitespace-nowrap openedit_con" data-id="'+id+'">'+contribution+'</a>'+
                        '</td>' +

                        '<td class="w-40 !py-4 text-right">' +
                        deduction+
                        '</td>' +


                        '<td>' +
                        '<div class="flex justify-center items-center">'+
                        '<div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">'+
                        '<a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>'+
                        '<div class="dropdown-menu w-40">'+
                        '<div class="dropdown-content">'+

                        '<a id="btn_showDetails" href="javascript:;" class="dropdown-item" "> <i class="fa fa-tasks w-4 h-4 mr-2 text-success"></i> Details </a>'+
                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '</td>' +

                        '</tr>' +
                        '';
                    setup_tbldata.row.add($(cd)).draw();
                    /***/
                }
            }
        },
        error: function(e) {
            console.log(e)
        }

    });
}

function load_incentive_dt() {

    try{
        /***/
        incentive_tbldata = $('#dt_emp_incentives').DataTable({
            dom:
                'lrt',
            renderer: 'bootstrap',
            "info": false,
            "bInfo":false,
            "bJQueryUI": false,
            "bProcessing": false,
            "bPaginate" : false,
            "aLengthMenu": [[10,25,50,100,150,200,250,300,-1], [10,25,50,100,150,200,250,300,"All"]],
            "iDisplayLength": 10,
            "aaSorting": [],
            "ordering":false
        });
        /***/
    }catch(err){  }
}
function load_incentive() {
    let id =  $('#inc_emp_id').val();
    $.ajax({
        url: bpath + 'payroll/setup/incentive/load',
        type: "POST",
        data: {
            emp_id:id,
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data) {
            incentive_tbldata.clear().draw();
            /***/

            var data = JSON.parse(data);
            if(data.length > 0) {
                for(var i=0;i<data.length;i++) {

                    /***/
                    var id = data[i]['id'];
                    var name = data[i]['name'];
                    let amount = data[i]['amount'];

                    var cd = "";

                    /***/
                    cd = '' +
                        '<tr>' +

                        '<td class="hidden">' +
                        id+
                        '</td>' +

                        '<td>' +
                        name+
                        '</td>' +


                        '<td>'+
                        amount+
                        '</td>'+

                        '<td class="!pl-4 text-slate-500" style="text-align: center">' +
                        '<a href="javascript:;"> <i data-id="'+id+'" data-tw-toggle="modal" data-tw-target="#emp_incentive_confirm" class="fa-regular fa-trash-can w-4 h-4 incentive_open_delete"></i> </a>'+
                        '</td>' +

                        '</tr>' +
                        '';
                    incentive_tbldata.row.add($(cd)).draw();
                    /***/
                }
            }
        },
        error: function(e) {
            console.log(e)
        }

    });
}

function load_contribution_dt() {

    try{
        /***/
        contribution_tbldata = $('#dt_emp_contribution').DataTable({
            dom:
                'lrt',
            renderer: 'bootstrap',
            "info": false,
            "bInfo":false,
            "bJQueryUI": false,
            "bProcessing": false,
            "bPaginate" : false,
            "aLengthMenu": [[10,25,50,100,150,200,250,300,-1], [10,25,50,100,150,200,250,300,"All"]],
            "iDisplayLength": 10,
            "aaSorting": [],
            "ordering":false
        });
        /***/
    }catch(err){  }
}
function load_contribution() {
    let id =  $('#cont_emp_id').val();
    $.ajax({
        url: bpath + 'payroll/setup/contribution/load',
        type: "POST",
        data: {
            emp_id:id,
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data) {
            contribution_tbldata.clear().draw();
            /***/

            var data = JSON.parse(data);
            if(data.length > 0) {
                for(var i=0;i<data.length;i++) {

                    /***/
                    var id = data[i]['id'];
                    var name = data[i]['name'];
                    let amount = data[i]['amount'];

                    var cd = "";

                    /***/
                    cd = '' +
                        '<tr>' +

                        '<td class="hidden">' +
                        id+
                        '</td>' +

                        '<td>' +
                        name+
                        '</td>' +


                        '<td>'+
                        amount+
                        '</td>'+

                        '<td class="!pl-4 text-slate-500" style="text-align: center">' +
                        '<a href="javascript:;"> <i data-id="'+id+'" data-tw-toggle="modal" data-tw-target="#emp_contribution_confirm" class="fa-regular fa-trash-can w-4 h-4 contribution_open_delete"></i> </a>'+
                        '</td>' +

                        '</tr>' +
                        '';
                    contribution_tbldata.row.add($(cd)).draw();
                    /***/
                }
            }
        },
        error: function(e) {
            console.log(e)
        }

    });
}

function load_loan_dt() {

    try{
        /***/
        loan_tbldata = $('#dt_emp_loan').DataTable({
            dom:
                "lrt",
            renderer: 'bootstrap',
            "info": false,
            "bInfo":false,
            "bJQueryUI": false,
            "bProcessing": false,
            "bPaginate" : false,
            "aLengthMenu": [[10,25,50,100,150,200,250,300,-1], [10,25,50,100,150,200,250,300,"All"]],
            "iDisplayLength": 10,
            "aaSorting": [],
            "ordering":false
        });
        /***/
    }catch(err){  }
}
function load_loan(){
    let id =  $('#loan_emp_id').val();
    $.ajax({
        url: bpath + 'payroll/setup/loan/load',
        type: "POST",
        data: {
            emp_id:id,
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data) {
            loan_tbldata.clear().draw();
            /***/

            var data = JSON.parse(data);
            if(data.length > 0) {
                for(var i=0;i<data.length;i++) {

                    /***/
                    var id = data[i]['id'];
                    var name = data[i]['name'];
                    let amount = data[i]['amount'];

                    var cd = "";

                    /***/
                    cd = '' +
                        '<tr>' +

                        '<td class="hidden">' +
                        id+
                        '</td>' +

                        '<td>' +
                        name+
                        '</td>' +


                        '<td>'+
                        amount+
                        '</td>'+

                        '<td class="!pl-4 text-slate-500" style="text-align: center">' +
                        '<a href="javascript:;"> <i data-id="'+id+'" data-tw-toggle="modal" data-tw-target="#emp_loan_confirm" class="fa-regular fa-trash-can w-4 h-4 loan_open_delete"></i> </a>'+
                        '</td>' +

                        '</tr>' +
                        '';
                    loan_tbldata.row.add($(cd)).draw();
                    /***/
                }
            }
        },
        error: function(e) {
            console.log(e)
        }

    });
}


$('body').on('click','.add_salary',function (e){
    let id=$('#modal_update_to_id').val();

    let choice = $('#emp_class').val();
    let rate_id = $('#rate_class').val();

    let sg=$('#sg').val();
    let step=$('#step').val();
    let amount='';

    if(choice==='1'){
        amount=$('#amount1').val();
        rate_id='';
    }else if(choice==='2'){
        amount=$('#amount2').val();
        sg='';
        step='';
    }else if(choice==='3'){
        amount=$('#amount3').val();
        sg='';
        step='';
    }


    if(salary_action==="Add"){
        $.ajax({
            url:"/payroll/setup/store",
            datatype:'JSON',
            method:'POST',
            data:{
                sg:sg,
                step:step,
                amount:amount,
                choice:choice,
                id:id,
                rate_id:rate_id
            },
            success:function (res){
                const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector("#set_salary"));
                mdl.hide();
                __notif_show(1, 'Success', 'Salary Was Saved Successfully!');
                load_setup();

            },error:function (err){
                console.log(err)
            }
        });
    }else if(salary_action==="Edit"){
        $.ajax({
            url:"/payroll/setup/update",
            datatype:'JSON',
            method:'POST',
            data:{
                sg:sg,
                step:step,
                amount:amount,
                choice:choice,
                id:id,
                rate_id:rate_id
            },
            success:function (res){
                const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector("#set_salary"));
                mdl.hide();
                __notif_show(1, 'Success', 'Salary Was Updated Successfully!');
                load_setup();

            },error:function (err){
                console.log(err)
            }
        });
    }



});
$('body').on('click','.addnewsalary',function (e){
    salary_action='Add';
    let id=$(this).data('id');
    $('#modal_update_to_id').val(id);
    clear_salary();
});
$('body').on('click','.editsalary',function (e){
    salary_action="Edit";
    let sal_id=$(this).data('sal_id');
    let emp_id=$(this).data('emp_id');
    $('#modal_update_to_sal_id').val(sal_id)
    $('#modal_update_to_id').val(emp_id)
    var e_emp_class = $('#emp_class');

    var e_sg = $('#sg');
    var e_step = $('#step');

    var e_rate_class = $('#rate_class');

    var e_amount1 = $('#amount1');
    var e_amount2 = $('#amount2');
    var e_amount3 = $('#amount3');

    $.ajax({
        url: bpath + 'payroll/setup/loadsalary_toedit',
        type: "POST",
        data: {
            'emp_id':emp_id,
            'sal_id':sal_id,
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data) {

            var data = JSON.parse(data);
            let mode=data['classification'];

            if(mode==='1'){
                e_sg.val(data['sg']);
                e_step.val(data['step']);
                e_amount1.val(data['salary']);
            }else if(mode==='2'){
                e_rate_class.val(data['rate_id'])
                e_amount2.val(data['salary'])
            }else if(mode==='3'){
                e_amount3.val(data['salary'])
            }
            e_emp_class.val(data['classification']);
            empclass_toshow();
        },
        error:function (e){
            console.log(e)
        }
    });
});

$('body').on('click','.opencontribution',function (e){
    let id=$(this).data('id');
    $('#emp_id').val(id);
    $('#cont_emp_id').val(id);
    $('#contribution_amount').val('');
    load_contribution();
});
$('body').on('click','.openedit_con',function (e){
    let id=$(this).data('id');
    $('#emp_id').val(id);
    $('#cont_emp_id').val(id);
    $('#contribution_amount').val('');
    load_contribution();
});


$('body').on('click','.openincentive',function (e){
    let id=$(this).data('id');
    $('#inc_emp_id').val(id);
    $('#incentive_amount').val('');
    load_incentive();
});
$('body').on('click','.openedit_inc',function (e){
    let id=$(this).data('id');
    $('#emp_id').val(id);
    $('#inc_emp_id').val(id);
    $('#incentive_amount').val('');
    load_incentive();
});

$('body').on('click','.addnewdeduction',function (e){
    deduction_action='Add';
    let id=$(this).data('id');
    $('#modal_ded_emp_id').val(id);
});
$('body').on('click','.add_deduction',function (e){
    console.log(deduction_action)
    let employee_id=$('#modal_ded_emp_id').val();

    let deduction_id = $('#deduction_select').val();


    if(deduction_action==="Add"){
        $.ajax({
            url:"/payroll/setup/deduction/insert",
            datatype:'JSON',
            method:'POST',
            data:{
                employee_id,
                deduction_id
            },
            success:function (res){
                const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector("#set_deduction"));
                mdl.hide();
                __notif_show(1, 'Success', 'Deduction Rate Was Saved Successfully!');
                load_setup();

            },error:function (err){
                console.log(err)
            }
        });
    }else if(deduction_action==="Edit"){
        $.ajax({
            url:"/payroll/setup/deduction/update",
            datatype:'JSON',
            method:'POST',
            data:{
                employee_id,
                deduction_id
            },
            success:function (res){
                const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector("#set_deduction"));
                mdl.hide();
                __notif_show(1, 'Success', 'Deduction Rate Was Updated Successfully!');
                load_setup();

            },error:function (err){
            }
        });
    }



});
$('body').on('click','.openedit_ded',function (e){
    deduction_action='Edit';
    let id=$(this).data('id');
    $('#modal_ded_emp_id').val(id);

    var deduction_select = $('#deduction_select');
    var deduction_amount = $('#deduction_amount');

    $.ajax({
        url: bpath + 'payroll/setup/getdeduction',
        type: "POST",
        data: {
            'id':id,
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data) {
            var data = JSON.parse(data);
            deduction_select.val(data['deduction_details']['id'])
            deduction_amount.val(data['deduction_details']['amount'])
        },
        error:function (e){
            console.log(e)
        }
    });

});

$('.confirm_contribution_delete').click(function (){
        $.ajax({
            url:"setup/contribution/delete",
            method:'post',
            data:{id:ded_id},
            success:function (res){
                const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector("#emp_contribution_confirm"));
                mdl.hide();
                load_contribution();
                __notif_show(1, 'Success', 'Contribution Was Removed Successfully!');
                load_setup();
            },error:function (err){
                console.log(err)
            }
        });
    })
$('.confirm_incentive_delete').click(function (){
    $.ajax({
        url:"setup/incentive/delete",
        method:'post',
        data:{id:incentive_id},
        success:function (res){
            const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector("#emp_incentive_confirm"));
            mdl.hide();
            load_incentive();
            __notif_show(1, 'Success', 'Incentive Was Removed Successfully!');
            load_setup();
        },error:function (err){
            console.log(err)
        }
    });
})
$('.confirm_loan_delete').click(function (){
    $.ajax({
        url:"setup/loan/delete",
        method:'post',
        data:{id:loan_id},
        success:function (res){
            const mdl = tailwind.Modal.getOrCreateInstance(document.querySelector("#emp_loan_confirm"));
            mdl.hide();
            load_loan();
            __notif_show(1, 'Success', 'Loan Was Removed Successfully!');
            load_setup();
        },error:function (err){
            console.log(err)
        }
    });
})

$("#emp_class").change(function(){
    empclass_toshow();
});

$("#rate_class").click(function(){
   let id =$(this).val();
   var theElement = $('#amount2');

    $.ajax({
        url: bpath + 'payroll/setup/getrate_amount',
        type: "POST",
        data: {
            'id':id,
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data) {
            var data = JSON.parse(data);
            $(theElement).val(data['amount']);
        },
        error:function (e){
            $(theElement).val('');
        }
    });

});

$("#deduction_select").click(function(){
    let id =$(this).val();
    var theElement = $('#deduction_amount');

    $.ajax({
        url: bpath + 'payroll/setup/getdeduction_amount',
        type: "POST",
        data: {
            'id':id,
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data) {
            var data = JSON.parse(data);
            $(theElement).val(data['amount']);
        },
        error:function (e){
            $(theElement).val('');
        }
    });

});

$('#set_salary').on( 'keyup', '#sg', function () {
    loadsalary_sg();
});

$('#set_salary').on( 'keyup', '#step', function () {
    loadsalary_sg();
});


$('#dt_emp_contribution').on('click', '.contribution_open_delete', function() {
    let id=$(this).data('id');
    ded_id=id;
});

$('#dt_emp_incentives').on('click', '.incentive_open_delete', function() {
    let id=$(this).data('id');
    incentive_id=id;
});

$('#dt_emp_loan').on('click', '.loan_open_delete', function() {
    let id=$(this).data('id');
    loan_id=id;
});

$('#set_incentive').on('click', '#add_new_incentive', function() {
    let id=$('#incentive_id').val();
    let amount =$('#incentive_amount').val();
    let employee_id=$('#inc_emp_id').val();

    if(amount>0){
        $.ajax({
            url:"setup/incentive/insert",
            method:'post',
            data:{incentive_id:id,amount:amount,employee_id:employee_id},
            success:function (res){
                 load_incentive();
                __notif_show(1, 'Success', 'Incentive Was Added Successfully!');
                load_setup();
                $('#incentive_amount').val('');
            },error:function (err){
                console.log(err)
                $('#incentive_amount').val('');
            }
        });
    }
});

$('#set_contribution').on('click', '#add_new_contribution', function() {
   let id=$('#contribution_id').val();
   let amount =$('#contribution_amount').val();
   let employee_id=$('#cont_emp_id').val();

   if(amount>0){
       $.ajax({
           url:"setup/contribution/insert",
           method:'post',
           data:{contribution_id:id,amount:amount,employee_id:employee_id},
           success:function (res){
               load_contribution();
               __notif_show(1, 'Success', 'Contribution Was Added Successfully!');
               load_setup();
               $('#contribution_amount').val('');
           },error:function (err){
               console.log(err)
               $('#contribution_amount').val('');
           }
       });
   }
});

$('#set_loan').on('click', '#add_new_loan', function() {
    let id=$('#loan_id').val();
    let amount =$('#loan_amount').val();
    let employee_id=$('#loan_emp_id').val();

    if(amount>0){
        $.ajax({
            url:"setup/loan/insert",
            method:'post',
            data:{loan_id:id,amount:amount,employee_id:employee_id},
            success:function (res){
                load_loan();
                __notif_show(1, 'Success', 'Loan Was Added Successfully!');
                load_setup();
                $('#loan_amount').val('');
            },error:function (err){
                console.log(err)
                $('#loan_amount').val('');
            }
        });
    }
});

function loadsalary_sg(){
    var step_id = $('#step').val();
    var tranch_id = $('#sg').val();
    var theElement = $('#amount1');

    $.ajax({
        url: bpath + 'payroll/setup/getsalary',
        type: "POST",
        data: {
            'sg':tranch_id,
            'step':step_id,
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data) {
            var data = JSON.parse(data);
            $(theElement).val(data['amount']);
        },
        error:function (e){
            $(theElement).val('');
        }
    });
}

function clear_salary(){
    $(".Div1").show();
    $(".Div2").hide();
    $(".Div3").hide();

    $('#sg').val('');
    $('#step').val('');

    $('#emp_class').val(1);

    $('#amount1').val('');
    $('#amount2').val('');
    $('#amount3').val('');

}

function empclass_toshow(){
    let choice =$('#emp_class').val();
    if (choice==='1'){

        $(".Div1").show();
        $(".Div2").hide();
        $(".Div3").hide();
    }else if(choice==='2'){
        $(".Div1").hide();
        $(".Div2").show();
        $(".Div3").hide();
    }
    else if(choice==='3'){
        $(".Div1").hide();
        $(".Div2").hide();
        $(".Div3").show();
    }
}
