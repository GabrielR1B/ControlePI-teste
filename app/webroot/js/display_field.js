function display_field(field_name, field_id){
    if(field_name == 1){
            $( '#' + field_id).parent().show();
        }else{
            $( '#' + field_id).parent().hide();
            $( '#' + field_id).val('');          
        }
}