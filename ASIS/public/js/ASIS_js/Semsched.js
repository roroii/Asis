var _token = $('meta[name="csrf-token"]').attr('content');
var sem_dt;

$(document).ready(function(){

    bpath = __basepath + "/";

    load_semSched_dt();
    load_select2();
    get_program();
});


//** ========= **/
//initialize the data table
function load_semSched_dt()
{
    try{
		/***/
        sem_dt = $('#semestral_sched_dt').DataTable({
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
            //         { className: "dt-head-center", targets: [] },
            //     ],
		});
	}catch(err){
        console.log(err);
     }
}

//** ========= **/
//initialize the select 2
function load_select2()
{
    $('#department_name').select2({
        placeholder: "Select department",
        closeOnSelect: true,
    });

    $('#program_desc').select2({
        placeholder: "Select list of program",
        closeOnSelect: true,
    });

    $('#sem').select2({
        placeholder: "Select Semester",
        closeOnSelect: true,
    });

    $('#sc-y').select2({
        placeholder: "Select School-Year",
        closeOnSelect: true,
    });
}

//** ========= **/
//load the college program depending on the department
function get_college_program(progdept)
{
    let cd = '';
    $("#program_desc").empty();
    $.ajax({
        url: bpath + 'sem/get/college/program',
        type: 'POST',
        data: {_token,progdept},

        success:function(response)
        {
            if(response!='')
            {
                let data = JSON.parse(response);

                if(data.length > 0)
                {
                    for(x=0;x<data.length;x++)
                    {
                        let oid = data[x][x]['oid'],
                            desc = data[x][x]['desc'];

                        cd = '' + '<option value="'+oid+'">'+ desc+'</option>'+'';
                        console.log('id:' +oid, 'desc:'+desc + 'hayahay');
                        $("#program_desc").append(cd);
                    };


                }
            }
        },
        error: function(xhr, status, error) {
        console.log("Error in ajax: " + status + "\nError: " + error + "\nError detail: " + xhr.responseText);}
    });
}

//** ========= **/
//event click event of the department
function get_program()
{
    $("#department_name").on('select2:select',function(){
        let val = $(this).val();
        get_college_program(val)
    });
}
