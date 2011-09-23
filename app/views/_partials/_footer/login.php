<script type="text/javascript">
	$(function() {
		$('.error').hide();
		$('input.text-input').css({backgroundColor:"#FFFFFF"});
		$('input.text-input').focus(function(){
			$(this).css({backgroundColor:"#EEEEAA"});
		});
		$('input.text-input').blur(function(){
			$(this).css({backgroundColor:"#FFFFFF"});
		});

		$("#submit").click(function() {
			$('.error').hide();

			var error_empty_field = "This field is required.";

			var username = $("input#username").val();
			if (username == "") {
				$("#username_error").show();
				$("#username_error").html(error_empty_field);
				$("input#username").focus();
				return false;
			}

			var password = $("input#password").val();
			if (password == "") {
				$("#password_error").show();
				$("#password_error").html(error_empty_field);
				$("input#email").focus();
				return false;
			}

			var datas = 'username=' + username + '&password=' + password;
			$.ajax({
				type: "POST",
				url:  "/login/submit",
				data: datas,
				success: function(data) {
					$("#form").html(data);
				}
			});
			return false;
		});
	});
</script>
