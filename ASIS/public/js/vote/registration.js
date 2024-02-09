var  _token = $('meta[name="csrf-token"]').attr('content');


var electType_select;

$(document).ready(function () {
    submit_fuction();
});

function submit_fuction(){
    $('#electionRegistration_form').submit(function (e) {
        e.preventDefault();
        if (check_input()) {
            alert('Let this be saved');

        }
    });
}

function check_input(){


    var electionName = $('#electionName');
    var electionDescription = $('#electionDescription');

    var electionNameError = $('.electionNameError');
    var electionDescriptionError = $('.electionDescriptionError');


    if (electionName.val() == '' && electionDescription.val() == '') {
        electionNameError.removeClass('hidden');
        electionDescriptionError.removeClass('hidden');

        electionName.css('border-color', 'red');
        electionDescription.css('border-color', 'red');

        return false;
    }else{

        if(electionDescription.val() === ''){

            electionNameError.addClass('hidden');
            electionDescriptionError.removeClass('hidden');

            electionName.css('border-color', '');
            electionDescription.css('border-color', 'red');

            return false;
        }else if(electionName.val() == ''){

            electionNameError.removeClass('hidden');
            electionDescriptionError.addClass('hidden');

            electionName.css('border-color', 'red');
            electionDescription.css('border-color', '');

        }else{

            electionNameError.addClass('hidden');
            electionDescriptionError.addClass('hidden');

            electionName.css('border-color', '');
            electionDescription.css('border-color', '');

            var intended = $("input[name='intended_to']:checked");
            if (intended.length > 0) {

                $('.intended_toError').addClass('hidden');

                if(intended.val() === 'all'){
                    return true;
                }else{
                    return false;
                }

            }else{
                $('.intended_toError').removeClass('hidden');

                return false;
            }



        }



    }


}
