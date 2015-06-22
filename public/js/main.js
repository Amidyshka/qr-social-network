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
function ytVidId(url) {
	var p = /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/;
	return (url.match(p)) ? RegExp.$1 : false;
}


$('.direct-chat-text').html(function (i, v) {
	var id = v.split('youtube.com/watch?v=')[1]; // get the id so you can add to iframe
	if (id !== undefined)
		return v + '<br><iframe width="560" height="315" src="http://www.youtube.com/embed/' + id + '" frameborder="0" allowfullscreen></iframe>';
});
$(document).delegate('*[data-toggle="lightbox"]', 'click', function (event) {
	event.preventDefault();
	$(this).ekkoLightbox();
});
var mess;
var mess2;

$('.direct-chat-messages').load('ajax/' + $('.direct-chat-messages').data('thread'));
$('.contacts-list').load('/messages div.box-header');
$(".direct-chat-messages").animate({scrollTop: 10000}, 250);
$(".direct-chat-messages").animate({scrollTop: 10000}, 250);


function refresh() {
	setTimeout(function () {

		$('.hide').load('ajax/' + $('.direct-chat-messages').data('thread'));
		mess = $('.direct-chat-messages  > div').length;
		mess2 = $('.hide  > div').length;
		if (mess == mess2)
			console.log('not');
		else {

			$('.direct-chat-messages').load('ajax/' + $('.direct-chat-messages').data('thread'));
			$(".direct-chat-messages").animate({scrollTop: 10000}, 250);
			$(".direct-chat-messages").animate({scrollTop: 10000}, 250);
		}
		refresh();
	}, 5000);
}


