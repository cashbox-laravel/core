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

namespace CashierProvider\Sber\Auth\Http;

use CashierProvider\Core\Facades\Config\Main;
use CashierProvider\Core\Http\Request as BaseRequest;
use Helldar\Contracts\Cashier\Resources\Model;

/**
 * @method static Request make(Model $model)
 */
class Request extends BaseRequest
{
    protected $path = 'ru/prod/tokens/v2/oauth';

    protected $grant_type = 'client_credentials';

    protected $scope;

    public function setHost(string $host): self
    {
        $this->production_host = $host;
        $this->dev_host        = $host;

        return $this;
    }

    public function setScope(string $scope): self
    {
        $this->scope = $scope;

        return $this;
    }

    public function getRawHeaders(): array
    {
        return [
            'Accept' => 'application/json',

            'Content-Type' => 'application/x-www-form-urlencoded',

            'X-IBM-Client-Id' => $this->model->getClientId(),

            'Authorization' => 'Basic ' . $this->authorization(),

            'RqUID' => $this->model->getUniqueId(true),
        ];
    }

    public function getRawBody(): array
    {
        return [
            'grant_type' => $this->grant_type,
            'scope'      => $this->scope,
        ];
    }

    public function getHttpOptions(): array
    {
        if (Main::isProduction()) {
            return [
                'cert' => [
                    $this->model->getCertificatePath(),
                    $this->model->getCertificatePassword(),
                ],
            ];
        }

        return [];
    }

    protected function authorization(): string
    {
        return base64_encode($this->model->getClientId() . ':' . $this->model->getClientSecret());
    }
}
