const shopId = Number(SHOP_ID);
let currentUserId = -1;
let socket = null;

const chatBoxInput = $('#chatBoxInput');
const messageElem = $('#messages');

const onUserChat = async (message) => {
	const { userId, content, time } = message;
	if (userId === currentUserId) {
		renderMessage({ content, time, isUser: true });
		scrollContentToBottom();
	} else {
		const userElements = $(`.userlist-item[data-user-id='${userId}']`);
		if (userElements.length) {
			const userElem = $(userElements[0]);
			userElem.addClass('new');
			userElem.find('.last-msg').text(content);
			userElem.find('.last-msg-time').text(dateFormat(time));
		} else {
			const apiRes = await fetch(
				`${USER_SERVICE_API_URL}/user-by-id/${userId}`,
			);
			const user = await apiRes.json();
			const { fullname, phone = '' } = user;

			xml = `<li class='userlist-item new' data-user-id='${userId}' 
									data-user-phone='${phone}' 
									data-last-time='${dateFormat(time)}' data-user-name='$cusName'>
								<div class='cus-name'>${fullname}</div>
								<div class='vertical-center'>
										<p class='last-msg'>${content}</p>
										<div class='last-msg-time'>${dateFormat(time)}</div>
								</div>
						</li>`;
			$('.userlist').prepend(xml);
			onChooseUserChat();
		}
	}
};

const socketEventListener = () => {
	socket.on('fs user chat', onUserChat);
};

const onStartSocket = () => {
	socket = io(`${CHAT_SOCKET_SERVER}/shop`);
	socket.emit('fc shop online', shopId);

	socketEventListener();
};

const sendMessage = () => {
	const message = chatBoxInput.val();
	renderMessage({ isUser: false, content: message, time: new Date() });
	socket.emit('fc shop chat', { userId: currentUserId, shopId, message });
	chatBoxInput.val('');
	scrollContentToBottom();
};

const getUserMessages = async (userId) => {
	let messages = [];
	const apiRes = await fetch(
		`${SUPPORT_SERVICE_API_URL}/chat-shop-user/${shopId}/${userId}`,
	);
	if (apiRes.status === 200) {
		messages = await apiRes.json();
		messages.sort(
			(a, b) => new Date(a.time).getTime() - new Date(b.time).getTime(),
		);
	}
	return messages;
};

const scrollContentToBottom = () => {
	$('.chat-box__content').scrollTop(messageElem.height());
};

const renderMessage = ({ isUser, content, time }) => {
	messageElem.append(
		`<li class='message ${isUser ? 'receiver' : 'sender'}' 
				title='${dateFormat(time)}'>${content}</li>`,
	);
};

const onChooseUserChat = () => {
	$('.userlist-item').on('click', async function () {
		const userId = Number($(this).attr('data-user-id'));
		const userPhone = $(this).attr('data-user-phone');
		const userName = $(this).attr('data-user-name');
		const lastTime = $(this).attr('data-last-time');

		$(this).removeClass('new');

		$('.chat-side__top').removeClass('d-none');
		$('.chat-side__top .cus-name').text(userName);
		$('.chat-side__top .cus-phone').text(userPhone);
		$('.chat-side__top .last-msg-time').text(`Last Seen: ${lastTime}`);

		const messages = await getUserMessages(userId);
		messages.forEach((message) => renderMessage(message));
		scrollContentToBottom();

		$('.chat-box__typing').removeClass('disabled');
		chatBoxInput.focus();

		$('.userlist-item.active').removeClass('active');
		$(this).addClass('active');

		currentUserId = userId;
	});
};

jQuery(function () {
	if (isNaN(shopId) || shopId <= 0) return;

	onChooseUserChat();
	onStartSocket();

	chatBoxInput.on('keypress', function (event) {
		if (event.key === 'Enter') {
			sendMessage();
		}
	});

	$('#sendMsgBtn').on('click', sendMessage);
});
