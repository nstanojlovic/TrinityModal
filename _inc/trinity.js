jQuery(document).ready(function(){
    jQuery('.checkbox').on('click',function(){
        var types = [];
        jQuery('.checkbox:checked').each(function(){
            var current = this.value;
            types.push(this.value)
        })
        jQuery('.option').each(function(){
            if(jQuery.inArray(jQuery(this).attr('post-type'), types) !== -1) {
                jQuery(this).show();
            }else {jQuery(this).hide();jQuery(this).attr('selected',false);}
        })
    })
})