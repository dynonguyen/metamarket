<?php
function renderToast($msg = 'Thông báo', $show = false, $isTop = false, $isError = false)
{
    $placement = $isTop ? 'top: 7rem' : 'bottom: 8px';
    $showClass = $show ? 'show' : '';
    $bgClass = $isError ? 'bg-danger' : 'bg-success';

    echo "<div id='toast' data-bs-autohide='true' class='toast $showClass $bgClass position-fixed text-white border-0 py-2 px-3' style='z-index: 9999; $placement; right: 1rem' role='alert' aria-live='assertive' aria-atomic='true'>
        <div class='d-flex'>
            <div class='toast-body' style='font-size: 1.6rem;'>$msg</div>
            <button type='button' style='font-size: 1.4rem;' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close' onclick='hideToast()'></button>
        </div>
    </div>";
}
