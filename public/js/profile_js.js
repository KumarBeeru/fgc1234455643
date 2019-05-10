$(document).ready(function(){
    console.log('File Opened');
    
    
    $('.hidden_check').change(function() {
        if($(this).is(":checked")) {
            $('#hiddenable').show();
        }
        else{
            $('#hiddenable').hide();
        }        
    });
    
    
    $('.select_city').on('change', function() {
        var city_id = $(this).find(":selected").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        console.log('Clicked On ',city_id);

       var url =$.url+"/getarea";

        $.ajax({
            url:url,
            type: 'POST',
            data:{city_id:city_id,
            _token:$.token},
        }).done(function(data){
            console.log(data);
            $('.select_area').empty();
            for (const iterator of data) {
                var template = '<option value="'+iterator.arealist_id+'">'+iterator.area_name+'</option>';
               $('.select_area').append(template);
            }
        });

    });
});