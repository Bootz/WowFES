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
			var error_password_mismatch = "Confirm password is mismatched.";
			var error_password_length_6 = "Password length most larger than 6.";

			var username = $("input#username").val();
			if (username == "") {
				$("#username_error").show();
				$("#username_error").html(error_empty_field);
				$("input#username").focus();
				return false;
			}

			var email = $("input#email").val();
			if (email == "") {
				$("#email_error").show();
				$("#email_error").html(error_empty_field);
				$("input#email").focus();
				return false;
			}

			var password = $("input#password").val();
			var confirm_password = $("input#confirm_password").val();
			if (password == "") {
				$("#password_error").show();
				$("#password_error").html(error_empty_field);
				$("input#password").focus();
				return false;
			}
			if (password.length < 6) {
				$("#password_error").show();
				$("#password_error").html(error_password_length_6);
				$("input#password").focus();
				return false;
			}
			if (password != confirm_password) {
				$("#password_error").show();
				$("#password_error").html(error_password_mismatch);
				$("input#password").focus();
				return false;
			}


			var datas = 'username=' + username + '&password=' + password + '&email=' + email;
			$.ajax({
				type: "POST",
				url:  "/register/add",
				data: datas,
				success: function(data) {
					$("#form").html(data);
				}
			});
			return false;
		});
	});
</script>
