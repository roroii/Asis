var _tokenized =   $('meta[name="csrf-token"]').attr('content');
var filter_size = {globalFilterSize:''},keyword = {globalSearchWord:''}
var payment = {globalPayment:''};
var assessment = {globalAssessment:''};

$(document).ready(function(){

    bpath = __basepath + "/";
    getStudentInfo();
    displayStudentLEdger(filter_size.globalFilterSize,keyword.globalSearchWord);
    searchSubsidiaryLedger();
    getDisplaySize();
    showDetails();

});


/*filter the size of display*/
function getDisplaySize()
{
    $("#filter_size").on("change",function(){
        filter_size.globalFilterSize = $(this).val();
        displayStudentLEdger(filter_size.globalFilterSize);
    });
}


/*Perform a search function in */
function searchSubsidiaryLedger()
{
    $("#search_input").on('keydown',function(event){

        if(event.which === 13)
        {
            keyword.globalSearchWord = $(this).val();
            displayStudentLEdger(filter_size.globalFilterSize,keyword.globalSearchWord);
        }
    });
}


/*isplay the student ledger*/
function displayStudentLEdger(filterSize,search)
{
    $.ajax({
        type: "GET",
        url: bpath + "student_ledger/my/subsidiary/ledger",
        data: {_tokenized,filterSize,search},

        success:function(response)
        {
            $("#tb_ledger").empty();

            if(response!==null && response!=='')
            {
                let data = JSON.parse(response);
                console.log(data);
                if(data.length > 0)
                {
                    for(let x=0;x<data.length;x++)
                    {
                        const orig_sem = data[x]["orig_sem"],
                              schYear = data[x]["schYear"],
                              sem = data[x]["sem"],
                              total_amt = data[x]["total_amt"];

                              const cd = `
                              <tr id="student_fee_details" class="inbox inbox__item inbox__item--active bg-slate-100 dark:bg-darkmode-400/70 border-b border-slate-200/60 dark:border-darkmode-400 intro-x" data-sy="${schYear}" data-sem="${orig_sem}">
                                  <td class="px-5 py-3 text-center">
                                      <div class="w-72 flex-none flex items-center mr-5">
                                          <div class="inbox__item--sender truncate ml-10">${
                                              schYear
                                          }</div>
                                      </div>
                                  </td>
                                  <td class="w-64 sm:w-auto max-w-xs sm:max-w-none truncate-cell text-center"> <!-- Add text-center class here -->
                                      <div class="truncate">
                                          <span class="inbox__item--highlight">${
                                              sem
                                          }</span>
                                      </div>
                                  </td>
                                  <td class="inbox__item--time whitespace-nowrap pl-10 text-center"> <!-- Add text-center class here -->
                                      <strong>${total_amt}</strong>
                                  </td>
                              </tr>

                              <tr class="inbox__item--time whitespace-nowrap pl-10 child_info" hidden>
                                    <td colspan="2">
                                          <div class="text-center font-semibold mt-4">
                                              ASSESSMENT
                                          </div>
                                          <div class="overflow-x-auto mt-2 mb-4">
                                                <table class="table mb-4" >
                                                    <thead>
                                                        <tr>
                                                            <th class="whitespace-nowrap">Code</th>
                                                            <th class="whitespace-nowrap">Particuliars</th>
                                                            <th class="whitespace-nowrap">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="child_details" class="child_details">
                                                    </tbody>
                                                </table>
                                                <div class="font-semibold mt-4" style="margin-left:20px">
                                                        Total Assessment:
                                                    <span id="total_amount"class="total_amount" style="margin-left:235px">
                                                         Assessment:
                                                    </span>
                                                </div>
                                                <div class="font-semibold mt-4" style="margin-left:20px">
                                                        OLD Accounts:
                                                    <span id="old_account" class="old_account" style="margin-left:260px">
                                                            0.00
                                                    </span>
                                                </div>
                                                <div class="font-semibold mt-4" style="margin-left:20px">
                                                    Payment:
                                                    <span id="total_pay" class="total_pay" style="margin-left:290px">
                                                         pay
                                                    </span>
                                                </div>
                                                <div class="font-semibold mt-6" style="margin-left:20px">
                                                    Total Balance:
                                                    <span id="student_balance" class="text-pending student_balance" style="margin-left:260px">
                                                         Balance
                                                    </span>
                                                </div>
                                          </div>
                                    </td>
                                    <td class="w-64 sm:w-auto max-w-xs sm:max-w-none truncate-cell" style="vertical-align: top;">
                                        <div class="text-center font-semibold mt-4">
                                            PAYMENT
                                        </div>
                                        <div class="overflow-x-auto mt-2 mb-4">
                                            <table class="table w-full">
                                                <thead>
                                                    <tr>
                                                        <th class="whitespace-nowrap">OR#</th>
                                                        <th class="whitespace-nowrap">Fee Description</th>
                                                        <th class="whitespace-nowrap">Date</th>
                                                        <th class="whitespace-nowrap">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="student_payment" class="student_payment">
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="font-semibold" style="margin-left:20px">
                                            Total Paid Amount:
                                            <span id="paid_amount" class="paid_amount text-success" style="margin-left:360px">
                                            </span>
                                        </div>
                                    </td>
                              </tr>
                              `;

                        $("#tb_ledger").append(cd);
                    }
                }
                else
                {
                        let cd =` <tr id="student_fee_details" class="inbox inbox__item inbox__item--active bg-slate-100 dark:bg-darkmode-400/70 border-b border-slate-200/60 dark:border-darkmode-400">
                                    <td colspan="3" class="text-center font-semibold">
                                       <span class="mr-2 text-pending"><i class="fa-solid fa-magnifying-glass fa-bounce fa-lg"></i></span> No data found !
                                    </td>
                                </tr>`;

                            $("#tb_ledger").append(cd);
                }
            }

        }

    });
}


