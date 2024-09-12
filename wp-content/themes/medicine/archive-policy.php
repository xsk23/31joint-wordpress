<?php 
get_header();
pageBanner(array(
  'title'=>'所有政策',
  'subtitle'=>'政策文件都在这啦',
));
?>
<style>
.progress-container,.progress-circle-container {  
    position: absolute;  
    width: 100px; /* 根据需要调整 */  
    height: 100px; /* 根据需要调整 */  
    display: none;  
    justify-content: center;  
    align-items: center;  
}  
.progress {  
    width: 50px;  
    height: 50px;  
    background: conic-gradient(green 0%, #f1f1f1 0%);  
    border-radius: 50%;  
    position: absolute;  
    transition: opacity 0.3s; /* 可选，用于平滑显示 */  
}  
.progress::before {  
    content: attr(data-progress) '%';  
    position: absolute;  
    inset: 5px;  
    background-color: #fff;  
    width: calc(100% - 10px);  
    height: calc(100% - 10px);  
    text-align: center;  
    line-height: 40px;  
    font-size: 15px;  
    color: #333;  
    border-radius: 50%;  
}  
/* 可选：为按钮添加一些样式 */  
#progressButton {  
    position: relative;  
    z-index: 1; /* 确保按钮在进度条之上 */  
    padding: 10px 20px;  
    cursor: pointer;  
}
</style>

<div class="container container--narrow page-section">
<?php 
    if(is_user_logged_in()){
        //update_posts_content();
        $current_usr=wp_get_current_user();  
        //只有管理员能上传政策
        if($current_usr->roles[0]=='administrator'){?>
            <form id="policy-submit-form" method="post" name="new-policy" enctype="multipart/form-data">
                <div class="create-note">
                    <h2 class="headline headline--small">上传新文件(最大同时上传文件数:12,点击提交后请等待五秒再按上传)</h2>
                    <input class="new-file" type="file" name="upload-policy[]" multiple>
                    <span id="submit-policy-btn" class="submit-note" value="uploaded-file">提交</span>                    
                    <div class="progress-and-btn-container">
                        <div class="progress-circle-container">
                            <div class="progress" data-progress="0"></div>
                        </div>  
                        <input id="upload-policy-btn" class="upload-policy-hide" type="submit" value="上传">  
                    </div>

                    <p class="note-limit-message">请按上传键以显示新政策</p>    
                    <?php 
                        upload_new_policies();       
                    ?>
                </div>            
            </form>
        <?php }
    }
?>
<ul class="link-list min-list" id="current_policy" >
    <?php 
        while(have_posts()){
        the_post();
        $post_date=get_post_field('post_date', get_the_ID());
        $upload_year = date("Y",strtotime($post_date));
        $upload_month = date("m",strtotime($post_date));
        $clear_title = preg_replace('/\s+/', '-',get_the_title());
        $clear_title = str_replace(array("(",")","[","]"),'',$clear_title);
        $delete_url = 'wp-content/uploads/'.$upload_year.'/'.$upload_month.'/'.$clear_title.'.';
        $file_suffix = get_the_excerpt();
        $file_download = home_url().'/wp-content/uploads/'.$upload_year.'/'.$upload_month.'/'.$clear_title.'.'.$file_suffix;
        //strtotime字面意思
        if(get_the_content()==''&&$file_suffix=='docx'){
            update_posts_content($clear_title,get_the_ID(),$upload_year,$upload_month,$file_suffix);
        }
        ?>
        <li class="policy-unit" data-content="<?php echo get_field('got_content');?>" data-file="<?php echo $file_download;?>" data-id="<?php the_ID();?>" data-delete_url="<?php echo $delete_url;?>" data-suffix="<?php echo get_the_excerpt();?>">
            <a target="_blank" href="<?php the_permalink();?>"><?php the_title();?></a>
            <?php 
                if(is_user_logged_in()){
                    if($current_usr->roles[0]=='administrator'){?>
                        <button class="delete-note delete-policy">删除</bu>
                    <?php }
                }
            ?>
        </li>
        <?php }
        echo paginate_links();
    ?>
</ul>
</div>
<?php get_footer();
?>