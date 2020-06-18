<?php
declare(strict_types=1);

namespace Fangx\Resource\Response;

use Fangx\Resource\Grpc\GrpcResource;
use Hyperf\Utils\Collection;

class GrpcResponse extends HttpResponse
{
    public function toResponse()
    {
        return $this->toExceptMessage($this->resource);
    }

    public function toExceptMessage(GrpcResource $resource)
    {
        $wrap = $this->wrap(
            $resource->resolve(),
            $resource->with(),
            $resource->additional
        );

        foreach ($wrap as $key => $value) {
            if ($value instanceof GrpcResource) {
                if (is_null($value->resource)) {
                    unset($wrap[$key]);
                } else {
                    $wrap[$key] = $this->toExceptMessage($value);
                }
            }
        }

        $except = $resource->except();

        return new $except($wrap);
    }

    protected function wrap($data, $with = [], $additional = [])
    {
        if ($data instanceof Collection) {
            $data = $data->all();
        }

        return array_merge_recursive($data, $with, $additional);
    }
}
