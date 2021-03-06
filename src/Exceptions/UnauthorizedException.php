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
 * UnauthorizedException will log with context at NOTICE level and return a "401 Unauthorized" to the client.
 */
final class UnauthorizedException extends ContextAwareException
{
    /**
     * @param array<string, mixed> $context
     */
    public function __construct(string $message, array $context = [], ?Throwable $previous = null)
    {
        parent::__construct($message, 401, LogLevel::NOTICE, $context, $previous);
    }
}
