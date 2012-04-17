/**
 * BGP Tools.
 *
 * Copyright (C) 2012 Beat Gebistorf
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
(function($) {
    Tc.Module.Tool = Tc.Module.extend({
        onBinding: function() {
            var that = this;
            $('button',that.$ctx).on('click',function(){
                var name = $(this).attr('data-name');
                if (name.split.length > 1)
                var url = "api/tools/"+name+"/"+$('#'+name).val();

                $.ajax({
                  url: url,
                  context: document.body
                }).done(function(data) {
                    $.each(data, function(key, value) {
                        $("."+name+"_result",that.$ctx).html(value).removeClass('empty');
                    });
                });
            });
        }
    });
})(Tc.$);
