<?php require_once _DIR_ROOT . '/utils/Format.php'; ?>

<div class='container-fluid pt-3 px-4 mb-4'>
    <div class='row bg-white gx-0 chat-wrap'>
        <section class="userlist-side col col-12 col-md-6 col-lg-4">
            <ul class="userlist">
                <?php if (!empty($lastChats)) { ?>
                    <?php
                    foreach ($lastChats as $chat) {
                        $cusName = $chat->user->fullname;
                        $userId = $chat->user->userId;
                        $cusPhone = $chat->user->phone;
                        $msg = $chat->message->content;
                        $time = FormatUtil::ISOChangeTimeZone($chat->message->time);
                        $isSeen = $chat->message->isUser ? 'new' : '';

                        echo "<li class='userlist-item $isSeen' data-user-id='$userId' data-user-phone='$cusPhone' data-last-time='$time' data-user-name='$cusName'>
                                <div class='cus-name'>$cusName</div>
                                <div class='vertical-center'>
                                    <p class='last-msg'>$msg</p>
                                    <div class='last-msg-time'>$time</div>
                                </div>
                            </li>";
                    }
                    ?>
                <?php } else {
                    echo "<p class='py-5 text-center fs-3 text-gray' id='emptyUserList'>Bạn chưa có tin nhắn nào</p>";
                } ?>
            </ul>
        </section>

        <section class="chat-side col col-12 col-md-6 col-lg-8">
            <div class='chat-side__top d-none'>
                <div>
                    <span class='cus-name'></span>
                    <span class='cus-phone'></span>
                </div>
                <div class="last-msg-time"></div>
            </div>

            <div class='chat-box__content'>
                <ul id="messages">
                    <p class="text-center text-gray fs-3 py-5">Hãy chọn khách hàng cần tư vấn</p>
                </ul>
                <div id='target'></div>
            </div>

            <div class='chat-box__typing disabled'>
                <input type='text' class='form-control pe-3' id='chatBoxInput' placeholder="Nhập tin nhắn của bạn tại đây">
                <i class='bi bi-send-fill' id="sendBtn" title="Gửi"></i>
            </div>
        </section>

    </div>
</div>
</div>