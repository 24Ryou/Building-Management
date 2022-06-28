<?php
    require_once "../includes/user.inc.php"
?>
 <div class="top">
    <div class="card-price" id="rent">
        <div class="rent-price">
            <?php echo "<h3>" . $_SESSION["urent"] . " تومان</h3>" ?>
        </div>
        <div class="line"></div>
        <h3>اجاره این ماه</h3>
    </div>
    <div class="card-price" id="charge">
        <div class="charge-price">
            <?php echo "<h3>" . $_SESSION["ucharge"] . " تومان</h3>" ?>
        </div>
        <div class="line"></div>
        <h3>شارژ این ماه</h3>
    </div>
    <div class="card-price" id="debt">
        <div class="debt-price">
            <?php echo "<h3>" . $_SESSION["udebit"] . " تومان</h3>" ?>
        </div>
        <div class="line"></div>
        <h3>مجموع بدهی</h3>
    </div>
    <div class="card-price" id="credit">
        <div class="debt-price">
            <?php echo "<h3>" . $_SESSION["ucredit"] . " تومان</h3>" ?>
        </div>
        <div class="line"></div>
        <h3>مجموع بستانکاری</h3>
    </div>
</div>