<?php

namespace App\Services\ElasticSearch;

use Elastic\Elasticsearch\ClientBuilder;

class ElasticSearchService
{
    protected $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([config('services.elastic.host') . ':' . config('services.elastic.port')])
            ->build();
    }

    public function indexProduct($product)
    {
        $params = [
            'index' => 'products',
            'id'    => $product->id,
            'body'  => [
                'name_en'        => $product->name_en,
                'name_ar'        => $product->name_ar,
                'desc_en'        => $product->desc_en,
                'desc_ar'        => $product->desc_ar,
                'thumbnail'      => $product->thumbnail,
                'price'          => $product->price,
                'price_after_sale' => $product->price_after_sale,
                'discount'       => $product->discount,
                'designer_id'    => $product->designer_id,
                'country_id'     => $product->country_id,
                'vat'            => $product->vat,
                'size_id'        => $product->size_id,
                'brand_id'       => $product->brand_id,
                'vendor_id'      => $product->vendor_id,
                'seller_sku'     => $product->seller_sku,
                'status'         => $product->status,
                'model_id'       => $product->model_id,
            ]
        ];

        return $this->client->index($params);
    }

    public function search($query)
    {
        $params = [
            'index' => 'products',
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query' => $query,
                        'fields' => ['name_en', 'desc_en', 'name_ar', 'desc_ar']
                    ]
                ]
            ]
        ];

        return $this->client->search($params);
    }
}
