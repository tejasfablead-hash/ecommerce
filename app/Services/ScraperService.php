<?php

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\Product;
use GuzzleHttp\Exception\RequestException;

class ScraperService
{
    protected $url;

    public function __construct()
    {
        $this->url = 'http://books.toscrape.com/catalogue/category/books_1/index.html';
    }

    public function scrape()
    {
        $client = new Client();

        try {
            $response = $client->get($this->url);
            $html = $response->getBody()->getContents();

            $crawler = new Crawler($html);

            $products = $crawler->filter('article.product_pod')->each(function (Crawler $node) {
                $titleNode = $node->filter('h3 a');
                $title = $titleNode->attr('title');

                $priceText = $node->filter('p.price_color')->text(); // "£51.77"
                $price = floatval(str_replace('£', '', $priceText)); // 51.77 as decimal

                $imageNode = $node->filter('.image_container img');
                $image = $imageNode->attr('src');
                $image = 'http://books.toscrape.com/' . preg_replace('/^\.\.\//', '', $image);

                return [
                    'name' => $title,
                    'price' => $price,
                    'qty' => 10,
                    'image' => json_encode([$image]),
                    'status' => 'active'
                ];
            });


            foreach ($products as $p) {
                Product::updateOrCreate(
                    ['name' => $p['name']],
                    [
                        'price' => $p['price'],
                        'qty' => $p['qty'],
                        'image' => $p['image'],
                        'status' => $p['status'],
                        'category_id' => 19
                    ]
                );
            }

            return ['status' => true, 'products' => $products];
        } catch (RequestException $e) {
            return [
                'status' => false,
                'message' => 'Could not fetch products. Check URL or network.',
                'error' => $e->getMessage()
            ];
        }
    }
}
