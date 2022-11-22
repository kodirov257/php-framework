<?php

namespace Framework\Http;

use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\StreamFactory;
use Laminas\Diactoros\UploadedFileFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestAdaptor
{
    public static function getPsrRequest(): ServerRequestInterface
    {
        $symfonyRequest = new Request([], [], [], [], [], ['HTTP_HOST' => 'dunglas.fr'], 'Content');
        // The HTTP_HOST server key must be set to avoid an unexpected error

        $psrHttpFactory = self::getPsrHttpFactory();

        return $psrHttpFactory->createRequest($symfonyRequest);
    }

    public static function getPsrResponse(): ResponseInterface
    {
        $symfonyResponse = new Response('Content');

        $psrHttpFactory = self::getPsrHttpFactory();

        return $psrHttpFactory->createResponse($symfonyResponse);
    }

    public static function getSymfonyRequest(ServerRequestInterface $psrRequest = null): Request
    {
        $httpFoundationFactory = new HttpFoundationFactory();

        return $httpFoundationFactory->createRequest($psrRequest ?? self::getPsrRequest());
    }

    public static function getSymfonyResponse(ResponseInterface $psrResponse = null): Response
    {
        $httpFoundationFactory = new HttpFoundationFactory();

        return $httpFoundationFactory->createResponse($psrResponse ?? self::getPsrResponse());
    }

    private static function getPsrHttpFactory(): PsrHttpFactory
    {
        $psrRequestFactory = new ServerRequestFactory();
        $psrStreamFactory = new StreamFactory();
        $psrUploadedFileFactory = new UploadedFileFactory();
        $psrResponseFactory = new ResponseFactory();

        return new PsrHttpFactory($psrRequestFactory, $psrStreamFactory, $psrUploadedFileFactory, $psrResponseFactory);
    }
}