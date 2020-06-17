<?php

declare(strict_types=1);

/**
 * Fangx's Packages
 *
 * @link     https://github.com/fangx-packages/hyperf-resource
 * @document https://github.com/fangx-packages/hyperf-resource/blob/master/README.md
 * @contact  nfangxu@gmail.com
 * @author   nfangxu
 */

namespace Fangx\Resource\Response;

use Hyperf\Database\Model\Model;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Hyperf\Utils\Codec\Json;
use Hyperf\Utils\Collection;
use Hyperf\Utils\Context;

class HttpResponse
{
    /**
     * The underlying resource.
     *
     * @var mixed
     */
    public $resource;

    /**
     * Create a new resource response.
     *
     * @param mixed $resource
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public function toResponse()
    {
        return $this->response()
            ->withStatus($this->calculateStatus())
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withBody(new SwooleStream(Json::encode($this->wrap(
                $this->resource->resolve(),
                $this->resource->with(),
                $this->resource->additional
            ))));
    }

    /**
     * Wrap the given data if necessary.
     *
     * @param array $data
     * @param array $with
     * @param array $additional
     * @return array
     */
    protected function wrap($data, $with = [], $additional = [])
    {
        if ($data instanceof Collection) {
            $data = $data->all();
        }

        if ($this->haveDefaultWrapperAndDataIsUnwrapped($data)) {
            $data = [$this->wrapper() => $data];
        } elseif ($this->haveAdditionalInformationAndDataIsUnwrapped($data, $with, $additional)) {
            $data = [($this->wrapper() ?? 'data') => $data];
        }

        return array_merge_recursive($data, $with, $additional);
    }

    /**
     * Determine if we have a default wrapper and the given data is unwrapped.
     *
     * @param array $data
     * @return bool
     */
    protected function haveDefaultWrapperAndDataIsUnwrapped($data)
    {
        return $this->wrapper() && !array_key_exists($this->wrapper(), $data);
    }

    /**
     * Determine if "with" data has been added and our data is unwrapped.
     *
     * @param array $data
     * @param array $with
     * @param array $additional
     * @return bool
     */
    protected function haveAdditionalInformationAndDataIsUnwrapped($data, $with, $additional)
    {
        return (!empty($with) || !empty($additional)) &&
            (!$this->wrapper() ||
                !array_key_exists($this->wrapper(), $data));
    }

    /**
     * Get the default data wrapper for the resource.
     *
     * @return string
     */
    protected function wrapper()
    {
        return $this->resource->wrap;
    }

    protected function calculateStatus()
    {
        return $this->resource->resource instanceof Model &&
        $this->resource->resource->wasRecentlyCreated ? 201 : 200;
    }

    protected function response(): ResponseInterface
    {
        return Context::get(ResponseInterface::class);
    }
}
