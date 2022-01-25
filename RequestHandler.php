<?php
/**
 * Created by PhpStorm.
 * User: Marvin
 * Date: 25.01.22
 * Time: 14:17
 */


header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

class global_posts_search
{
    private $url;
    private $data;
    private $max;
    private $posts_limit;

    public function __construct($posts_limit)
    {
        $this->posts_limit = $posts_limit;
        $this->url = 'http://localhost/WORDPRESS/wordpress';
    }

    public function search()
    {
        echo json_encode($this->get_posts());
        exit();
    }


    private function get_posts()
    {
        $url = $this->url . '/wp-json/wp/v2/posts?per_page=' . $this->posts_limit . '&_embed';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        curl_close($ch);

        $json = json_decode($result, true);
        $posts = [];

        foreach ($json as $post) {

            $posts[] = [
                'id' => $post['id'],
                'title' => $post['title'],
                'content' => $post['content'],
                'link' => $post['link'],
                'image_src' => $post['_embedded']['wp:featuredmedia']['0']['source_url'],
            ];
        }

        return $posts;
    }
}

(new global_posts_search(10))->search();

echo json_encode(['status' => 'error']);
