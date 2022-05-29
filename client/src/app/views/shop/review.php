<?php
require_once _DIR_ROOT . '/utils/Format.php';
function renderStars($stars = 1)
{
    $starXml = '';
    for ($i = 1; $i <= 5; ++$i) {
        if ($i <= $stars) {
            $starXml .= "<i class='bi bi-star-fill orange-color'></i>";
        } else {
            $starXml .= "<i class='bi bi-star'></i>";
        }
    }
    return $starXml;
}

function countStars($reviews)
{
    $stars = [0, 0, 0, 0, 0];
    foreach ($reviews as $review) {
        $stars[round($review->rate) - 1]++;
    }

    $avg = 0;
    $sum = 0;
    for ($i = 1; $i <= 5; ++$i) {
        $avg += $stars[$i - 1] * $i;
        $sum += $stars[$i - 1];
    }

    return ['stars' => $stars, 'avg' => number_format($avg / $sum, 1, '.')];
}
?>

<div class='py-4'>
    <div class='container p-4 bg-white'>
        <h1 class='shop-title'>Đánh giá khách hàng</h1>

        <?php if (empty($reviews)) { ?>
            <p class="py-4 text-gray fs-2 text-center">Bạn chưa có đánh giá nào</p>
        <?php } else {
            ['stars' => $stars, 'avg' => $starAvg] = countStars($reviews);
            $totalReview = sizeof($reviews);

            echo "<div class='d-flex fs-2 border-bottom pb-5 pt-3'>
                <span>Tổng đánh giá <b>($totalReview)</b></span>
                <span class='mx-4'>5 sao <b>($stars[4])</b></span>
                <span>4 sao <b>($stars[3])</b></span>
                <span class='mx-4'>3 sao <b>($stars[2])</b></span>
                <span>2 sao <b>($stars[1])</b></span>
                <span class='mx-4'>1 sao <b>($stars[0])</b></span>
                <span>Trung bình <b>$starAvg / 5</b></span>
            </div>";

            foreach ($reviews as $review) {
                $rate = round($review->rate);
                $starXml = renderStars($rate);
                $createdAt = FormatUtil::ISOChangeTimeZone($review->createdAt, 'd-m-Y');
                $cusFullname = $review->customerInfo->fullname;
                $customerName = $review->isAnonymous ? $cusFullname[0] . "******" . $cusFullname[strlen($cusFullname) - 1]  : $cusFullname;
                $customerEmail = $review->customerInfo->email;
                $content = $review->content;

                echo "<div class='border-bottom py-4'>
                        <div>
                            <strong class='fs-3'>$customerName</strong>
                            <span class='mx-2'>-</span>
                            <span class='text-gray fs-4'>$customerEmail</span>
                        </div>
                        <div class='d-flex'>
                            <div class='vertical-center'>$starXml</div>
                            <p class='text-gray fs-4 ms-3'>$createdAt</p>
                        </div>
                        <p class='fs-3'>$content</p>
                    </div>";
            }
        } ?>

    </div>
</div>