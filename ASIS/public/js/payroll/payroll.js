$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {

    bpath = __basepath + "/";

    load_datatable();
    load_payroll();

    load_dt_emp();
    load_details();

    load_dt_emp_select();
    load_emp_select();
});


var  _token = $('meta[name="csrf-token"]').attr('content');
var tbldata;

var search_emp_tbldata;
var emp_tbldata;


$('#dt__emp_list').on('click', '#add_emp', function (e) {
    e.preventDefault();


    var id=$(this).data('id');

    var theElement = $(this);

    let result = check_if_exist(id);

    if(result===false){
        var table = $('#dt__emp_list').DataTable();
        var row = $(this).parents('tr');

        if ($(row).hasClass('child')) {
            table.row($(row).prev('tr')).remove().draw();
        } else {
            table
                .row($(this).parents('tr'))
                .remove()
                .draw();
        }
        $.ajax({
            url: bpath + 'payroll/payroll/getsalary',
            type: "POST",
            data: {
                'agency_id':id,
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(data) {
                var data = JSON.parse(data);

                var cd = "";
                /***/

                if(data[0]['classification']==='2'){
                    cd = '' +
                        '<div class="input-group">\n' +
                        '<input id="pr_hrs" type="text" class="form-control min-w-[6rem] text-right" value="1" >\n' +
                        '</div>'+
                        '';
                }


                addrow(data[0]['agencyid'],data[0]['name'],cd,data[0]['salary'],data[0]['incentive'],data[0]['deduction'],data[0]['loan']);
                calculate_net()
                __notif_show(1, 'Success', 'Employee was successfully added!');
                load_details();
            },
            error:function (e){

            }
        });
    }else{
        __notif_show(-1, 'Warning', 'Employee was already added!');
    }
    load_details();
});

$('#dt_pr_emp').on( 'keyup', '.emp_step', function () {

    // var step_id = $(this).closest('tr').find('.emp_step').val();
    // var tranch_id = $(this).closest('tr').find('.emp_sg').val();
    //
    // $.ajax({
    //     url: bpath + 'payroll/payroll/getsalary',
    //     type: "POST",
    //     data: {
    //         'sg':tranch_id,
    //         'step':step_id,
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    //     },
    //     success: function(data) {
    //
    //         var data = JSON.parse(data);
    //         console.log(data);
    //
    //         $(this).closest('tr').find('.emp_salary').val(data['amount']);
    //         console.log('sleep');
    //     },
    //     error:function (e){
    //
    //     }
    //
    // });







    // var step_id = $(this).closest('tr').find('.emp_step').val();
    // var tranch_id = $(this).closest('tr').find('.emp_sg').val();
    // var selector = $(this).closest('tr').find('.emp_salary').val();
    // var theElement = $(this);
    //
    // $.ajax({
    //     url: bpath + 'payroll/payroll/getsalary',
    //     type: "POST",
    //     data: {
    //         'agency_id':tranch_id,
    //         'step':step_id,
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    //     },
    //     success: function(data) {
    //         var data = JSON.parse(data);
    //         $(theElement).closest('tr').find('td .emp_salary').val(data['amount']);
    //
    //     },
    //     error:function (e){
    //         $(theElement).closest('tr').find('td .emp_salary').val('');
    //     }
    // });
    // $(this).closest('tr').find('td .emp_salary').val('');

} );

$('#dt_pr_emp').on('click', '.emp_delete', function() {

    //remove column
    var table = $('#dt_pr_emp').DataTable();
    var row = $(this).parents('tr');

    if ($(row).hasClass('child')) {
        table.row($(row).prev('tr')).remove().draw();
        __notif_show(1, 'Success', 'Employee was successfully removed!');
    } else {
        table
            .row($(this).parents('tr'))
            .remove()
            .draw();
        __notif_show(1, 'Success', 'Employee was successfully removed!');
    }
    load_details();
});

function check_if_exist (n){
    var result=false;
    var table = $('#dt_pr_emp').DataTable();
    table.rows().every( function ( rowIdx ) {
        var firstVal = $( this.node() ).first().find('#emp_id').text();
        if (n == firstVal){
            result=true;
            return result;
        } else {
            result=false;
            return result;
        }
    } );
    return result;
}
function load_datatable() {

    try{
        /***/
        tbldata = $('#dt_payroll').DataTable({
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
function load_payroll() {

    $.ajax({
        url: bpath + 'payroll/payroll/load',
        type: "POST",
        data: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data) {
            tbldata.clear().draw();
            /***/

            var data = JSON.parse(data);
            if(data.length > 0) {
                for(var i=0;i<data.length;i++) {

                    /***/
                    var id = data[i]['id'];
                    var group_name = data[i]['group_name'];
                    var date_desc = data[i]['date_desc'];
                    var date_month = data[i]['date_month'];
                    var date_year = data[i]['date_year'];
                    var employee = data[i]['employee'];
                    var processed_by = data[i]['processed_by'];
                    var status = data[i]['status'];


                    var cd = "";

                    /***/
                    cd = '' +
                        '<tr>' +

                        '<td class="hidden">' +
                        id+
                        '</td>' +

                        '<td>' +
                        group_name+
                        '</td>' +


                        '<td>' +
                        date_desc+
                        '</td>' +


                        '<td>' +
                        date_month+
                        '</td>' +

                        '<td>' +
                        date_year+
                        '</td>' +

                        '<td>' +
                        employee+
                        '</td>' +

                        '<td>' +
                        processed_by+
                        '</td>' +

                        '<td>' +
                        status+
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
                    tbldata.row.add($(cd)).draw();
                    /***/
                }
            }
        }
    });
}

function load_dt_emp(){
    try{
        /***/
        emp_tbldata = $('#dt_pr_emp').DataTable({
            dom:
                'lrt',
            renderer: 'bootstrap',
            "info": false,
            "bFilter":false,
            "bInfo":false,
            "bJQueryUI": true,
            "bProcessing": true,
            "bPaginate" : false,
            "aLengthMenu": [[10,25,50,100,150,200,250,300,-1], [10,25,50,100,150,200,250,300,"All"]],
            "iDisplayLength": 10,
            "aaSorting": [],
            "ordering":false
        });
        /***/
    }catch(err){  }
}
function load_emp() {

    $.ajax({
        url: bpath + 'payroll/payroll/loademp',
        type: "POST",
        data: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data) {
            emp_tbldata.clear().draw();
            /***/

            var data = JSON.parse(data);
            if(data.length > 0) {
                for(var i=0;i<data.length;i++) {

                    /***/
                    var id = data[i]['id'];
                    var name = data[i]['name'];
                    var salary = data[i]['salary'];



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


                        '<td>' +
                        salary+
                        '</td>' +


                        '<td>' +
                        '</td>' +

                        '<td>' +
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
                    emp_tbldata.row.add($(cd)).draw();
                    /***/
                }
            }
        }
    });
}

function load_dt_emp_select(){
    try{
        /***/
        search_emp_tbldata = $('#dt__emp_list').DataTable({
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
            "aLengthMenu": [[5,10,25,50,100,150,200,250,300,-1], [5,10,25,50,100,150,200,250,300,"All"]],
            "iDisplayLength": 5,
            "aaSorting": [],
        });
        /***/
    }catch(err){  }
}
function load_emp_select() {

    $.ajax({
        url: bpath + 'payroll/payroll/loademp_select',
        type: "POST",
        data: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data) {
            search_emp_tbldata.clear().draw();
            /***/

            var data = JSON.parse(data);
            if(data.length > 0) {
                for(var i=0;i<data.length;i++) {

                    /***/
                    var user_id = data[i]['user_id'];
                    var name = data[i]['name'];



                    var cd = "";

                    /***/
                    cd = '' +
                        '<tr>' +

                        '<td class="hidden">' +
                        user_id+
                        '</td>' +

                        '<td>' +
                        name+
                        '</td>' +


                        '<td class="table-report__action w-20">\n' +
                        '<div class="flex justify-center items-center align-items-center ">\n' +
                        '<button  href="javascript:;" data-id="'+user_id+'" data-name="'+name+'"' +
                        'class="btn btn-primary add_emp" id="add_emp"><i class="fa-solid fa-plus"></i></button>'+
                        '</>\n' +
                        '</td>'+


                        '</tr>' +
                        '';
                    search_emp_tbldata.row.add($(cd)).draw();
                    /***/
                }
            }
        }
    });
}

function load_details(){

    var table = $('#dt_pr_emp').DataTable();
    let empcounter = table.rows().count();
    var total_salary = 0.00;
    var total_incentive = 0.00;
    var total_deduction = 0.00;
    var total_loan = 0.00;
    var total_contribution = 0.00;

    table.rows().every( function ( rowIdx ) {
        var employee_id = $( this.node() ).first().find('#emp_id').text();
        var salary = $( this.node() ).first().find('#pr_salary').val();
        var incentive = $( this.node() ).first().find('#pr_incentive').val();
        var deduction = $( this.node() ).first().find('#pr_deduction').val();
        var loan = $( this.node() ).first().find('#pr_loan').val();

        salary=salary.replace(',','')
        total_salary += parseFloat(salary);

        incentive=incentive.replace(',','')
        total_incentive += parseFloat(incentive);

        deduction=deduction.replace(',','')
        total_deduction += parseFloat(deduction);

        loan=loan.replace(',','')
        total_loan += parseFloat(loan);

        total_contribution = total_deduction+total_loan;

    } );

    $('#total_emp_count').text(String(empcounter));

    const formatted = total_salary.toLocaleString('en-US');
    $('#total_salary_amount').text(String(formatted));

    const formatted_incentive = total_incentive.toLocaleString('en-US');
    $('#total_incentive_amount').text(String(formatted_incentive));

    const formatted_contribution = total_contribution.toLocaleString('en-US');
    $('#total_contribution_amount').text(String(formatted_contribution));
}

function addrow($id,$name,$hrs,$salary,$incentive,$deduction,$loan){
    var cd = "";
    /***/
    cd = '' +
        '<tr>' +

        '<td class="">' +
        '<a id="emp_id">'+$id+'</a>'+
        '</td>' +

        '<td class="whitespace-nowrap">' +
        $name+
        '</td>' +

        '<td class="whitespace-nowrap">' +

        '</td>' +

        '<td class="whitespace-nowrap">' +
        $hrs+
        '</td>' +


        '<td class="!px-2">' +
        '<div class="input-group">\n' +
        '<div class="input-group-text">₱</div>\n' +
        '<input id="pr_salary" type="text" class="form-control min-w-[6rem] text-right" value="'+ $salary +'" disabled>\n' +
        '</div>'+
        '</td>' +

        '<td class="!px-2">' +
        '<div class="input-group">\n' +
        '<div class="input-group-text">₱</div>\n' +
        '<input id="pr_incentive" type="text" class="form-control min-w-[6rem] text-right" value="'+ $incentive +'" disabled>\n' +
        '</div>'+
        '</td>' +

        '<td class="!px-2">' +
        '<div class="input-group">\n' +
        '<div class="input-group-text">₱</div>\n' +
        '<input id="pr_deduction" type="text" class="form-control min-w-[6rem] text-right" value="'+ $deduction +'" disabled>\n' +
        '</div>'+
        '</td>' +

        '<td class="!px-2">' +
        '<div class="input-group">\n' +
        '<div class="input-group-text">₱</div>\n' +
        '<input id="pr_loan" type="text" class="form-control min-w-[6rem] text-right" value="'+ $loan +'" disabled>\n' +
        '</div>'+
        '</td>' +


        '<td class="!px-2">' +
        '<div class="input-group">\n' +
        '<div class="input-group-text">₱</div>\n' +
        '<input id="pr_tax" type="text" class="form-control min-w-[6rem] text-right" value="0">\n' +
        '</div>'+
        '</td>' +

        '<td class="!px-2">' +
        '<div class="input-group">\n' +
        '<div class="input-group-text">₱</div>\n' +
        '<input id="pr_net" type="text" class="form-control min-w-[6rem] text-right">\n' +
        '</div>'+
        '</td>' +

        '<td class="!pl-4 text-slate-500">' +
        '<a href="javascript:;"> <i class="fa-regular fa-trash-can w-4 h-4 emp_delete"></i> </a>'+
        '</td>' +


        '</tr>' +
        '';
        emp_tbldata.row.add($(cd)).draw(false);
}

$("#reload_emp").click(function(){
    load_emp_select();
});


format = function date2str(x, y) {
    var z = {
        M: x.getMonth() + 1,
        d: x.getDate(),
        h: x.getHours(),
        m: x.getMinutes(),
        s: x.getSeconds()
    };
    y = y.replace(/(M+|d+|h+|m+|s+)/g, function(v) {
        return ((v.length > 1 ? "0" : "") + z[v.slice(-1)]).slice(-2)
    });

    return y.replace(/(y+)/g, function(v) {
        return x.getFullYear().toString().slice(-v.length)
    });
}

$("#save_pr").click(function (){

    let group_name=$('#pr_groupname').val();
    let date_desc =$('#pr_date_desc').val();
    let date_month=$('#pr_date_month').val();
    let date_year=$('#pr_date_year').val();


    var dates =$('#pr_date_days').val().split('-')

    let date_0=dates[0];
    let date_1=dates[1];

    let date_from= format(new Date(date_0), 'yyyy-MM-dd')
    let date_to= format(new Date(date_1), 'yyyy-MM-dd')



    $.ajax({
            url:"/payroll/payroll/save",
            method:'post',
            data:{group_name,date_desc,date_month,date_year,date_from,date_to},
            success:function (id){
                savesalary(id)
                __notif_show(1, 'Success', 'Payroll was successfully created!');
            },error:function (err){
                console.log(err)
            }
        });
});

function savesalary(payroll_id){
    // foreach employee

    var table = $('#dt_pr_emp').DataTable();
    table.rows().every( function ( rowIdx ) {
        var employee_id = $( this.node() ).first().find('#emp_id').text();
        var salary = $( this.node() ).first().find('#pr_salary').val();
        var net_salary = $( this.node() ).first().find('#pr_net').val();
        var tax = $( this.node() ).first().find('#pr_tax').val();
        salary=salary.replace(',', '')
        tax=tax.replace(',', '')

        $.ajax({
            url:"/payroll/payroll/details/save",
            method:'post',
            data:{employee_id,salary,payroll_id,net_salary},
            success:function (res){
            },error:function (err){
            }
        });

        $.ajax({
            url:"/payroll/payroll/tax/save",
            method:'post',
            data:{employee_id,tax,payroll_id},
            success:function (res){

            },error:function (err){

            }
        });
    } );
    window.location.replace("/payroll/payroll");
}

$('#dt_pr_emp').on( 'keyup', '#pr_hrs', function () {

    var id = $(this).closest('tr').find('#emp_id').text();
    var hours = $(this).closest('tr').find('#pr_hrs').val();
    var theElement = $(this);

    $.ajax({
        url: bpath + 'payroll/payroll/getsalary/hourly',
        type: "POST",
        data: {
            id,
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(data) {
            var data = JSON.parse(data);
            var salary = data['salary'];
            var totalsalary = salary * hours;
            totalsalary=parseFloat(totalsalary).toFixed(2);
            const formatted_totalsalary = totalsalary.toLocaleString('en-US');
            $(theElement).closest('tr').find('td #pr_salary').val(formatted_totalsalary);
            load_details();
            calculate_net();
        },
        error:function (e){

        }
    });

} );

$('#dt_pr_emp').on( 'keyup', '#pr_tax', function () {
    var step_id = $(this).closest('tr').find('#emp_id').text();

    var salary=$(this).closest('tr').find('#pr_salary').val();
    salary=salary.replace(',', '')

    var incentive=$(this).closest('tr').find('#pr_incentive').val();
    incentive=incentive.replace(',', '')

    var deduction=$(this).closest('tr').find('#pr_deduction').val();
    deduction=deduction.replace(',', '')

    var loan=$(this).closest('tr').find('#pr_loan').val();
    loan=loan.replace(',', '')

    var tax=$(this).closest('tr').find('#pr_tax').val();
    tax=tax.replace(',', '')

    var net = 0;
    net+=parseFloat(salary)
    net+=parseFloat(incentive)
    net-=parseFloat(deduction)
    net-=parseFloat(loan)
    net-=parseFloat(tax)
    $(this).closest('tr').find('#pr_net').val(net);

} );

function calculate_net(){
    var salary=$('#dt_pr_emp tr').last().find('#pr_salary').val();
    salary=salary.replace(',', '')

    var incentive=$('#dt_pr_emp tr').last().find('#pr_incentive').val();
    incentive=incentive.replace(',', '')

    var deduction=$('#dt_pr_emp tr').last().find('#pr_deduction').val();
    deduction=deduction.replace(',', '')

    var loan=$('#dt_pr_emp tr').last().find('#pr_loan').val();
    loan=loan.replace(',', '')

    var tax=$('#dt_pr_emp tr').last().find('#pr_tax').val();
    tax=tax.replace(',', '')

    var net = 0;
    net+=parseFloat(salary)
    net+=parseFloat(incentive)
    net-=parseFloat(deduction)
    net-=parseFloat(loan)
    net-=parseFloat(tax)
    $('#dt_pr_emp tr').last().find('#pr_net').val(net)
}



