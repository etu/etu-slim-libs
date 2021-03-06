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

namespace Etu\Slim\Exceptions;

use Psr\Log\LogLevel;
use Throwable;

/**
 * InternalServerErrorException will log with context at ERROR level and return a "500 Internal Server Error" to the
 * client.
 */
final class InternalServerErrorException extends ContextAwareException
{
    /**
     * @param array<string, mixed> $context
     */
    public function __construct(string $message, array $context = [], ?Throwable $previous = null)
    {
        parent::__construct($message, 500, LogLevel::ERROR, $context, $previous);
    }
}
