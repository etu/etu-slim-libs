<?php

/**
 * Etu's Slim Framework 4 Libraries.
 *
 * MIT License
 *
 * Copyright (c) 2021 Elis Hirwing <elis@hirwing.se>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 */

declare(strict_types=1);

namespace Etu\Slim\Handlers;

use DivisionByZeroError;
use Error;
use Etu\Slim\Exceptions\ContextAwareException;
use Etu\Slim\Exceptions\DivisionByZeroException;
use Etu\Slim\Exceptions\InternalServerErrorException;
use Etu\Slim\Exceptions\ParseException;
use Etu\Slim\Helpers\Responses;
use ParseError;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LogLevel;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpNotImplementedException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Handlers\ErrorHandler as SlimErrorHandler;
use Throwable;

/**
 * A custom Error Handler based on the one shipped with Slim, but it does a few things differently.
 *
 * For once: It always responds in json format.
 *
 * Then it always tries to map a proper class for different kinds of errors.
 *
 * It also logs to monolog with the proper log level depending on exception depending on error and logs with context
 * that was part of triggering the error.
 */
class HttpErrorHandler extends SlimErrorHandler
{
    protected function respond(): Response
    {
        $exception = $this->replaceException($this->exception);

        $message = $exception->getMessage();
        $context = [];
        $statusCode = 500;

        if ($exception instanceof ContextAwareException) {
            $statusCode = $exception->getCode();

            if ($this->displayErrorDetails) {
                $context = $exception->getContext();
            }
        }

        // Set status codes based on exception types
        $statusCode = match (get_class($exception)) {
            HttpBadRequestException::class => 400,
            HttpUnauthorizedException::class => 401,
            HttpForbiddenException::class => 403,
            HttpNotFoundException::class => 404,
            HttpMethodNotAllowedException::class => 405,
            HttpInternalServerErrorException::class => 500,
            HttpNotImplementedException::class => 501,
            default => $statusCode,
        };

        // Create a new response
        $response = $this->responseFactory->createResponse();

        return Responses::withError($response, $statusCode, array_filter([
            'message' => $message,
            'context' => $context,
        ]));
    }

    protected function logError(string $error): void
    {
        $exception = $this->replaceException($this->exception);

        $context = [];
        $logLevel = LogLevel::ERROR;

        if ($exception instanceof ContextAwareException) {
            $context = $exception->getContext();
            $logLevel = $exception->getLogLevel();
        }

        $this->logger->log($logLevel, $exception->getMessage(), $context);
    }

    protected function replaceException(Throwable $exception): Throwable
    {
        return match (get_class($exception)) {
            DivisionByZeroError::class => new DivisionByZeroException($exception->getMessage(), [], $exception),
            ParseError::class => new ParseException($exception->getMessage(), [], $exception),
            Error::class => new InternalServerErrorException($exception->getMessage(), [], $exception),
            default => $exception,
        };
    }
}
