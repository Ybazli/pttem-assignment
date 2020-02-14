<?php


    namespace App\Tests;


    use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as TestCase;


    class ProductTest extends TestCase
    {

        /** @test */
        public function test_products_list()
        {
            $client = static::createClient();
            $client->request('GET', '/api/products');
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
        }

        /** @test */
        public function the_index_api_page_most_have_products_and_has_properties()
        {

            $client = static::createClient();
            $client->request('GET', '/api/products.json');

            $content = json_decode($client->getResponse()->getContent(), true);
            $this->assertNotEquals(0, count($content));

            $productProperties = ['name', 'url', 'image', 'description', 'provider', 'availability', 'category', 'created_at'];

            foreach ($productProperties as $property) {
                $this->assertArrayHasKey($property, $content[0]);
            }
        }

        /** @test */
        public function test_api_create_product()
        {
            $data = [
                'name' => 'my product',
                'description' => 'this is test product',
                'image' => '',
                'provider' => 'ybazli',
                'category' => 'test',
                'availability' => true,
                'price' => 10.5
            ];
            $client = static::createClient();
            $client->request('POST',
                '/api/products.json',
                [],
                [],
                ['CONTENT_TYPE' => 'application/json'],
                json_encode($data)
            );

            $this->assertEquals(201, $client->getResponse()->getStatusCode());
            $responseContent = json_decode($client->getResponse()->getContent());
            $this->assertEquals($data['name'], $responseContent->name);
            $this->assertEquals($data['description'], $responseContent->description);
            $this->assertNotEmpty($responseContent->created_at);
            $this->assertNotEmpty($responseContent->url);
        }

        /** @test */
        public function test_delete_product_and_created_product_most_not_list()
        {
            $data = [
                'name' => 'this is most deleted',
                'description' => 'this is test product',
                'image' => '',
                'provider' => 'ybazli',
                'category' => 'test',
                'availability' => true,
                'price' => 10.5
            ];
            $client = static::createClient();
            $client->request('POST',
                '/api/products.json',
                [],
                [],
                ['CONTENT_TYPE' => 'application/json'],
                json_encode($data)
            );
            $this->assertEquals(201, $client->getResponse()->getStatusCode());
            $responseContent = json_decode($client->getResponse()->getContent());
            $client->request('DELETE', '/api/products/' . $responseContent->id . '.json');
            $this->assertEquals(204, $client->getResponse()->getStatusCode());

            $client->request('GET', '/api/products.json');
            $responseContent = json_decode($client->getResponse()->getContent(), true);
            $this->assertNotEquals($data['name'], $responseContent[0]['name']);
        }

        /** @test */
        public function test_create_a_product_and_update_one_property_put_method()
        {
            $data = [
                'name' => 'this none updated product',
                'description' => 'this is test product',
                'image' => '',
                'provider' => 'ybazli',
                'category' => 'test',
                'availability' => true,
                'price' => 10.5
            ];
            $client = static::createClient();
            $client->request('POST',
                '/api/products.json',
                [],
                [],
                ['CONTENT_TYPE' => 'application/json'],
                json_encode($data)
            );
            $this->assertEquals(201, $client->getResponse()->getStatusCode());

            $responseContent = json_decode($client->getResponse()->getContent());
            $updatedData = [
                'name' => 'this updated product'
            ];

            $client->request('PUT',
                '/api/products/' . $responseContent->id . '.json',
                [],
                [],
                ['CONTENT_TYPE' => 'application/json'],
                json_encode($updatedData)
            );

            $this->assertEquals(200, $client->getResponse()->getStatusCode());

            $updatedResponse = json_decode($client->getResponse()->getContent());
            $this->assertEquals($updatedResponse->name , $updatedData['name']);
            $this->assertNotEquals($data['name'] , $updatedResponse->name);

        }

        /** @test */
        public function test_create_a_product_and_update_more_than_one_properties_patch_method()
        {
            $data = [
                'name' => 'this none updated product',
                'description' => 'this is test product',
                'image' => '',
                'provider' => 'ybazli',
                'category' => 'test',
                'availability' => true,
                'price' => 10.5
            ];
            $client = static::createClient();
            $client->request('POST',
                '/api/products.json',
                [],
                [],
                ['CONTENT_TYPE' => 'application/json'],
                json_encode($data)
            );
            $this->assertEquals(201, $client->getResponse()->getStatusCode());

            $responseContent = json_decode($client->getResponse()->getContent());
            $updatedData = [
                'name' => 'this updated product',
            ];

            $client->request('PATCH',
                '/api/products/' . $responseContent->id . '.json',
                [],
                [],
                ['CONTENT_TYPE' => 'application/merge-patch+json'],
                json_encode($updatedData)
            );

            $this->assertEquals(200, $client->getResponse()->getStatusCode());

            $updatedResponse = json_decode($client->getResponse()->getContent());
            $this->assertEquals($updatedResponse->name , $updatedData['name']);
            $this->assertNotEquals($data['name'] , $updatedResponse->name);

        }

    }