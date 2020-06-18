<?php
declare(strict_types=1);

namespace Fangx\Resource\Grpc;

use Fangx\Resource\Json\JsonResource;
use Fangx\Resource\Response\GrpcResponse;
use Fangx\Resource\UndefinedGrpcResourceExceptMessage;

class GrpcResource extends JsonResource
{
    public function except(): string
    {
        throw new UndefinedGrpcResourceExceptMessage($this);
    }

    public function toResponse()
    {
        return (new GrpcResponse($this))->toResponse();
    }
}
