<?php

namespace App\Controller;

use App\Repository\UrlRepository;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Url;

final class UrlController extends AbstractController
{
    #[Route('/shorten', name: 'shorten_url', methods: ["POST"])]
    public function shorten(Request $request, EntityManagerInterface $em): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return new JsonResponse(['error' => 'Invalid JSON'], 400);
        }
        $originalUrl = $data['url'] ?? null;
        if (!$originalUrl) {
            return new  JsonResponse(['error' => 'No URL provided'], 400);
        }
        $shortUrl = uniqid('abc', true);

        $url = new Url();
        $url->setOriginalUrl($originalUrl);
        $url->setShortCode($shortUrl);
        $em->persist($url);
        $em->flush();

        return new JsonResponse(
            ['short_url' => "https://yourdomain.com/redirect/$shortUrl"], 201
        );
    }

    #[Route("/redirect/{shortUrl}", name: 'redirect_url', methods: ["GET"])]
    public function redirectUrl(string $shortUrl, UrlRepository $urlRepository): JsonResponse|RedirectResponse
    {
        $url = $urlRepository->findByShortCode($shortUrl);
        if (!$url) {
            return new JsonResponse(['error' => 'URL not found'], 404);
        }

        return $this->redirect($url->getOriginalUrl());
    }
}
