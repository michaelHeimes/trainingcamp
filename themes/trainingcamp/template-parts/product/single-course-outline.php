<?php
$description1=get_field('product_outline_description1');
$description2=get_field('product_outline_description2');

if($description1 || $description2):
    ?>
    <div class="container content custom-include-container">
        <div class="columns">
            <?php if($description1 && $description2): ?>
                <div class="col">
                    <?= $description1 ?>
                </div>
                <div class="col">
                    <?= $description2 ?>
                </div>
            <?php else: ?>
                <?= $description1 ?>
                <?= $description2 ?>
            <?php endif; ?>
        </div>
    </div>
    <?php
endif; ?>
