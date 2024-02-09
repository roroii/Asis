function bind_address(){

    $('.ref_province').on('select2:select', function (e) {

        let provCode = $(this).val();

        $.ajax({
            url: bpath + 'application/get/address/province',
            type: "POST",
            data: {_token, provCode,},
            success: function (response) {

                var data = JSON.parse(response);

                let ref_mun_val = data['municipality_option'];
                let ref_brgy_val = data['brgy_option'];

                $('.ref_city_mun').html(ref_mun_val);
                $('.ref_brgy').html(ref_brgy_val);
            }
        });

    });

    $('.ref_city_mun').on('select2:select', function (e) {

        let city_munCode = $(this).val();

        $.ajax({
            url: bpath + 'application/get/address/municipality',
            type: "POST",
            data: {_token, city_munCode,},
            success: function (response) {

                var data = JSON.parse(response);

                let ref_province = data['province_option'];
                let ref_brgy_val = data['brgy_option'];

                $('.ref_province').html(ref_province);
                $('.ref_brgy').html(ref_brgy_val);

            }
        });

    });

    $('.per_province').on('select2:select', function (e) {

        let provCode = $(this).val();

        $.ajax({
            url: bpath + 'application/get/address/province',
            type: "POST",
            data: {_token, provCode,},
            success: function (response) {

                var data = JSON.parse(response);

                let ref_mun_val = data['municipality_option'];
                let ref_brgy_val = data['brgy_option'];

                $('.per_city_mun').html(ref_mun_val);
                $('.per_brgy').html(ref_brgy_val);
            }
        });

    });

    $('.per_city_mun').on('select2:select', function (e) {

        let city_munCode = $(this).val();

        $.ajax({
            url: bpath + 'application/get/address/municipality',
            type: "POST",
            data: {_token, city_munCode,},
            success: function (response) {

                var data = JSON.parse(response);

                let ref_province = data['province_option'];
                let ref_brgy_val = data['brgy_option'];

                $('.per_province').html(ref_province);
                $('.per_brgy').html(ref_brgy_val);
            }
        });

    });
}

function populate_residential_address (res_province,res_province_code, res_municipality_code,res_municipality, res_brgy_code,res_brgy){

    if (res_province) {

        $('.ref_province').val(res_province_code);
        $('.ref_province').select2({
            placeholder: res_province,
            closeOnSelect: true,
        });
    }

    else {
        $('.ref_province').select2({
            placeholder: "Select Province",
            closeOnSelect: true,
        });
    }


    if (res_municipality) {

        // $('.ref_city_mun').val(res_municipality_code);
        // $('.ref_city_mun').select2({
        //     placeholder: res_municipality,
        //     closeOnSelect: true,
        // });

        $.ajax({
            type: 'POST',
            url: bpath + 'my/get/res/municipality',
            data: { _token, res_province_code }
        }).
        then(function (response) {

            if(response) {
                let data = JSON.parse(response);
                if(data.length > 0) {
                    for (var i = 0; i < data.length; i++) {

                        let city_mun_id = data[i]['city_mun_id'];
                        let city_mun_ = data[i]['city_mun_'];

                        var option = new Option(city_mun_,city_mun_id, false, true);
                        $('.ref_city_mun').append(option);
                    }
                }
                $('.ref_city_mun').val(res_municipality_code).trigger('change');
            }
        });

    }else if(res_municipality == '')
    {
        $.ajax({
            type: 'POST',
            url: bpath + 'my/get/res/municipality',
            data: { _token, res_province_code }
        }).
        then(function (response) {

            if(response) {
                let data = JSON.parse(response);

                if(data.length > 0) {
                    for (var i = 0; i < data.length; i++) {

                        let city_mun_id = data[i]['city_mun_id'];
                        let city_mun_ = data[i]['city_mun_'];

                        let city_option = new Option(city_mun_,city_mun_id, true, true);
                        $('.ref_city_mun').append(city_option);
                    }
                }
                $('.ref_city_mun').val(res_municipality_code).trigger('change');
            }
        });
    }

    else {
        $('.ref_city_mun').select2({
            placeholder: "Select Municipality",
            closeOnSelect: true,
        });
    }


    if (res_brgy) {

        $.ajax({
            type: 'POST',
            url: bpath + 'my/get/res/brgy',
            data: { _token, res_municipality_code }
        }).
        then(function (response) {

            if(response) {
                let data = JSON.parse(response);
                if(data.length > 0) {
                    for (var i = 0; i < data.length; i++) {

                        let brgy_id = data[i]['brgy_id'];
                        let brgy_ = data[i]['brgy_'];

                        var option = new Option(brgy_,brgy_id, false, true);
                        $('.ref_brgy').append(option);
                    }
                }
                $('.ref_brgy').val(res_brgy_code).trigger('change');
            }
        });
    }

    else if(res_brgy == '') {

        $.ajax({
            type: 'POST',
            url: bpath + 'my/get/res/brgy',
            data: { _token, res_municipality_code }
        }).
        then(function (response) {

            if(response) {
                let data = JSON.parse(response);
                if(data.length > 0) {
                    for (var i = 0; i < data.length; i++) {

                        let brgy_id = data[i]['brgy_id'];
                        let brgy_ = data[i]['brgy_'];

                        var option = new Option(brgy_,brgy_id, false, true);
                        $('.ref_brgy').append(option);
                    }
                }
                $('.ref_brgy').val(res_brgy_code).trigger('change');
            }
        });
    }

    else {
        $('.ref_brgy').select2({
            placeholder: "Select Barangay",
            closeOnSelect: true,
        });
    }

}

