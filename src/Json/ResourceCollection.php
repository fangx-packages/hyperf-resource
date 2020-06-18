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

use Countable;
use Fangx\Resource\Concerns\CollectsResources;
use Fangx\Resource\Response\PaginatedResponse;
use Hyperf\Utils\Collection;
use IteratorAggregate;

class ResourceCollection extends JsonResource implements Countable, IteratorAggregate
{
    use CollectsResources;

    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects;

    /**
     * The mapped collection instance.
     *
     * @var Collection
     */
    public $collection;

    /**
     * Create a new resource instance.
     *
     * @param mixed $resource
     */
    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->resource = $this->collectResource($resource);
    }

    /**
     * Return the count of items in the resource collection.
     *
     * @return int
     */
    public function count()
    {
        return $this->collection->count();
    }

    /**
     * Transform the resource into a JSON array.
     */
    public function toArray(): array
    {
        return $this->collection->map->toArray()->all();
    }

    public function toResponse()
    {
        if ($this->isPaginatorResource($this->resource)) {
            return (new PaginatedResponse($this))->toResponse();
        }

        return parent::toResponse();
    }

    public function toMessage()
    {
        return $this->collection->map->toMessage()->all();
    }
}
