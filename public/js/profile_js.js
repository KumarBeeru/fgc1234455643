$(document).ready(function(){
    console.log('File Opened');
    
    
    //**hide and show the work area */
    $('.hidden_check').change(function() {
        if($(this).is(":checked")) {
            $('#hiddenable').show();
        }
        else{
            $('#hiddenable').hide();
        }        
    });
    
    //** update and edit code of the work list  */
    $('body').on('click','.edit',function() {

        var id = $(this).attr('id');    
        var operation = $('.btn_val'+id).text();
        console.log('id : ' ,id);

        if(operation == 'edit'){
            $('.btn_val'+id).text('update');
            
            var price_val = $('#input_price_'+id).text();
             $('#input_price_'+id).empty();
             $('#input_price_'+id).html('<form><input type="number" id="input_value'+id+'" value="'+parseInt(price_val)+'" /></form>');

            //console.log('operation on edit', price_val);
        }else{
            $('.btn_val'+id).text('edit');

            var price_val = $('#input_value'+id).val();
            $('#input_price_'+id).empty();
            $('#input_price_'+id).html('<i class="fas fa-rupee-sign"></i>'+parseInt(price_val));

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            console.log('Clicked On ',id);
    
            var url =$.url1+"/setting/wpupdate";
    
            $.ajax({
                url:url,
                type: 'post',
                data:{wl_id:id,
                     'price':price_val,
                    _token:$.token},
            }).done(function(data){
                //console.log(data);
                alert(data);
            });

            console.log('operation on update',price_val);
        }

        //console.log($('.btn_val'+id).text());
    });

    // Select city and area value of profile blade.
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



    /**
    * Add work list blade
    */
    //Change category list to subcat

    $('#cat_name').on('change', function() {
        
        var cat_id = $(this).find(":selected").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        console.log('Clicked On ',cat_id);

       var url =$.url1+"/setting/getsubcat";

        $.ajax({
            url:url,
            type: 'get',
            data:{cat_id:cat_id},
        }).done(function(data){
            console.log(data);
            $('#sub_name').empty();
            var template = '<option value="0">Select</option>';
            $('#sub_name').append(template);
            for (const iterator of data) {
                var template = '<option value="'+iterator.wor_subcat_id+'">'+iterator.subcat_name+'</option>';
               $('#sub_name').append(template);
            }
        });
    });

    //fatch work list

    $('#sub_name').on('change', function() {
        
        var scat_id = $(this).find(":selected").val();

        console.log('Clicked On ',scat_id);

       var url =$.url1+"/setting/getworklist";

        $.ajax({
            url:url,
            type:'get',
            data:{sub_id:scat_id},
        }).done(function(data){
            console.log(data);
            $('#input-name').empty();
            var template = '<option value="0">Select</option>';
            $('#input-name').append(template);
            for (const iterator of data) {
                var template = '<option value="'+iterator.wor_list_id+'">'+iterator.work_name+'</option>';
               $('#input-name').append(template);
            }
        });
    });
});