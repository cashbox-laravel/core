<?php

declare(strict_types=1);

namespace Tests\Support\Cache;

use CashierProvider\Sber\Auth\Objects\Query;
use CashierProvider\Sber\Auth\Support\Cache;
use CashierProvider\Sber\Auth\Support\Hash;
use Helldar\Contracts\Cashier\Resources\Model;
use Helldar\Contracts\Http\Builder as BuilderContract;
use Helldar\Support\Facades\Http\Builder;
use Illuminate\Support\Collection;
use Tests\TestCase;

abstract class BaseTest extends TestCase
{
    protected $uri = 'https://dev.api.sberbank.ru/ru/prod/order/v1/creation';

    protected function uri(): BuilderContract
    {
        return Builder::parse($this->uri);
    }

    protected function getCache(): string
    {
        $model = $this->model();

        $uri = Builder::parse($this->uri);

        $token = Hash::make()->get($model, $uri, self::SCOPE_CREATE);

        return $token->getAccessToken();
    }

    protected function query(Model $model, string $scope): Query
    {
        return Query::make(compact('model', 'scope'));
    }

    protected function getKey(): string
    {
        $model = $this->model();

        $query = $this->query($model, self::SCOPE_CREATE);

        return $this->key($query);
    }

    protected function key(Query $query): string
    {
        return $this->compact([
            Cache::class,
            $query->getModel()->getClientId(),
            $query->getModel()->getPaymentId(),
            $query->getScope(),
        ]);
    }

    protected function compact(array $values): string
    {
        return Collection::make($values)
            ->map(static function ($value) {
                return md5($value);
            })->implode('::');
    }
}
