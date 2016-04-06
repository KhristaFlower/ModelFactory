<?php

class FactoryTest extends \Codeception\TestCase\Test
{
    /**
     * @var UnitTester
     */
    protected $tester;

    // executed before each test
    protected function _before()
    {
        \App\Factory::getInstance()->define(Model\User::class, function(Faker\Generator $faker) {
            return [
                'username' => $faker->userName,
                'email' => $faker->email,
                'password' => $faker->password(),
                'dateOfBirth' => $faker->date('Y-m-d', strtotime('-18 years')),
                'countryCode' => $faker->countryCode
            ];
        });

        \App\Factory::getInstance()->define(Model\Post::class, function(Faker\Generator $faker) {
            return [
                'title' => $faker->sentence(6),
                'content' => $faker->paragraph(1),
                'posted_at' => $faker->dateTimeThisYear
            ];
        });
    }

    // executed after each test
    protected function _after()
    {
        \App\Factory::getInstance()->removeAllDefinitions();
    }

    function testGenerateSingleModel() {

        /** @var \Model\User $user */
        $user = \App\Factory::getInstance(\Model\User::class)->create();
        $this->assertInstanceOf(\Model\User::class, $user);

    }

    function testGenerateMultipleModels() {

        /** @var \App\Collection|\Model\Users[] $users */
        $users = \App\Factory::getInstance(\Model\User::class)->create(2);
        $this->assertInstanceOf(\App\Collection::class, $users);
        $this->assertInstanceOf(\Model\User::class, $users[0]);
        $this->assertInstanceOf(\Model\User::class, $users[1]);

    }

    function testGenerateRelationships() {

        /** @var \App\Collection|\Model\Users[] $usersWithPosts */
        $usersWithPosts = \App\Factory::getInstance(\Model\User::class)
            ->create(2)
            ->each(function(\Model\User $user) {
                $user->posts = \App\Factory::getInstance(\Model\Post::class)
                    ->create(2);
            });

        $this->assertInstanceOf(\App\Collection::class, $usersWithPosts[0]->posts);
        $this->assertEquals(2, $usersWithPosts[0]->posts->count());

    }
}
