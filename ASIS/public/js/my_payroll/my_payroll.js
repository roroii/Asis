
var  _token = $('meta[name="csrf-token"]').attr('content');

$(document).ready(function () {

    fetch_MyParollDetail();
    // alert('hahaha lkokak')
    // _thisSelect();
    // onChange_function();
    // fetched_Applicant_summary();
    // _onClick_function();

});
function fetch_MyParollDetail(){
    $.ajax({
        url: '/my-payroll/fetch-mypayroll-detail',
        type: "get",
        data: {
            _token: _token,
        },
        success: function(data) {

            // $('#summary_div').html(data);
            // $('#tbl_summary').DataTable();

        }
    });
}
