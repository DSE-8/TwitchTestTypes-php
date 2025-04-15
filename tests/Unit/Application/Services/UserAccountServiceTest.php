<?php

namespace TwitchAnalytics\tests\Unit\Application\Services;

use TwitchAnalytics\Application\Services\UserAccountService;
use TwitchAnalytics\Application\Services\TimeProvider;
use TwitchAnalytics\Domain\Interfaces\UserRepositoryInterface;
use TwitchAnalytics\Domain\Exceptions\UserNotFoundException;
use TwitchAnalytics\Domain\Models\User;
use PHPUnit\Framework\TestCase;
use Datetime;
use Mockery;

final class UserAccountServiceTest extends TestCase
{
    /**
     * @test
     */
    public function getsErrorIfUserDoesNotExist(){
        $displayName = 'nonexistentUser';
        $userRepositoryInterface = Mockery::mock(UserRepositoryInterface::class);
        $timeProvider = Mockery::mock(TimeProvider::class);
        $userRepositoryInterface
            ->shouldReceive("findByDisplayName")
            ->with($displayName)
            ->andReturn(null);
        
        $userAccountService = new UserAccountService($userRepositoryInterface,$timeProvider);

        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage("No user found with given name: {$displayName}");

        $userAccountService->getAccountAge($displayName);
    }
    /**
     * @test
     */
    public function getsUserAgeIfUserExists(){
        $displayName = 'Ninja';
        $createdAt = '2024-04-15T00:00:00Z';
        $daysSinceCreation = 365;

        $user = Mockery::mock(User::class);
        $userRepositoryInterface = Mockery::mock(UserRepositoryInterface::class);
        $timeProvider = Mockery::mock(TimeProvider::class);
        $timeProvider
            ->shouldReceive("now")
            ->andReturn(new DateTime());
        $user
            ->shouldReceive("getCreatedAt")
            ->andReturn($createdAt)
            ->shouldReceive("getDisplayName")
            ->andReturn($displayName);

        $userRepositoryInterface
            ->shouldReceive("findByDisplayName")
            ->with($displayName)
            ->andReturn($user);
        
        $userAccountService = new UserAccountService($userRepositoryInterface,$timeProvider);

        $expectedUserAge = [
            'name' => $displayName,
            'days_since_creation' => $daysSinceCreation,
            'created_at' => $createdAt,
        ];

        $userAge = $userAccountService->getAccountAge($displayName);

        $this->assertEquals($userAge,$expectedUserAge);
    }
}
/*

*/