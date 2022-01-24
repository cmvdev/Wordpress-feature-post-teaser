<?php
/**
 * Created by PhpStorm.
 * User: Marvin
 * Date: 23.01.22
 * Time: 10:44
 */
?>
<?php
/*
 * Template Name: Post-teasers
 * Template Post Type:page
 */
?>

<?php get_header(); ?>


    <div id="primary" class="content-area">
        <h1>TEST</h1>
        <main id="main" class="site-main" role="main">
            <div class="teasers-container">

                <?php
                $allPostsQuery = new WP_Query(array('post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => -1));
                while ($allPostsQuery->have_posts()) :
                    $allPostsQuery->the_post();
                    get_template_part('content', get_post_type());
                    ?>
                    <div class="post-teaser">
                        <? if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) :
                            $post_thumbnail_id = get_post_thumbnail_id();
                            $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
                            $post_thumbnail_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
                            ?>
                            <a class="post-image" href="<? the_permalink(); ?>">
                                <div title="<?= $post_thumbnail_alt?>" style="background-image: url('<?= $post_thumbnail_url; ?>')"></div>
                            </a>
                        <? endif ?>

                        <div class="post-content">
                            <h3><? the_title(); ?></h3>
                            <?= mb_strimwidth(get_the_content(),0,300, '...')  ?>
                            <p><a href="<? the_permalink(); ?>">Read more</a></p>
                        </div>
                    </div>

                <?php endwhile; ?>
            </div>
        </main>
    </div>

<?php get_footer(); ?>