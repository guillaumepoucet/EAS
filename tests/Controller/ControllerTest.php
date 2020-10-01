<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Entity\Announcement;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ControllerTest extends WebTestCase
{
    // testing if you're redirected if not logged in
    public function testAccessAnnouncement()
    {
        $client = static::createClient();
        $client->request('GET', '/announcement/new');
        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    // testing if announcement is not null
    public function testSetAnnouncement()
    {
        $announcement  = new Announcement;
        $announcement->setAnnouncementTitle('Test');
        $this->assertNotNull($announcement->getAnnouncementTitle());
        return $announcement;
    }

    // testing if user name is a string
    public function testUserName()
    {
        $user = new User;
        $user->setFirstName('User');
        $this->assertIsString($user->getUserName());
        return $user;
    }

    // testing if user is in anouncement
    public function testUserIntoAnnouncement() 
    {
        $user = $this->testUserName();
        $announcement = $this->testSetAnnouncement();
        $announcement->setUser($user);
        $this->assertInstanceOf(User::class, $announcement->getUser());
    } 
}
