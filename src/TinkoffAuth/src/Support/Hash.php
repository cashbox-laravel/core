<?php

/*
 * This file is part of the "cashier-provider/tinkoff-auth" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@ai-rus.com>
 *
 * @copyright 2021 Andrey Helldar
 *
 * @license MIT
 *
 * @see https://github.com/cashier-provider/tinkoff-auth
 */

namespace CashierProvider\Tinkoff\Auth\Support;

use CashierProvider\Tinkoff\Auth\Constants\Keys;
use CashierProvider\Tinkoff\Auth\Resources\AccessToken;
use DragonCode\Contracts\Cashier\Resources\Model;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Helpers\Ables\Arrayable;

class Hash
{
    use Makeable;

    public function get(Model $model, array $data, bool $hash = true): AccessToken
    {
        return $this->makeToken($model->getClientId(), $model->getClientSecret(), $data, $hash);
    }

    protected function makeToken(string $client_id, string $secret, array $data, bool $hash): AccessToken
    {
        return $hash
            ? $this->hashed($client_id, $secret, $data)
            : $this->basic($client_id, $secret);
    }

    protected function basic(string $client_id, string $secret): AccessToken
    {
        return $this->items($client_id, $secret);
    }

    protected function hashed(string $client_id, string $secret, array $data): AccessToken
    {
        $hash = $this->hash($client_id, $secret, $data);

        return $this->items($client_id, $hash);
    }

    protected function hash(string $client_id, string $secret, array $data): string
    {
        $items = $this->prepare($client_id, $secret, $data);

        return hash('sha256', implode('', $items));
    }

    protected function prepare(string $client_id, string $secret, array $data): array
    {
        return Arrayable::of($data)
            ->set(Keys::TERMINAL, $client_id)
            ->set(Keys::PASSWORD, $secret)
            ->ksort()
            ->values()
            ->get();
    }

    protected function items(string $client_id, string $access_token): AccessToken
    {
        return AccessToken::make(compact('client_id', 'access_token'));
    }
}
