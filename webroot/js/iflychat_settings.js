$(document).ready(function(){
$("fieldset.collapsible").collapse();
$("fieldset.startClosed").collapse( { closed: true } );

toggle_support_options();

$("#Iflychat_show_admin_list").click(function(){

toggle_support_options();
});
})



function toggle_support_options(){

$val_sup = $('#Iflychat_show_admin_list').val();

if($val_sup == 1){
$("#support_chat").show();

}
else {
$("#support_chat").hide();

}

}
$.fn.collapse = function(options) {
	var defaults = {
		closed : false
	}
	settings = $.extend({}, defaults, options);

	return this.each(function() {
		var obj = $(this);
		obj.find("legend").addClass('collapsible').click(function() {
			if (obj.hasClass('collapsed'))
				obj.removeClass('collapsed').addClass('collapsible');
	
			$(this).removeClass('collapsed');
	
			obj.children().not('legend').toggle("slow", function() {
			 
				 if ($(this).is(":visible"))
					obj.find("legend").addClass('collapsible');
				 else
					obj.addClass('collapsed').find("legend").addClass('collapsed');
			 });
		});
		if (settings.closed) {
			obj.addClass('collapsed').find("legend").addClass('collapsed');
			obj.children().filter("p,img,table,ul,div,span,h1,h2,h3,h4,h5").css('display', 'none');
		}
	});
};