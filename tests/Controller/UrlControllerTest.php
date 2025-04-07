<?php

namespace App\Tests\Controller;

use App\Entity\Url;
use JsonException;
use App\Repository\UrlRepository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UrlControllerTest extends WebTestCase
{
    private const TEST_URL = 'https://www.google.com/search?q=jsdfksfjdskfljldjljlkjkfjsalfjdjsfsklfjkdl';

    /**
     * @throws JsonException
     */
    public function testShorten(): string
    {
        $client = static::createClient();

        $client->request('POST', '/shorten', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode(['url' => self::TEST_URL], JSON_THROW_ON_ERROR));

        $this->assertResponseIsSuccessful();

        $responseContent = $client->getResponse()->getContent();
        $this->assertJson($responseContent);

        $responseData = json_decode($responseContent, true, 512, JSON_THROW_ON_ERROR);
        $this->assertArrayHasKey('short_url', $responseData);
        // Return short url for further tests (redirect below)
        return $responseData['short_url'];

    }

    /**
     * @depends testShorten
     */
    public function testRedirect(string $shortUrl): void
    {
        $container = static::getContainer();
        /** @var UrlRepository $urlRepository */
        $urlRepository = $container->get(UrlRepository::class);
        $shortCode = basename(parse_url($shortUrl, PHP_URL_PATH));
        /** @var Url $urlEntity */
        $urlEntity = $urlRepository->findByShortCode($shortCode);
        $this->assertNotNull($urlEntity, 'URL entity should not be null');
        $this->assertSame(self::TEST_URL, $urlEntity->getOriginalUrl(), 'Stored long URL should match the test URL');


    }
}
