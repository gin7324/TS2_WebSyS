<?php

use App\Models\TaskModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
final class TaskManagementTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrate = true;
    protected $refresh = true;
    protected $seed = 'App\\Database\\Seeds\\DemoSeeder';
    protected $namespace = 'App';

    public function testGuestTaskManagementRedirectsToLogin(): void
    {
        foreach ([
            ['GET', '/tasks/new'],
            ['GET', '/tasks/1/edit'],
            ['POST', '/tasks', []],
            ['POST', '/tasks/1', []],
            ['POST', '/tasks/1/archive', []],
            ['POST', '/tasks/1/status', []],
        ] as $request) {
            $response = $this->call($request[0], $request[1], $request[2] ?? null);

            $this->assertSame(302, $response->response()->getStatusCode());
            $this->assertSame('/login', parse_url($response->response()->getHeaderLine('Location'), PHP_URL_PATH));
        }
    }

    public function testLoggedInUserCanCreateEditAndArchiveTask(): void
    {
        $this->withSession(['user_id' => 1, 'username' => 'demo']);

        $created = $this->call('POST', '/tasks', [
            'title' => 'Integration-created task',
            'task_date' => date('Y-m-d'),
        ]);
        $this->assertSame(302, $created->response()->getStatusCode());

        $task = (new TaskModel())->where('title', 'Integration-created task')->first();
        $this->assertNotNull($task);

        $updated = $this->call('POST', '/tasks/' . $task['id'], [
            'title' => 'Integration-updated task',
            'task_date' => date('Y-m-d'),
        ]);
        $this->assertSame(302, $updated->response()->getStatusCode());
        $this->assertSame('Integration-updated task', (new TaskModel())->find($task['id'])['title']);

        $archived = $this->call('POST', '/tasks/' . $task['id'] . '/archive');
        $this->assertSame(302, $archived->response()->getStatusCode());
        $this->assertTrue((bool) (new TaskModel())->find($task['id'])['is_archived']);

        $list = $this->call('GET', '/tasks');
        $this->assertStringNotContainsString('Integration-updated task', $list->response()->getBody());
    }

    public function testTaskTitleAndDateAreRequired(): void
    {
        $this->withSession(['user_id' => 1, 'username' => 'demo']);
        $response = $this->call('POST', '/tasks', []);

        $this->assertSame(200, $response->response()->getStatusCode());
        $this->assertStringContainsString('Title field is required', $response->response()->getBody());
        $this->assertStringContainsString('Task Date field is required', $response->response()->getBody());
    }

    public function testDemoPasswordIsHashedAndCanLogIn(): void
    {
        $user = $this->db->table('users')->where('username', 'demo')->get()->getRowArray();
        $this->assertNotSame('TaskDemo123!', $user['password']);
        $this->assertTrue(password_verify('TaskDemo123!', $user['password']));

        $response = $this->call('POST', '/login', ['username' => 'demo', 'password' => 'TaskDemo123!']);
        $this->assertSame(302, $response->response()->getStatusCode());
    }
}