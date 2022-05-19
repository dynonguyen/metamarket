let isStarted = false;

const chatBox = $('#chatBox');
const chatBoxBalloon = $('#chatBoxBalloon');
const chatBoxInput = $('#chatBoxInput');

function onShowChatBox(getInfoFunc) {
	chatBoxBalloon.on('click', function () {
		if (typeof getInfoFunc === 'function') {
			getInfoFunc();
		}

		$(this).addClass('d-none');
		chatBox.removeClass('d-none');
		isStarted && chatBoxInput.focus();
	});
}

function onCloseChatBox() {
	$('#closeChatBoxIcon').on('click', function () {
		chatBoxBalloon.removeClass('d-none');
		chatBox.addClass('d-none');
	});
}

jQuery(function () {
	onCloseChatBox();
});
