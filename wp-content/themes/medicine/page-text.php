<?php
    get_header();
    while(have_posts()){
        the_post();
        pageBanner(array(
        ));
        ?>
        <div class="container container--narrow page-section">
        <?php 
            $parent_id = wp_get_post_parent_id(get_the_ID());
            if($parent_id){?>
                <div class="metabox metabox--position-up metabox--with-home-link">
                    <p>
                        <a class="metabox__blog-home-link" href="<?php echo get_permalink($parent_id);?>">
                            <i class="fa fa-home" aria-hidden="true"4f></i>
                            <?php echo get_the_title($parent_id);?>
                        </a> 
                        <span class="metabox__main"><?php the_title();?></span>
                    </p>
                </div>                
            <?php }
        ?>
        <div class="generic-content">
            <input type="text" id="phoneNumber" placeholder="Enter your phone number">  
            <button id="sendBtn">Send SMS</button>  
        </div>
    </div>

    <?php }
    get_footer();
?>

