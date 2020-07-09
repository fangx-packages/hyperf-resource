<?php
declare(strict_types=1);

namespace Fangx\Resource;

use Fangx\Resource\Response\Response;
use Hyperf\HttpMessage\Base\Response as HttpResponse;
use Hyperf\Utils\Traits\Macroable;

class Resource extends HttpResponse
{
    use Macroable;

    public function toResponse()
    {
        return (new Response($this))->toResponse();
    }
}
