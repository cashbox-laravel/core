<?php

namespace Helldar\Cashier\Contracts;

use Helldar\Cashier\Resources\Response;
use Illuminate\Database\Eloquent\Model;

interface Driver
{
    /** @return \Helldar\Cashier\Contracts\Driver */
    public static function make();

    public function response(array $data, bool $mapping = true): Response;

    public function model(Model $model, string $request): self;

    public function auth(Auth $auth): self;

    public function statuses(): Statuses;

    public function host(): string;

    public function start(): Response;

    public function check(): Response;

    public function refund(): Response;
}
