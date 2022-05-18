<?php
// Require chat-box.css chat-box.js
$defaultLogo = DEFAULT_SHOP_AVT;
?>

<i class='bi bi-chat-dots-fill chat-box-balloon' id='chatBoxBalloon' title="Tư vấn online"></i>

<div class='chat-box d-none' id="chatBox">
    <div class='chat-box__top'>
        <?php echo "<img src='$defaultLogo' />"; ?>
        <div class='d-flex flex-column'>
            <a class='name' href='#'>Đang cập nhật</a>
            <div class='vertical-center status'>
                <span class='text-gray fs-6'>Offline</span>
                <div class='dot ms-2'></div>
            </div>
        </div>
        <div class='vertical-center ms-auto'>
            <i class='bi bi-x-lg cursor-pointer text-gray fs-2' id="closeChatBoxIcon"></i>
        </div>
    </div>

    <div class='chat-box__content'>
        <div class='flex-center w-100 h-100' id='startChat'>
            <button class='btn btn-secondary py-3 px-4 fs-4 text-uppercase'>Bắt đầu chat</button>
        </div>
        <ul id="messages"></ul>
        <div id='target'></div>
    </div>

    <div class='chat-box__typing disabled'>
        <input type='text' class='form-control pe-3' id='chatBoxInput' placeholder="Nhập tin nhắn của bạn tại đây">
        <i class='bi bi-send-fill' id="sendBtn" title="Gửi"></i>
    </div>
</div>