<?php
$related_courses=get_field('product_related_courses');

if($related_courses && count($related_courses)>0){
    ?>
    <div class="container">
        <ul class="previews-list">
            <?php
            foreach($related_courses as $course_id){

                $title=get_the_title($course_id);
                $product_thumb_url=get_the_post_thumbnail_url($course_id,'prod_archive_img');
                $product_thumb_url=($product_thumb_url) ? : get_template_directory_uri().'/slice/dist/images/preview-img-1.jpg';

                $duration=get_field('product_top_duration',$course_id);
                $duration=($duration) ? (int) $duration : '';
                if(is_numeric($duration)){
                    if ($duration==1){
                        $duration=$duration.' day';
                    }else{
                        $duration=$duration.' days';
                    }
                }else{
                    $duration='';
                }
                ?>
                <li>
                    <figure style="background-image: url('<?= $product_thumb_url ?>')">
                        <a href="<?= get_permalink($course_id) ?>">more details</a>
                    </figure>
                    <div class="info">
                        <h3><?= $title ?></h3>
                        <h6><?= $duration ?></h6>
                    </div>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
    <?php
} ?>