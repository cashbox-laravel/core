<?php

namespace Helldar\Cashier\Contracts;

use Helldar\Cashier\DTO\Response;
use Illuminate\Database\Eloquent\Model;

interface Driver
{
    /** @return \Helldar\Cashier\Contracts\Driver */
    public static function make();

    public function model(Model $model, string $request): self;

    public function auth(Auth $auth): self;

    public function statuses(): Statuses;

    public function host(): string;

    public function init(): Response;

    public function check(): Response;

    public function refund(): Response;
}
