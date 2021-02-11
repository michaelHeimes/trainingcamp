<?php
$relation_testimonials=get_field('product_testimonials');

if ($relation_testimonials && count($relation_testimonials)>0):
    $i=0;
    ?>
    <div class="quote-slider section course-testimonials">
        <div class="container">
            <h2 class="title">Testimonials</h2>
            <div class="slides">

                <?php foreach($relation_testimonials as $testimonial_id): ?>
                    <?php
                    $author=get_field('testimonial_author',$testimonial_id);
                    $text=get_field('testimonial_text',$testimonial_id);
                    $source=get_field('testimonial_source',$testimonial_id);

                    if($author && $text): $i++;?>
                        <div class="slide">
                            <blockquote>
                                <q class="word-capitalize"><?= $text ?></q>
                                <footer>
                                    <div class="info">
                                        <cite class="word-capitalize"><?= $author ?></cite>
                                        <?php if($source): ?>
                                            <span><?= $source ?></span>
                                        <?php endif; ?>
                                    </div>
                                </footer>
                            </blockquote>
                        </div>
                    <?php endif; ?>

                <?php endforeach; ?>

            </div>
            <div class="slide-num">
                <strong class="cur-slide">01</strong>
                <strong class="slides-qty custom-testimonial-slide">0<?= $i ?></strong>
            </div>              
        </div>
    </div>
    <?php
endif; ?>

