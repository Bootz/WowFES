<script type="text/javascript" src="/js/vendor/ajaxupload.3.5.js"></script>
<script type="text/javascript" >
	$(function(){
		var btnUpload=$('#upload');
		var status=$('#status');
		new AjaxUpload(btnUpload, {
			action: 'upload_file.php',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
                    // extension is not allowed
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				status.text('Uploading...');
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.text('');
				//Add uploaded file to list
				if(response!=="error"){
					$('#upload').hide();
					$('<li></li>').appendTo('#files').html('<img src="' + response + '" alt="照片縮圖" />').addClass('success');
					$('<li></li>').appendTo('#files').html('<a href="/upload_next"><h1>繼續輸入食譜資料</h1></a>');
				} else{
					$('<li></li>').appendTo('#files').text(file).addClass('error');
				}
			}
		});

	});
</script>
