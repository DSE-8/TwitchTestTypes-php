<?php

namespace TwitchAnalytics\tests\Integration\Controllers\GetUserPlatformAge;

use TwitchAnalytics\Controllers\GetUserPlatformAge\GetUserPlatformAgeController;
use TwitchAnalytics\Controllers\GetUserPlatformAge\UserNameValidator;
use TwitchAnalytics\Infrastructure\ApiClient\FakeTwitchApiClient;
use TwitchAnalytics\Infrastructure\Repositories\ApiUserRepository;
use TwitchAnalytics\Application\Services\UserAccountService;
use PHPUnit\Framework\TestCase;

use Mockery;
use TwitchAnalytics\Infrastructure\Time\SystemTimeProvider;

final class GetUserPlatformAgeControllerTest extends TestCase
{
    /**
     * @test
     */
    public function Gets400IfNoUserNameGiven(){
        $apiClient = new FakeTwitchApiClient();
        $repository = new ApiUserRepository($apiClient);
        $timeprovider = new SystemTimeProvider();
        $userAccountService = new UserAccountService($repository,$timeprovider);
        $userNameValidator = new UserNameValidator();
        $getUserPlatformAgeController = new GetUserPlatformAgeController($userAccountService,$userNameValidator);
        
        $expenctedResponse = [
            'error' => 'INVALID_REQUEST',
            'message' => 'Name parameter is required',
            'status' => 400
        ];
        
        $response = $getUserPlatformAgeController->__invoke();
        

        $this->assertEquals($expenctedResponse,$response);
    }
}