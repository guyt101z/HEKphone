$(document).ready(function()
{
  $('.search-charges input[type="submit"]').hide();
 
  // Reload charges for every new character typed
  $('#destination').keyup(function(key)
  {
	  fetchCharges();
  });
  
  // Reload charges when an other provider is selected
  $('#provider').change(function()
  {
	  fetchCharges();
  });
  
  function fetchCharges()
  {
	  
	if ($('#destination').val().length >= 3 || $('#destination').val() == '')
	{
	  $('#loader').show();
	  $('#charges').load(
        $('#destination').parents('form').attr('action'),
	    { destination: $('#destination').val() },
	    function() { $('#loader').hide(); }
	  );
	}
  }
});