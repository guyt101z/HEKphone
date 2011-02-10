/* Show/Hide voicemail settings */
function toggleVoicemailSettings() {
	// If checked
	if ($('#settings_vm_active').is(':checked'))
	{
		//show the hidden div
		$("#voicemail div input, #voicemail div label").show('fast');
	}
	else
	{     
		//otherwise, hide it
		$('#voicemail div input, #voicemail div label').hide('fast');
	}
	
	return true;
}

$(document).ready(function(){
	// onload hide/show
	toggleVoicemailSettings();
	
    // Add onclick handler to vm_active
    $('#settings_vm_active').click(function() {
    	toggleVoicemailSettings();
    });
});


/* Show/Hide redirect settings */
function toggleRedirectSettings() {
	// If checked
	if ($('#settings_redirect_active').is(':checked'))
	{
		//show the hidden div
		$('#redirect div input, #redirect div label').show('fast');
	}
	else
	{     
		//otherwise, hide it
		$('#redirect div input, #redirect div label').hide('fast');
	}
	
	return true;
}

$(document).ready(function(){
	// onload hide/show
	toggleRedirectSettings();
	
    // Add onclick handler to vm_active
    $('#settings_redirect_active').click(function() {
    	toggleRedirectSettings();
    });
});
