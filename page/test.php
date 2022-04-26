<!-- header -->
<?php include('../assets/php/header.php')?>
<!-- header -->

<div class="container" >
    <div class="card w-25 text-light mb-2 p-3" style="background-color: rgba(33,37,41,0.7)">
        <div class="rating mb-2">
            <i class="bi bi-star"  onclick="OnClickStar(1)" name="star"></i>
            <i class="bi bi-star"  onclick="OnClickStar(2)" name="star"></i>
            <i class="bi bi-star"  onclick="OnClickStar(3)" name="star"></i>
            <i class="bi bi-star"  onclick="OnClickStar(4)" name="star"></i>
            <i class="bi bi-star"  onclick="OnClickStar(5)" name="star"></i>
            <input type="hidden" id="ratingStar" value="">
        </div>
    </div>
</div>
<!-- onmouseover="FillStar(1)" onmouseout="EmptyStar()" -->
<!-- footer -->
<?php include('../assets/php/footer.php')?>
<!-- footer -->