/// <reference path="/home/dyno/development/my-devtools-config/Vscode/typings/jquery/globals/jquery/index.d.ts" />
// Required chat-box.js, passed variable 'SHOP_INFO', 'USER_ID', 'SUPPORT_SERVICE_API_URL', 'CHAT_SOCKET_SERVER

let shop;
const userId = Number(USER_ID);
const messageElem = $('#messages');
let socket = null;

function updateShopStatus(isOnline = false) {
	if (isOnline) {
		$('.chat-box__top .status span').html('Đang hoạt động');
		$('.chat-box__top .status .dot').addClass('active');
	} else {
		$('.chat-box__top .status span').html('Offline');
		$('.chat-box__top .status .dot').removeClass('active');
	}
}

function updateChatBoxTop() {
	const logo = shop.logoUrl
		? `${STATIC_URL}/${shop.logoUrl}`
		: DEFAULT_SHOP_AVT;

	$('.chat-box__top img').attr('src', logo);
	$('.chat-box__top .name')
		.attr('href', `/cua-hang/${shop.shopId}`)
		.text(shop.name);

	updateShopStatus(Boolean(shop.isOnline));
}

function renderMessage(msg = '', isSender = false, time) {
	const senderClass = isSender ? 'sender' : 'receiver';
	const timeStr = dateFormat(time);
	messageElem.append(
		`<li class='message ${senderClass}' title='${timeStr}'>${msg}</li>`,
	);
}

function scrollContentToBottom() {
	$('.chat-box__content').scrollTop(messageElem.height());
}

async function loadMessageHistory() {
	const apiRes = await fetch(
		`${SUPPORT_SERVICE_API_URL}/chat-shop-user/${shop.shopId}/${userId}`,
	);
	if (apiRes.status === 200) {
		const messages = await apiRes.json();
		messages.sort(
			(a, b) => new Date(a.time).getTime() - new Date(b.time).getTime(),
		);
		messages.forEach((msg) => renderMessage(msg.content, msg.isUser, msg.time));
		scrollContentToBottom();
	}
}

function onShopChat(message) {
	const { time, content } = message;
	renderMessage(content, false, time);
	scrollContentToBottom();
}

function startSocketEventListener() {
	socket.on('fs shop online', () => updateShopStatus(true));
	socket.on('fs shop offline', () => updateShopStatus(false));
	socket.on('fs shop chat', onShopChat);
}

function startSocket() {
	socket = io(`${CHAT_SOCKET_SERVER}/shop`);
	socket.emit('fc user connect', { shopId: shop.shopId, userId });
	startSocketEventListener();
}

function onStartChat() {
	$('#startChat button').on('click', async function () {
		if (isNaN(userId) || userId <= 0) {
			location.href = '/tai-khoan/dang-nhap';
			return;
		}

		await loadMessageHistory();
		$('#startChat').remove();
		$('.chat-box__typing').removeClass('disabled');
		chatBoxInput.focus();
		isStarted = true;

		startSocket();
	});
}

function sendMessage() {
	const message = chatBoxInput.val();
	if (!socket || !message) return;

	chatBoxInput.val('');
	renderMessage(message, true, new Date());
	socket.emit('fc user chat', { userId, shopId: shop.shopId, message });

	scrollContentToBottom();
}

jQuery(function () {
	if (SHOP_INFO) {
		shop = { ...shop, ...JSON.parse(SHOP_INFO) };
		if (!shop || !shop.shopId) return;

		onShowChatBox(updateChatBoxTop);
		onStartChat();
	}

	chatBoxInput.on('keypress', function (event) {
		if (event.key === 'Enter') {
			sendMessage();
		}
	});

	$('#sendBtn').on('click', function () {
		sendMessage();
	});
});
