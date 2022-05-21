<?php
// Require pagination.css, pagination.js 

function renderPagination($totalPage = 1, $page = 1)
{
    echo "<div class='pagination'>";

    if ($totalPage > 1 && $page > 1) {
        echo "<button title='Trang trước' id='prevPageBtn' data-page='$page'>
                <i class='bi bi-arrow-left-short'></i>
            </button>";
        echo "<button id='firstPageBtn'>1</button>";
    }

    echo "<button class='disabled'>. $page .</button>";

    if ($totalPage > 1 && $page < $totalPage) {
        echo "<button id='lastPageBtn' data-total='$totalPage'>$totalPage</button>";
        echo "<button title='Trang kế' id='nextPageBtn' data-page='$page'>
                <i class='bi bi-arrow-right-short'></i>
            </button>";
    }

    echo "</div>";
}
