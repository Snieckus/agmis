/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


$(document).ready(function (){
    $('.js-example-basic-single').select2();
    let _token   = $('meta[name="csrf-token"]').attr('content');
    disable_time_fields(_token);

    $(document).on("change", ".appointment_date, .appointment_doctor", function () {
        disable_time_fields(_token);
    });

    $(document).on("change", ".appointment_time, .appointment_date, .appointment_doctor, .appointment_patient", function () {
        if($('input[class=appointment_time]:checked').length > 0){
            $.ajax({
                type:'POST',
                url:'/submit_temp_appointment',
                data:{
                    _token: _token,
                    'time' : $('.appointment_time:checked').val(),
                    'date' : $('.appointment_date').val(),
                    'doctor_id' : $('.appointment_doctor').val(),
                    'patient_id' : $('.appointment_patient').val(),
                },
                success:function(data) {
                    console.log(data.success);
                }
            });
        }
    });
    $(document).on("click", "#get_prescriptions", function() {
        $.ajax({
            type:'POST',
            url:'/get_api_data',
            data:{
                _token: _token,
                'user_email' : $('#user_email').val(),
            },
            success:function(data){
                var result = '<table class="table table-bordered"><thead>'+
                    '<tr>'+
                    '<th>ID</th>'+
                    '<th>Drug name</th>'+
                    '<th>Patient name</th>'+
                    '<th>Valid until</th>'+
                    '<th>Created at</th>'+
                    '</tr>'+
                    '</thead>';
                $.each(JSON.parse(data), function (key, value) {

                    result += '<tr>';
                    result += '<td>' +
                        value.id + '</td>';

                    result += '<td>' +
                        value.d_name + '</td>';

                    result += '<td>' +
                        value.p_name + '</td>';

                    result += '<td>' +
                        value.valid_until + '</td>';

                    result += '<td>' +
                        value.created_at + '</td>';

                    result += '</tr>';
                });
                result += '</table>';
                $('#result_div').html(result);
            }
        });
    });

    function disable_time_fields(_token){
        $('.appointment_time').attr("disabled",false);
        $.ajax({
            type:'POST',
            url:'/get_used_times',
            data:{
                _token: _token,
                'date' : $('.appointment_date').val(),
                'doctor_id' : $('.appointment_doctor').val(),
            },
            success:function(data) {
                $.each(JSON.parse(data), function (key, value) {
                    $('.appointment_time').each(function(){
                        if($(this).val() == value){
                            $(this).prop('disabled', true);
                        }
                    });
                });
            }
        });
    }
});
