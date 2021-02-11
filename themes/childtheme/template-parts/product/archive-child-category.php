<?php
global $wp_query;
$current_term_id = get_queried_object()->term_id;
$term = get_term_by('id', $current_term_id, 'product_cat');
$thumbnail_id = get_woocommerce_term_meta($current_term_id, 'thumbnail_id', true);
$attach_details = ($thumbnail_id) ? wp_get_attachment_image_src($thumbnail_id, 'prod_single_img') : '';
$img_src = (isset($attach_details[0])) ? $attach_details[0] : get_template_directory_uri() . '/slice/dist/images/courses-group-bg.jpg';
?>

<!--<div class="top-bg featured page-heading" style="background-image: url('<?= $img_src ?>');">
    <div class="content-block custom-content-block">
        <h1 class="word-capitalize"><?= $term->name ?></h1>
       <!-- <p><?= $term->description ?></p> -->
    </div>
    <a href="<?= get_term_link($term->parent) ?>" class="anchor back-link">back to courses</a>
</div> -->


<div class="section  custom-section">
<div class="container" style="margin-bottom: 50px !important; ">
<div class="title">
                <h2><?= $term->name ?></h2>
            </div>
<p><?= $term->description ?></p>
</div>
    <div class="container clearfix">

        <div class="title custom-title">
            <h2>
                <?php
                $paged = max(1, $wp_query->get('paged'));
                $per_page = $wp_query->get('posts_per_page');
                $total = $wp_query->found_posts;
                $first = ($per_page * $paged) - $per_page + 1;
                $last = min($total, $wp_query->get('posts_per_page') * $paged);

                if ($total <= $per_page || -1 === $per_page) {
                    printf(_n('Showing the single result', '%d courses', $total, 'woocommerce'), $total);
                } else {
                    printf(_nx('Showing the single result','Showing ' . '%1$d&ndash;%2$d  out of %3$d '.'courses', $total, '%1$d = first, %2$d = last, %3$d = total', 'woocommerce'), $first, $last, $total);
                }
                ?>
            </h2>
        </div>


        <?php
        $taxonomy_name = 'product_tag';
        $terms = get_terms($taxonomy_name, array('parent' => 0, 'hide_empty' => 0));
        if (count($terms) > 0) {
            ?>
            <aside id="aside-filter">
                <div class="filter">
                    <form action="<?= get_term_link($current_term_id) ?>" method="get" id="filter_form">
                        <?php foreach ($terms as $parent_term): ?>

                            <?php
                            $child_terms = get_terms($taxonomy_name, array('parent' => $parent_term->term_id, 'hide_empty' => 0));
                            $checked_cats = (isset($_GET['category'])) ? $_GET['category'] : '';
                            $checked_cats = ($checked_cats) ? explode(",", $checked_cats) : array();
                            ?>

                            <?php if (count($child_terms) > 0): ?>
                                <h5><?= $parent_term->name ?></h5>

                                <div class="form-wrap">

                                    <?php foreach ($child_terms as $child_term): ?>

                                        <?php $checked = (in_array($child_term->slug, $checked_cats)) ? 'checked' : ''; ?>

                                        <div class="form-row form-row-wide">

                                            <input type="checkbox" name="category" value="<?= $child_term->slug ?>"
                                                   id="category-<?= $child_term->term_id ?>" <?= $checked ?>>
                                            <label
                                                for="category-<?= $child_term->term_id ?>"><?= $child_term->name ?></label>

                                        </div>

                                    <?php endforeach; ?>

                                </div>
                            <?php endif; ?>

                        <?php endforeach; ?>
                        <div class="buttons">
                            <button type="reset" class="filter-btn" onclick="location.href='<?= get_term_link($current_term_id) ?>';">clear all</button>
                        </div>
                    </form>
                </div>
            </aside>
            <?php
        }
        ?>


        <?php if (have_posts()): ?>

            <div id="filter-content" class="courses">
<p class="results-num"><strong style="
    font-weight: bold;
">
 <?php
                $paged = max(1, $wp_query->get('paged'));
                $per_page = $wp_query->get('posts_per_page');
                $total = $wp_query->found_posts;
                $first = ($per_page * $paged) - $per_page + 1;
                $last = min($total, $wp_query->get('posts_per_page') * $paged);
                 /*$args = array(
                        'orderby' => 'name',
                        'order' => 'DESC',
                        ); 
                        query_posts($args); */
                        
                if ($total ==1) {
printf(_n('1', '1', $total, 'woocommerce'), $total);
                } else {
                   printf(_n('', '%d', $total, 'woocommerce'), $total);
                } 
                ?>
