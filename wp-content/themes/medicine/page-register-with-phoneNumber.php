<!DOCTYPE html>
<html <?php language_attributes();?> class="register-phone-html">
    <head id="projectName" name="<?php echo get_bloginfo('home');?>">
        <meta charset="<?php bloginfo('charset');?>">
        <meta name="viewport" content="width=deviice-width,initial-scale=1">
        <?php wp_head();?>
    </head>
    <body <?php body_class();?> class="register-body"></body>
        <header class="site-header" style="display:none">
        <div class="container">
            <h1 class="school-logo-text float-left">
                <a href="<?php echo site_url()?>"><strong>三医联动</strong></a>
            </h1>
            <i class="site-header__menu-trigger gg-details-more" aria-hidden="true"></i>
            <div class="site-header__menu group">
                <nav class="main-navigation">
                    <ul>
                        <li <?php //用于使导航条在当前页面点亮
                        if(is_page('about-us')||wp_get_post_parent_id(get_the_ID())==17) echo 'class="current-menu-item"'; ?>><a href="<?php echo site_url('/about-us')?>">关于我们</a></li>
                        <li <?php if(get_post_type()=='policy'||is_post_type_archive('policy')) echo "class='current-menu-item'";?>><a href="<?php echo get_post_type_archive_link('policy');?>">相关政策</a></li>
                        <li <?php if(get_post_type()=='notice'||is_post_type_archive('notice'))echo "class='current-menu-item'";?>><a href="<?php echo get_post_type_archive_link('notice');?>">报销须知</a></li>
                        <li <?php if(get_post_type()=='question'||is_post_type_archive('question')) echo "class='current-menu-item'"; ?>><a href="<?php echo get_post_type_archive_link('question')?>">热门问题</a></li>
                        <li <?php if(get_the_ID()==2095) echo "class='current-menu-item'"; ?>><a href="<?php echo site_url('/viewing-history');?>">浏览历史</a></li>
                        <?php
                            if(!is_page('home')){
                                ?>
                                <li id="site-search"><i class="gg-search" aria-hidden="true"></i></li>                                
                            <?php }
                        ?>
                    </ul>
                </nav>
                <div class="site-header__util">
                    <?php 
                        if(is_user_logged_in()){?>
                            <a href="<?php echo wp_logout_url();?>" class=" btn btn--small btn--orange float-left push-right">
                                <span class="btn__text">登出</span>
                            </a>
                        <?php }else{?>
                            <a href="<?php echo wp_login_url();?>" class="btn btn--small btn--orange float-left push-right">登录</a>
                            <a href="<?php echo wp_registration_url();?>" class="btn btn--small btn--dark-orange float-left">注册</a>        
                        <?php }
                    ?>
                </div>
            </div>
        </div>
        </header>
    
    <form name="registerform-phoneNumber" id="registerform-phoneNumber" method="post">
        <span class="login-phone-title">手机注册</span>
        <p>
        <label>手机号</label>
        <div class="phone-prefix">
            <select name="phone_prefix" class="phone-prefix-select">
                <option value="+852">+852</option>
                <option value="+86">+86</option>
            </select>
            <input type="text" name="register_phoneNo" id="user_login_phoneNo" class="input phone-input" value="<?php echo esc_attr( wp_unslash( $user_login ) ); ?>" size="20" autocapitalize="off" required="required" placeholder="当前只支持香港手机号" />
        </div>
        </p>
        <p>
            <label for="user_password">密码</label>
            <input type="password" name="user_password" id="user_password" class="input" required="required" />
            
        </p>
        <small id="password-feedback"></small>
        <p>
            <label for="verify_user_password">确认密码</label>
            <input type="password" name="verify_user_password" id="verify_user_password" class="input" size="20" required="required" />
        </p>
        <small id="confirm-password-feedback"></small> <!-- 新增反馈元素 -->
        <p class="submit-phone">
            <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="获取验证码" />
        </p>
        <p id="nav">
            <a class="wp-login-log-in" href="<?php echo esc_url( wp_login_url() ); ?>">已有账号？点击<?php _e( 'Log in' ); ?></a>
        </p>
    </form>
    <!-- Hidden form for verification code -->
    <div id="verification-section" style="display: none;">
        <form class="phone-number-verify-form" id="registerform-phoneNumber">
            <p>
                <span>请输入验证码</span>
                <small id="phone-verify-code-notice">退出网页则验证码失效</small>

                <input type="text" name="verify_phone_key" id="verify_phone_key" class="input" size="20" required="required" />
            </p>
            <p class="submit-verification">
                <input type="submit" name="wp-submit" id="verify-submit" class="button button-primary button-large" value="注册" />
            </p>
        </form>
    </div>




<?php wp_footer();?>
</body>
</html>