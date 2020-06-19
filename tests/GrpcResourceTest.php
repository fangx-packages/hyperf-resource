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

namespace Fangx\Tests;

use Fangx\Tests\Stubs\Resources\AllReplyResource;
use Fangx\Tests\Stubs\Resources\HiReplyResource;
use Fangx\Tests\Stubs\Resources\HiUserResource;
use Grpc\AllReply;
use Grpc\HiReply;
use Grpc\HiUser;
use Hyperf\Database\Model\Model;

/**
 * @internal
 * @coversNothing
 */
class GrpcResourceTest extends TestCase
{
    public function testResourceToMessage()
    {
        /** @var HiUser $msg */
        $msg = HiUserResource::make(new User(['name' => 'nfangxu', 'sex' => 1]))->toMessage();

        $this->assertSame('{"name":"nfangxu","sex":1}', $msg->serializeToJsonString());
        $this->assertSame(HiUser::class, get_class($msg));
    }

    public function testCollectionToMessage()
    {
        $collection = collect([
            new Reply([
                'message' => 'foo',
                'user' => new User(['name' => 'nfangxu', 'sex' => 1])
            ]),
            new Reply([
                'message' => 'bar',
                'user' => new User(['name' => 'nfangxu', 'sex' => 1])
            ])
        ]);

        $msg = HiReplyResource::collection($collection)->toMessage();

        $this->assertTrue(is_array($msg));

        $this->assertCount(2, $msg);

        foreach ($msg as $value) {
            $this->assertSame(HiReply::class, get_class($value));
            $this->assertSame(HiUser::class, get_class($value->getUser()));
        }
    }

    public function testResourceMayUserOtherResource()
    {
        $msg = HiReplyResource::make(new Reply([
            'message' => 'foo',
            'user' => new User(['name' => 'nfangxu', 'sex' => 1])
        ]))->toMessage();

        $this->assertSame('{"message":"foo","user":{"name":"nfangxu","sex":1}}', $msg->serializeToJsonString());
        $this->assertSame(HiReply::class, get_class($msg));
        $this->assertSame(HiUser::class, get_class($msg->getUser()));
    }

    public function testResourceMayUseCollection()
    {
        /** @var AllReply $msg */
        $msg = AllReplyResource::make(new Reply([
            'message' => 'foo',
            'users' => HiUserResource::collection(collect([
                new User(['name' => 'nfangxu-01', 'sex' => 1]),
                new User(['name' => 'nfangxu-02', 'sex' => 1]),
            ])),
        ]))->toMessage();

        $this->assertSame(
            '{"message":"foo","users":[{"name":"nfangxu-01","sex":1},{"name":"nfangxu-02","sex":1}]}',
            $msg->serializeToJsonString()
        );

        $this->assertSame(AllReply::class, get_class($msg));

        foreach ($msg->getUsers() as $user) {
            $this->assertSame(HiUser::class, get_class($user));
        }
    }
}

class Reply extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}

class User extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
