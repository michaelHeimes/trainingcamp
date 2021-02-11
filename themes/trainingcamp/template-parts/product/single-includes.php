<div class="columns container content">
    <div class="col">
        <?= get_field('product_include_description1') ?>
        <?php if(have_rows('product_include_course_ids')): ?>
            <?php while(have_rows('product_include_course_ids')): the_row(); ?>
                <?php
                $title=get_sub_field('product_include_course_ids_title');
                $link=get_sub_field('product_include_course_ids_link');
                $link=($link) ? 'href="'.$link.'"' : '';
                if($title){
                    echo '<a '.$link.'>'.$title.'</a>';
                }
                ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
    <div class="col">
        <?= get_field('product_include_description2') ?>
    </div>
</div>


<?php if(have_rows('product_include_features')): ?>
    <div class="training-features">
        <div class="container">
            <div class="title"><h2>training features</h2></div>
            <ul>
                <?php while(have_rows('product_include_features')): the_row(); ?>
                    <li>
                        <h3><?= get_sub_field('product_include_features_name') ?></h3>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>


<?php
$title=get_field('product_include_cert_title');
$description=get_field('product_include_cert_description');
$icon=get_field('product_include_cert_icon');

if($description):
    ?>
    <div class="certificate section">
        <div class="container">
            <?php if(isset($icon['sizes']['medium'])): ?>
                <figure style="background-image: url('<?= $icon['sizes']['medium'] ?>');"></figure>
            <?php endif; ?>
            <div class="text">
                <?php if($title): ?>
                    <h3><?= $title ?></h3>
                <?php endif; ?>
                <p><?= $description ?></p>
            </div>
        </div>
    </div>
    <?php
endif; ?>


<div class="container">
    <?php if (have_rows('product_include_serv_services')): ?>
        <ul class="icon-list horizontal">
            <?php while(have_rows('product_include_serv_services')): the_row(); ?>
                <?php
                $title=get_sub_field('product_include_serv_services_title');
                $description=get_sub_field('product_include_serv_services_description');
                $icon=get_sub_field('icon');

                if($title && $description):
                    ?>
                    <li>
                        <?php if($icon): ?>
                            <figure style="background-image: url('<?= $icon ?>')"></figure>
                        <?php endif; ?>
                        <div class="info">
                            <h3><?= $title ?></h3>
                            <p><?= $description ?></p>
                        </div>
                    </li>
                    <?php
                endif; ?>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>
    <div class="buttons aligncenter">
       <!-- <a href="<?/*= get_field('product_include_serv_cta1_link') */?>" class="btn btn-white pricing-tab"><?/*= get_field('product_include_serv_cta1_title') */?></a>-->
        <a href="<?= add_query_arg('product_id',get_the_ID(),get_permalink(get_page_ID_by_page_template('templates/pricing.php'))) ?>" class="btn btn-white pricing-tab"><?= get_field('product_include_serv_cta1_title') ?></a>
               <a href="<?= get_field('product_include_serv_cta2_link') ?>" class="btn btn-blue" target="_blank"><?= get_field('product_include_serv_cta2_title') ?></a>
    </div>
</div>
