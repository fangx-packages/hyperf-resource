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

namespace Fangx\Resource\Grpc;

use Fangx\Resource\Json\JsonResource;
use Fangx\Resource\MessageResource;
use Fangx\Resource\UndefinedGrpcResourceExceptMessage;

class GrpcResource extends JsonResource implements MessageResource
{
    public function expect(): string
    {
        throw new UndefinedGrpcResourceExceptMessage($this);
    }
}
