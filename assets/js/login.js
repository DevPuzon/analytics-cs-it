$(function()
{
	
	$("button").on('click', function (e) {
		e.preventDefault();


		var sAction =	$(this).attr("data-action");

		switch(sAction) {

			case 'login':

				if ($("[data-key=UserUname]").val() != "" && $("[data-key=UserPword]").val() != "")  {

					ajaxQuery('check-login', {'uname' : $("[data-key=UserUname]").val(), 'pword':$("[data-key=UserPword]").val() });
				} else {
					
					toastr.error('Please fill in the following fields!');
				}
			break;
		}

	});
});
