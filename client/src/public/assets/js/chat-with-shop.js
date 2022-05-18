/// <reference path="/home/dyno/development/my-devtools-config/Vscode/typings/jquery/globals/jquery/index.d.ts" />
// Required chat-box.js, passed variable 'SHOP_INFO', 'USER_ID', 'SUPPORT_SERVICE_API_URL', 'CHAT_SOCKET_SERVER

let shop = {
	isActive: false,
};
const userId = Number(USER_ID);
const messageElem = $('#messages');

function updateChatBoxTop() {
	const logo = shop.logoUrl
		? `${STATIC_URL}/${shop.logoUrl}`
		: DEFAULT_SHOP_AVT;

	$('.chat-box__top img').attr('src', logo);
	$('.chat-box__top .name')
		.attr('href', `/cua-hang/${shop.shopId}`)
		.text(shop.name);

	if (shop.isActive) {
		$('.chat-box__top .status span').html('Đang hoạt động');
		$('.chat-box__top .status .dot').addClass('active');
	} else {
		$('.chat-box__top .status span').html('Offline');
		$('.chat-box__top .status .dot').removeClass('active');
	}
}

function renderMessage(msg = '', isSender = false, time) {
	const senderClass = isSender ? 'sender' : 'receiver';
	const timeStr = dateFormat(time);
	messageElem.append(
		`<li class='message ${senderClass}' title='${timeStr}'>${msg}</li>`,
	);
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
		$('.chat-box__content').scrollTop(messageElem.height());
	}
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

		const socket = io(CHAT_SOCKET_SERVER);
	});
}

jQuery(function () {
	if (SHOP_INFO) {
		shop = { ...shop, ...JSON.parse(SHOP_INFO) };
		if (!shop || !shop.shopId) return;

		onShowChatBox(updateChatBoxTop);
		onStartChat();
	}
});
