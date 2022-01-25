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

    <style>
        .teasers-container {
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
        }

        .post-teaser {
            flex-basis: 30%;
            margin: 20px;
            background-color: #FFFFFF;
        }

        .post-image div {
            width: 100%;
            height: 250px;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .post-content {
            margin: 20px;
        }

        #loader_btn {
            margin: 0 auto;
        }

        @media only screen and (max-width: 768px) {
            .post-teaser {
                flex-basis: 100%;
            }
        }

    </style>

    <div id="primary" class="content-area">
        <h1>TEST</h1>
        <main id="main" class="site-main" role="main">
            <div id="teasers" class="teasers-container">

                <?php
                $allPostsQuery = new WP_Query(array('post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => -1));
                $count_post = 1;
                while ($allPostsQuery->have_posts() and ($count_post <= 3)) :
                    $count_post++;
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
                                <div title="<?= $post_thumbnail_alt ?>"
                                     style="background-image: url('<?= $post_thumbnail_url; ?>')"></div>
                            </a>
                        <? endif ?>

                        <div class="post-content">
                            <h3><? the_title(); ?></h3>
                            <?= mb_strimwidth(get_the_content(), 0, 300, '...') ?>
                            <p><a href="<? the_permalink(); ?>">Read more</a></p>
                        </div>
                    </div>
                <?php endwhile; ?>

                <button id="loader_btn">Load more posts</button>
            </div>
        </main>
    </div>
    <script>



        document.querySelector('#loader_btn').addEventListener('click', function () {
            const xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function () {
                if (xhttp.readyState == XMLHttpRequest.DONE) {
                    if (xhttp.status == 200) {

                        var posts = JSON.parse(this.responseText);
                        var html_str = "";
                        console.log(posts);
                        document.getElementById("teasers").innerHTML = JSON.stringify(posts);

                        /*
                        TODO : Layout
                        */

                    } else if (xhttp.status == 400) {
                        console.log('There was an error 400');
                    } else {
                        console.log('something else other than 200 was returned');
                    }
                }
            };


            xhttp.open("GET", "<?=get_template_directory_uri() . '-child/RequestHandler.php' ?>", true);
            xhttp.send();


        });

    </script>

<?php get_footer(); ?>
