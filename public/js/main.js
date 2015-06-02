$(document).ready(function(){
	$('#reader').html5_qrcode(function(data){
			$('#read').val(data);
			$('#qr_login').submit();
		},
		function(error){
			$('#read_error').html(error);
		}, function(videoError){
			$('#vid_error').html(videoError);
		}
	);
});
