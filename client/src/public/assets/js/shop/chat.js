jQuery(function () {
	const shopId = 9;
	const userId = 7;
	const socket = io(`${CHAT_SOCKET_SERVER}/shop`);
	socket.emit('fc shop online', shopId);

	socket.on('fs user chat', (data) => {
		$('#messages').append(`<li class='message receiver'>${data.content}</li>`);
	});

	$('#message').on('keypress', function (event) {
		if (event.key === 'Enter') {
			const message = $('#message').val();
			$('#messages').append(`<li class='message sender'>${message}</li>`);
			socket.emit('fc shop chat', { userId, shopId, message });
			$('#message').val('');
		}
	});

	$('#sendMsgBtn').on('click', function () {
		const message = $('#message').val();
		$('#messages').append(`<li class='message sender'>${message}</li>`);
		socket.emit('fc shop chat', { userId, shopId, message });
		$('#message').val('');
	});
});
