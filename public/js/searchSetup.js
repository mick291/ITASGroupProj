/**
 * Helper JavaScript functions developed for DMSFSRS.
 * Mostly these support AJAX calls for searching etc...
 * 
 * author Mark Tustin
 */

function search(controllerActionURL){
	$.ajax({
		type: "POST",
		dataType: "html",
		url: controllerActionURL,
		data: 'search='+$('#searchcrit').val(),
		success: function(html){
			$("#results").append(html).hide();
			$("#results").fadeIn('slow').show();
                        $(".deleteButton").easyconfirm({locale: { text:"Are you sure you want to delete?", button: ['No','Yes']}});
		}
	});
}

function setupSearch(controllerActionURL) {
	$(document).ready(function() {
		var timeout;
		$('input#searchcrit').keyup(function () {
			if (timeout)
				clearTimeout (timeout);

			$("#results").find("tr").fadeOut('slow').remove();
			
			if ($('#searchcrit').val().length > 1){
				timeout = setTimeout(function(){ search(controllerActionURL) }, 1000);
			}
		});
			
		// croftd: Note - AjaxSearch id is defined in the AjaxSearch form!
		// It's really important that your search form has a text element
		// with this specific ID !!
		//
		$('#AjaxSearch').submit(function() {
			return false;
		});
	});
}