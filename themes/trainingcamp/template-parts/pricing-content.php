<div class="container">

    <div class="bread-crumbs">
        <ul>
            <li><a href="<?= site_url() ?>">Home</a></li>
            <li><?= get_the_title() ?></li>
        </ul>
    </div>


    <div class="title">
        <h2><?= get_the_title() ?></h2>
        <h3>Please select a course of interest</h3>
    </div>


    <?php
    $tax = 'product_cat';
    $parent_terms = get_terms($tax, array('parent' => 0, 'hide_empty' => 0, 'exclude'=>array(11,12,35)));
    $category_html="";
    if(count($parent_terms)>0){
        $category_html.='<select name="product_category" id="select-1" class="dropdown">';
        $category_html.='<option value="">Certification or Vendor</option>';
        foreach ($parent_terms as $parent_term){
            $child_terms = get_terms($tax, array('parent' => $parent_term->term_id, 'hide_empty' => 1));
            if(count($child_terms)>0){
                $category_html.='<optgroup label="'.$parent_term->name.'">';
                foreach($child_terms as $child_term){
                    $category_html.='<option value="'.$child_term->term_id.'">'.$child_term->name.'</option>';
                }
                $category_html.='</optgroup>';
            }
        }
        $category_html.='</select>';
    }


    $visible_fields=array(
        'full_name'=>array('placeholder'=>'first & last name*','type'=>'text','value'=>''),
        'email'=>array('placeholder'=>'Email Address*','type'=>'email','value'=>''),
        'phone'=>array('placeholder'=>'Phone Number*','type'=>'text','value'=>''),
    );
    $empty=(isset($_COOKIE['full_name']) && isset($_COOKIE['email']) && isset($_COOKIE['phone'])) ? false : true;
    if (!$empty){
        foreach($visible_fields as $name=>$data){
            $visible_fields[$name]['value']=$_COOKIE[$name];
        }
    }
    $empty_field_value=!$empty ? 'yes' : 'no';


    $disabled='disabled="disabled"';
    $class="not-allowed";
    $one_product_html='';
    if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])){
        $product=wc_get_product($_GET['product_id']);
        $product_name=is_object($product) ? $product->get_name() : '';
        if ($product_name){
            $disabled='';
            $class="";
            $one_product_html='<option value="'.$_GET['product_id'].'" selected="selected">'.$product_name.'</option>';
        }
    }
    ?>


    <div class="tab-wrap">

        <div class="tab-nav">

            <form action="" id="select-product">

                <?php if (isset($_GET['noreq']) && '1'===$_GET['noreq']): ?>

                    <input type="hidden" name="noreq" value="yes">

                <?php else: ?>

                    <?php foreach($visible_fields as $name=>$data): ?>
                        <p class="form-row form-row-wide">
                            <input type="<?= $data['type'] ?>" id="<?= $name ?>" title=" " name="<?= $name ?>" class="form-control" placeholder="<?= $data['placeholder'] ?>" value="<?= $data['value'] ?>" required>
                            <label for="<?= $name ?>"><?= $data['placeholder'] ?></label>
                        </p>
                    <?php endforeach ?>

                    <input type="hidden" name="kvalue" value="<?= rand(1,10) ?>">

                    <input type="hidden" name="user_ip" value="<?= $_SERVER['REMOTE_ADDR'] ?>">

                    <input type="hidden" name="from_cookies" value="<?= $empty_field_value ?>">

                    <input type="hidden" name="noreq" value="no">

                <?php endif; ?>

                <div class="form-row">
                    <?= $category_html ?>
                </div>

                <div class="form-row <?= $class ?>">
                    <select name="products" id="select-2" class="dropdown" <?= $disabled ?> title="Please choose a course!" required>
                        <option value="">Course of interest</option>
                        <?= $one_product_html ?>
                    </select>
                </div>

                <div class="form-row <?= $class ?>">
                    <button type="submit" class="btn btn-blue" <?= $disabled ?>>Show Schedule & Pricing</button>
                </div>

                <div class="errors_wrap"></div>
            </form>

        </div>

        <?php /* ?>
        <form method="post" action="/cart/" class="add_to_cart_form">
            <button type="submit" class="single_add_to_cart_button button alt btn btn-blue">Add to cart</button>
            <input type="hidden" name="add-to-cart" value="245">
            <input type="hidden" name="product_id"  value="245">
            <input type="hidden" name="variation_id" class="variation_id" value="251">
            <input type="hidden" name="attribute_pa_location" value="bashkill-pa">
        </form>
        <?php */ ?>


        <div class="tab-content active">
            <?php
            $thumb_url=get_the_post_thumbnail_url(get_the_ID(),'full');
            $thumb_url=($thumb_url) ? : get_template_directory_uri().'/slice/dist/images/training-courses-bg.jpg';
            ?>
            <div class="img-block" style="background-image: url('<?= $thumb_url ?>')"></div>
            <div class="columns">
                <h2><?= get_field('pricing_subtitle') ?></h2>
                <div class="col">
                    <?= get_field('pricing_description_1') ?>
                </div>
                <div class="col">
                    <?= get_field('pricing_description_2') ?>
                </div>
            </div>
        </div>


        <div class="tab-content pricing-schedules" id="pricing-schedules">
            <div class="shop-app"></div>
        </div>

    </div>
</div>