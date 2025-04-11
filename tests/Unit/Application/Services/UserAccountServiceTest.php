<?php

declare(strict_types=1);

namespace TwitchAnalytics\tests\Unit\Application\Services;

use TwitchAnalytics\src\Application\Services\UserAccountService;
use TwitchAnalytics\Domain\Interfaces\UserRepositoryInterface;
use TwitchAnalytics\Domain\Exceptions\UserNotFoundException;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

final class UserAccountServiceTest extends TestCase
{
    /**
     * @test
     */
    public function AgeOfNonExistentAcountTrowsException(){
        $userRepositoryInterface = Mockery::mock(UserRepositoryInterface::class);
        $sessionManagerDouble->allows()->logout()->andReturn(null);

        $userAccountService = new UserAccountService($userRepositoryInterface);

        $userAccountService->getAccountAge('');
    }
}
/*

*/