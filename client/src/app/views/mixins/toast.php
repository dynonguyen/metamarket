<?php
function renderToast($msg = 'Thông báo')
{
    echo "<div id='toast' data-bs-autohide='true' class='toast position-fixed text-white bg-primary border-0 py-2 px-3' style='z-index: 999; bottom: 8px; right: 24px' role='alert' aria-live='assertive' aria-atomic='true'>
        <div class='d-flex'>
            <div class='toast-body' style='font-size: 1.6rem;'>$msg</div>
            <button type='button' style='font-size: 1.4rem;' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close' onclick='hideToast()'></button>
        </div>
    </div>";
}