/*get the insformation of the student*/
function getStudentInfo()
{
    $.ajax({
        type: "GET",
        url: bpath+ "student_ledger/display/user/info",
        data:{_tokenized},
        dataType: "json",

        success: function(response){
            console.log(response.logo);
            if(response!==null || response!=='')
            {
                $("#student_fullname").text(response.fullname);
                $("#course").text(response.program_desc);
                $("#studentId").text(response.studid);
                $("#student_section").text(response.section);
                $("#year_lvl").text(response.year);
                $("#student_pic").attr("src",response.logo);
            }
        }
    });
}

/*show the fee details of the student when clicking the child info*/
function showDetails()
{
    $("body").on("click", "#student_fee_details", function () {
        let sy = $(this).data("sy"),
            sem = $(this).data("sem");

        let clickedRowVisible = $(this).next('.child_info');

        // Iterate through all .child_info elements
        $('.child_info').each(function () {
            if ($(this).is(':visible') && !$(this).is(clickedRowVisible)) {
                $(this).hide();
            }
        });

        if (clickedRowVisible.is(':visible')) {
            clickedRowVisible.hide();
        } else {
            clickedRowVisible.show();
            getStudentAssessment(sy, sem);
            getStudentPayment(sy, sem);
        }
    });

}

/*Appnend the data of the Student ledger*/
function getStudentAssessment(sy, sem)
{
    $(".child_details").empty();

    $.ajax({
        type: "POST",
        url: bpath + "student_ledger/my/subsidiary/ledger/details",
        data:{_token,sy,sem},

        success:function(response){

            if(response!=='' || response!==null)
            {
                let data = JSON.parse(response);

                    if(data.length > 0)
                    {
                        for(let x=0;x<data.length;x++)
                        {
                            let feecode = data[x]["feecode"],
                                particuliars = data[x]["particuliars"],
                                amount = data[x]["amount"],
                                total = data[x]["total"],
                                balance = data[x]["balance"];

                            const cd = `<tr>
                                            <td>${feecode} </td>
                                            <td><em>${particuliars}</em></td>
                                            <td>${amount} </td>
                                        </tr>`;

                            $(".total_amount").text(total);
                            $(".student_balance").text(balance);
                            $(".child_details").append(cd);
                        }
                    }
                else
                {
                    let cd = `<tr>
                                    <td colspan="3" class="text-center">No Assessment data detected</td>
                                </tr>`;

                        $(".total_amount").text('0.00');
                        $(".student_balance").text('0.00');
                        $(".child_details").append(cd);
                }
            }
        }
    });
}

/*get the student payment*/
function getStudentPayment(sy,sem)
{
    $(".student_payment").empty();
    $.ajax({
        type: "POST",
        url: bpath + "student_ledger/my/payment",
        data: {_token,sy,sem},

        success:function(response)
        {
            if(response !== '' && response !== null)
            {
                let data = JSON.parse(response);
                if(data!== null)
                {
                    if(data.length > 0 )
                    {
                        for(let x=0;x<data.length;x++)
                        {
                            let orno = data[x]["orno"],
                                feecode = data[x]["feecode"],
                                date = data[x]["date"],
                                amt = data[x]["amt"],
                                total_pay = data[x]["total_pay"];

                            const cd = `<tr>
                                <td> ${orno}</td>
                                <td><em>${feecode}<em></td>
                                <td>${date}</td>
                                <td>${amt} </td>
                                </tr>`;

                            $(".student_payment").append(cd);
                            $(".total_pay").text(total_pay);
                            $(".paid_amount").text(total_pay);
                        }
                    }
                }
                else
                {
                    let cd = `<tr class="text-center">
                        <td colspan='4'>
                            No payment is avaliable
                        </td>
                    </tr>`;

                    $(".student_payment").append(cd);
                    $(".total_pay").text('0.00');
                    $(".paid_amount").text('0.00');
                }

            }
        }

    });
}
