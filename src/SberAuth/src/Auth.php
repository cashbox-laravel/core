<?php

/*
 * This file is part of the "cashier-provider/sber-auth" project.
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
 * @see https://github.com/cashier-provider/sber-auth
 */

declare(strict_types=1);

namespace CashierProvider\Sber\Auth;

use CashierProvider\Core\Facades\Helpers\Unique;
use CashierProvider\Sber\Auth\Support\Hash;
use DragonCode\Contracts\Cashier\Auth\Auth as AuthContract;
use DragonCode\Contracts\Cashier\Http\Request;
use DragonCode\Contracts\Cashier\Resources\AccessToken;
use DragonCode\Contracts\Cashier\Resources\Model;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Helpers\Arr;

/** @method static Auth make(Model $model, Request $request, bool $hash = true, array $extra = []) */
class Auth implements AuthContract
{
    use Makeable;

    /** @var \DragonCode\Contracts\Cashier\Resources\Model */
    protected $model;

    /** @var \DragonCode\Contracts\Cashier\Http\Request */
    protected $request;

    /** @var string */
    protected $scope;

    public function __construct(Model $model, Request $request, bool $hash = true, array $extra = [])
    {
        $this->model   = $model;
        $this->request = $request;

        $this->scope = Arr::get($extra, 'scope');
    }

    public function headers(): array
    {
        $token = $this->getAccessToken();

        return array_merge($this->request->getRawHeaders(), [
            'X-IBM-Client-Id' => $this->model->getClientId(),

            'Authorization' => 'Bearer ' . $token->getAccessToken(),

            'x-Introspect-RqUID' => $this->uniqueId(),
        ]);
    }

    public function body(): array
    {
        return $this->request->getRawBody();
    }

    public function refresh(): void
    {
        Hash::make()->forget($this->model, $this->scope);
    }

    protected function getAccessToken(): AccessToken
    {
        return Hash::make()->get($this->model, $this->request->uri(), $this->scope);
    }

    protected function uniqueId(): string
    {
        return Unique::id();
    }
}
