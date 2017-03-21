/**
 * @package     Joomla.Site
 * @subpackage  Templates.cristacurva
 * @since       3.2
 */

function openInNewWindow(url) {
    var newWindow = window.open(url, '_blank');
    newWindow.focus();
    return false;
}

jQuery(window).load(function () {
    if (jQuery('.container').width() > 767) {   
        var heightMax = 0;
        jQuery('.organizado .row-1 .span4 img').each(function(index, element){
              if(heightMax < jQuery(element).height())
                heightMax = jQuery(element).height();
        });

        jQuery('.organizado .row-1 .span4').each(function(index, element){
             jQuery(element).height(heightMax);
        });

        var heightMax = 0;
        jQuery('.organizado .row-2 .span4 img').each(function(index, element){
              if(heightMax < jQuery(element).height())
                heightMax = jQuery(element).height();
        });

        jQuery('.organizado .row-2 .span4').each(function(index, element){
             jQuery(element).height(heightMax);
        });
    }
});

(function($)
{
    $(document).ready(function()
    {
        $('.menu-middle ul.menu > li').each(function(index, element) {
            $(element).addClass('span3');
        });      
        
        $('ul.items-redes li').click(function(e){  
            var href = $(this).find('a').attr('href');
                        
            if(href)            
                 openInNewWindow(href);   
            
            e.stopPropagation();
            e.preventDefault();
        });                

        $('*[rel=tooltip]').tooltip()

        // Turn radios into btn-group
        $('.radio.btn-group label').addClass('btn');
        $(".btn-group label:not(.active)").click(function()
        {
            var label = $(this);
            var input = $('#' + label.attr('for'));

            if (!input.prop('checked')) {
                label.closest('.btn-group').find("label").removeClass('active btn-success btn-danger btn-primary');
                if (input.val() == '') {
                    label.addClass('active btn-primary');
                } else if (input.val() == 0) {
                    label.addClass('active btn-danger');
                } else {
                    label.addClass('active btn-success');
                }
                input.prop('checked', true);
            }
        });
        $(".btn-group input[checked=checked]").each(function()
        {
            if ($(this).val() == '') {
                $("label[for=" + $(this).attr('id') + "]").addClass('active btn-primary');
            } else if ($(this).val() == 0) {
                $("label[for=" + $(this).attr('id') + "]").addClass('active btn-danger');
            } else {
                $("label[for=" + $(this).attr('id') + "]").addClass('active btn-success');
            }
        });

        if (jQuery('.container').width() < 767) {
            jQuery('.menu').find('li.parent').append('<strong></strong>');
            jQuery('.menu li.parent strong').on("click", function(){
                if (jQuery(this).attr('class') == 'opened') { 
                    jQuery(this).removeClass().parent('li.parent').find('> ul').slideToggle(); } 
                else {
                    jQuery(this).addClass('opened').parent('li.parent').find('> ul').slideToggle();
                }
            });
        };

        if (jQuery('.container').width() > 767) {            
                
            var heightMax = 0;
            jQuery('.block-squad .header-block p').each(function(index, element){
                  if(heightMax < jQuery(element).height())
                    heightMax = jQuery(element).height();
            });

            jQuery('.block-squad .header-block p').each(function(index, element){
                 jQuery(element).height(heightMax);
            });

            var heightMax = 0;
            jQuery('.block-squad p:not(.header-block p)').each(function(index, element){
                  if(heightMax < jQuery(element).height())
                    heightMax = jQuery(element).height();
            });

            jQuery('.block-squad p:not(.header-block p)').each(function(index, element){
                 jQuery(element).height(heightMax);
            });

            var heightMax = 0;
            jQuery('.block-squad .header-block h3').each(function(index, element){
                  if(heightMax < jQuery(element).height())
                    heightMax = jQuery(element).height();
            });

            jQuery('.block-squad .header-block h3').each(function(index, element){
                 jQuery(element).height(heightMax);
            });
        }
    })
})(jQuery);