function populate_permanent_address(per_province_code,per_province, per_city_mun_code,per_city_mun, per_brgy_code,per_brgy){

    if (per_province) {
        $('.per_province').val(per_province_code);
        $('.per_province').select2({
            placeholder: per_province,
            closeOnSelect: true,
        });
    }

    else {
        $('.per_province').select2({
            placeholder: "Select Province",
            closeOnSelect: true,
        });
    }


    if (per_city_mun) {
        $('.per_city_mun').val(per_city_mun_code);
        $('.per_city_mun').select2({
            placeholder: per_city_mun,
            closeOnSelect: true,
        });
    }

    else {
        $('.per_city_mun').select2({
            placeholder: "Select Municipality",
            closeOnSelect: true,
        });
    }

    if (per_brgy) {

        $.ajax({
            type: 'POST',
            url: bpath + 'my/get/per/brgy',
            data: { _token, per_city_mun_code }
        }).
        then(function (response) {

            if(response) {
                let data = JSON.parse(response);

                if(data.length > 0) {
                    for (var i = 0; i < data.length; i++) {

                        let brgy_id = data[i]['brgy_id'];
                        let brgy_ = data[i]['brgy_'];

                        var option = new Option(brgy_,brgy_id, false, true);
                        $('.per_brgy').append(option);
                    }
                }
                $('.per_brgy').val(per_brgy_code).trigger('change');
            }
        });

    }

    else if(per_brgy == '') {

        $.ajax({
            type: 'POST',
            url: bpath + 'my/get/per/brgy',
            data: { _token, per_city_mun_code }
        }).
        then(function (response) {

            if(response) {
                let data = JSON.parse(response);
                if(data.length > 0) {
                    for (var i = 0; i < data.length; i++) {

                        let brgy_id = data[i]['brgy_id'];
                        let brgy_ = data[i]['brgy_'];

                        var option = new Option(brgy_,brgy_id, false, true);
                        $('.per_brgy').append(option);
                    }
                }
                $('.per_brgy').val(per_brgy_code).trigger('change');
            }
        });
    }

    else {
        $('.per_brgy').select2({
            placeholder: "Select Barangay",
            closeOnSelect: true,
        });
    }

}



function load_dynamic_city_mun(provCode, res_city_mun_code){
    $.ajax({
        url: bpath + 'application/get/address/province',
        type: "POST",
        data: {_token, provCode,},
        success: function (response) {

            var data = JSON.parse(response);

            let ref_mun_val = data['municipality_option'];
            let ref_brgy_val = data['brgy_option'];

            $('.per_city_mun').html(ref_mun_val);
            $('.per_brgy').html(ref_brgy_val);

            $('.per_city_mun').val(res_city_mun_code).trigger('change');
        }
    });
}

function load_dynamic_brgy(city_munCode, res_brgy_code){

    $.ajax({
        url: bpath + 'application/get/address/municipality',
        type: "POST",
        data: {_token, city_munCode,},
        success: function (response) {

            var data = JSON.parse(response);

            let ref_brgy_val = data['brgy_option'];

            $('.per_brgy').html(ref_brgy_val);
            $('.per_brgy').val(res_brgy_code).trigger('change');
        }
    });
}