</strong>  Course(s) Found</p>

                <ul class="courses-list" id="course-list-sort">

                    <?php while (have_posts()): the_post();

                        $duration = get_field('product_top_duration', get_the_ID());
                        $duration = ($duration) ? (int)$duration : '';
                        if (is_numeric($duration)) {
                            if ($duration == 1) {
                                $duration = $duration . ' day';
                            } else {
                                $duration = $duration . ' days';
                            }
                        } else {
                            $duration = '';
                        }
                        /*$term_list = wp_get_object_terms( et_the_ID(), $taxonomy_name, array("all"));*/
                        $args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
                        $term_list = wp_get_post_terms( get_the_ID(), $taxonomy_name, $args);
                        $term_not_nums = array();
                        if (count($term_list) > 0) {
                            $i = 0;
                            foreach ($term_list as $current_term) {
                                if ($current_term->parent != 42)
                                    $term_not_nums[] = $i;
                                $i++;
                            }
                            foreach ($term_not_nums as $num) {
                                unset($term_list[$num]);
                            }
                        }
                        ?>

                        <li>
<?php
			//	$course_url = "";
			//	$empty=(isset($_COOKIE['full_name']) && isset($_COOKIE['email']) && isset($_COOKIE['phone'])) ? false : true;
			//	if (!$empty){
				$course_url = get_permalink();
			//	}else{
			//	$course_url = get_option( 'siteurl' )."/register/?product_id=".get_the_ID();
				 ?>
                        <a href="<?= $course_url ?>">
                            <div class="info">
				<?php
			//	$course_url = "";
			//	$empty=(isset($_COOKIE['full_name']) && isset($_COOKIE['email']) && isset($_COOKIE['phone'])) ? false : true;
			//	if (!$empty){
			//	$course_url = get_permalink();
			//	}else{
			//	$course_url = get_option( 'siteurl' )."/register/?product_id=".get_the_ID();
				 ?>

                          <!--      <h3><a href="<?= $course_url ?>"><?= get_the_title() ?></a></h3>  -->
				<h3><?= get_the_title() ?></h3>

                                <h5><?= $duration ?></h5>

                           <!--     <p><?php the_excerpt() ?></p> -->
				    <p><?php echo content(50); ?></p>

                                <?php if (is_array($term_list) && count($term_list) > 0): ?>
                                    <ul class="tags">
                                        <?php foreach ($term_list as $current_term): ?>
                                            <li><?= $current_term->name ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
			</a>
                        </li>

                    <?php endwhile; ?>
                </ul>


                <?php if (function_exists('wp_pagenavi')) wp_pagenavi(); ?>


            </div>

        <?php else: ?>

            <div class="courses">
                <p class="not-found">Nothing found!</p>
            </div>

        <?php endif; ?>

    </div>
</div>

<script>
    var form = $('form#filter_form');
    form.find('input[type="checkbox"]').change(function () {
        form.submit();
    });
    form.submit(function () {
        //get all field values
        var query = "category="; //write here parameter name
        $("form#filter_form [name=category]:checked").each(function (i) { //it will check for all elements inside form with name "id"
            query += $(this).val() + ",";
        });
        query = query.slice(0, -1); //remove last extra comma
        //redirect url by passing "query" as GET parameter
        window.location = $(this).attr("action") + "?" + query;
        return false;
    });
    $(document).ready(function(){
        
        if(window.location.pathname.indexOf("by-topic")>0 || window.location.pathname.indexOf("course-catalog")>0){
            $("#aside-filter").css('display','');
        }else{
            $("#aside-filter").css('display','none');
            $("#filter-content").css('width','100%');
            $("#filter-content").css('padding-right:','0px');
        }
        
        sortList();
        function sortList() {
                var list, i, switching, b, shouldSwitch;
                list = document.getElementById("course-list-sort");
                switching = true;
                /*Make a loop that will continue until
                no switching has been done:*/
                while (switching) {
                    //start by saying: no switching is done:
                    switching = false;
                    b = list.getElementsByTagName("LI");
                    //Loop through all list-items:
                    for (i = 0; i < (b.length - 1); i++) {
                    //start by saying there should be no switching:
                    shouldSwitch = false;
                    /*check if the next item should
                    switch place with the current item:*/
                    if (b[i].getElementsByTagName("h3")[0].innerText.toLowerCase() > b[i+1].getElementsByTagName("h3")[0].innerText.toLowerCase()) {
                        /*if next item is alphabetically
                        lower than current item, mark as a switch
                        and break the loop:*/
                        shouldSwitch = true;
                        break;
                    }
                    }
                    if (shouldSwitch) {
                    /*If a switch has been marked, make the switch
                    and mark the switch as done:*/
                    b[i].parentNode.insertBefore(b[i + 1], b[i]);
                    switching = true;
                    }
                }
        }
     });
</script>
