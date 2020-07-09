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

namespace Fangx\Resource\Json;

use ArrayAccess;
use Fangx\Resource\Concerns\ConditionallyLoadsAttributes;
use Fangx\Resource\Concerns\DelegatesToResource;
use Fangx\Resource\JsonEncodingException;
use Fangx\Resource\Response\Response;
use Hyperf\HttpMessage\Base\Response as HttpResponse;
use Hyperf\Utils\Contracts\Arrayable;
use Hyperf\Utils\Contracts\Jsonable;
use JsonSerializable;

class JsonResource extends HttpResponse implements ArrayAccess, JsonSerializable, Arrayable, Jsonable
{
    use ConditionallyLoadsAttributes;
    use DelegatesToResource;

    /**
     * The resource instance.
     *
     * @var mixed
     */
    public $resource;

    /**
     * The additional data that should be added to the top-level resource array.
     *
     * @var array
     */
    public $with = [];

    /**
     * The additional meta data that should be added to the resource response.
     *
     * Added during response construction by the developer.
     *
     * @var array
     */
    public $additional = [];

    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public $wrap = 'data';

    /**
     * Create a new resource instance.
     *
     * @param mixed $resource
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public function __toString(): string
    {
        return $this->toJson(JSON_UNESCAPED_UNICODE);
    }

    /**
     * Create a new resource instance.
     *
     * @param mixed ...$parameters
     * @return static
     */
    public static function make(...$parameters)
    {
        return new static(...$parameters);
    }

    /**
     * Create new anonymous resource collection.
     *
     * @param mixed $resource
     * @return AnonymousResourceCollection
     */
    public static function collection($resource)
    {
        return tap(new AnonymousResourceCollection($resource, static::class), function ($collection) {
            if (property_exists(static::class, 'preserveKeys')) {
                $collection->preserveKeys = (new static([]))->preserveKeys === true;
            }
        });
    }

    /**
     * Resolve the resource to an array.
     *
     * @return array
     */
    public function resolve()
    {
        $data = $this->toArray();

        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        }

        return $this->filter((array)$data);
    }

    /**
     * Transform the resource into an array.
     */
    public function toArray(): array
    {
        if (is_null($this->resource)) {
            return [];
        }

        return is_array($this->resource)
            ? $this->resource
            : $this->resource->toArray();
    }

    /**
     * Convert the model instance to JSON.
     *
     * @param int $options
     * @throws JsonEncodingException
     * @return string
     */
    public function toJson($options = 0)
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw JsonEncodingException::forResource($this, json_last_error_msg());
        }

        return $json;
    }

    /**
     * Get any additional data that should be returned with the resource array.
     *
     * @return array
     */
    public function with()
    {
        return $this->with;
    }

    /**
     * Add additional meta data to the resource response.
     *
     * @return $this
     */
    public function additional(array $data)
    {
        $this->additional = $data;

        return $this;
    }

    /**
     * Set the string that should wrap the outer-most resource array.
     *
     * @param string $value
     */
    public function wrap($value)
    {
        $this->wrap = $value;
    }

    /**
     * Disable wrapping of the outer-most resource array.
     */
    public function withoutWrapping()
    {
        $this->wrap = null;
    }

    /**
     * Prepare the resource for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->resolve();
    }

    public function toResponse()
    {
        return (new Response($this))->toResponse();
    }

    public function toMessage()
    {
        return (new Response($this))->toMessage();
    }
}
