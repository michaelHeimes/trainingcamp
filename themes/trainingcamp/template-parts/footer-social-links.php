<?php
$facebook=get_field('link_facebook','options');
$instagram=get_field('link_insta','options');
$pinterest=get_field('link_pinterest','options');
$twitter=get_field('link_twit','options');
?>
<div class="social-links">
    <ul>
        <?php if($facebook): ?>
            <li>
                <a href="<?= $facebook ?>" target="_blank" title="Facebook">
                    <?php get_template_part('template-parts/icons/icon','facebook') ?>
                </a>
            </li>
        <?php endif; ?>

        <?php if($instagram): ?>
            <li>
                <a href="<?= $instagram ?>" target="_blank" title="Instagram">
                    <?php get_template_part('template-parts/icons/icon','instagram') ?>
                </a>
            </li>
        <?php endif; ?>

        <?php if($pinterest): ?>
            <li>
                <a href="<?= $pinterest ?>" target="_blank" title="Pinterest">
                    <?php get_template_part('template-parts/icons/icon','pinterest') ?>
                </a>
            </li>
        <?php endif; ?>

        <?php if($twitter): ?>
            <li>
                <a href="<?= $twitter ?>" target="_blank" title="Twitter">
                    <?php get_template_part('template-parts/icons/icon','twitter') ?>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>