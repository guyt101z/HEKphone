$(document).ready(function()
{
  $('.search-charges input[type="submit"]').hide();
 
  // Reload charges for every new character typed
  $('#destination').keyup(function(key)
  {
    if (this.value.length >= 3 || this.value == '')
    {
      $('#loader').show();
      $('#charges').load(
        $(this).parents('form').attr('action'),
        { destination: this.value },
        function() { $('#loader').hide(); }
      );
    }
  });
  
  // Reload charges when an other provider is selected
  $('#provider').change(function()
  {
    $('#charges').load(
      $(this).parents('form').attr('action'),
      { destination: $('#destination').val() },
      function() { $('#loader').hide(); }
    );
  });
});