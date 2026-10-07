<?php

namespace App\Controllers;

use App\Models\TaskModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Tasks extends BaseController
{
    public function index()
    {
        $tasks = (new TaskModel())
            ->where('is_archived', false)
            ->where('task_date', date('Y-m-d'))
            ->orderBy('task_date', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();

        return view('tasks/welcome', ['title' => 'Tasks for Today', 'tasks' => $tasks]);
    }

    public function list()
    {
        $tasks = (new TaskModel())
            ->where('is_archived', false)
            ->orderBy('task_date', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();

        return view('tasks/list', ['title' => 'All Tasks', 'tasks' => $tasks]);
    }

    public function profile()
    {
        return view('tasks/profile', [
            'title' => 'Profile',
            'user'  => (new UserModel())->first(),
        ]);
    }

    public function about()
    {
        return view('tasks/about', ['title' => 'About']);
    }

    public function newTask()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        return view('tasks/form', [
            'title'      => 'New Task',
            'heading'    => 'Create a task.',
            'formAction' => '/tasks',
            'task'       => ['title' => '', 'task_date' => ''],
            'errors'     => [],
        ]);
    }

    public function create()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $task = $this->postedTask();
        if (! $this->validateTask()) {
            return $this->taskForm('New Task', 'Create a task.', '/tasks', $task, $this->validator->getErrors());
        }

        (new TaskModel())->insert($task + [
            'status'     => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/tasks')->with('success', 'Task created.');
    }

    public function edit(int $id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $task = $this->findActiveTask($id);

        return $this->taskForm('Edit Task', 'Edit this task.', '/tasks/' . $id, $task);
    }

    public function update(int $id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $this->findActiveTask($id);
        $task = $this->postedTask();
        if (! $this->validateTask()) {
            return $this->taskForm('Edit Task', 'Edit this task.', '/tasks/' . $id, $task + ['id' => $id], $this->validator->getErrors());
        }

        (new TaskModel())->update($id, $task);

        return redirect()->to('/tasks')->with('success', 'Task updated.');
    }

    public function archive(int $id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $this->findActiveTask($id);
        (new TaskModel())->update($id, ['is_archived' => true]);

        return redirect()->to('/tasks')->with('success', 'Task archived.');
    }

    public function updateStatus(int $id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $payload = $this->request->getJSON(true) ?? [];
        $status = $payload['status'] ?? null;
        if (! in_array($status, ['pending', 'completed'], true)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid task status.']);
        }

        $this->findActiveTask($id);
        (new TaskModel())->update($id, ['status' => $status]);

        return $this->response->setJSON(['id' => $id, 'status' => $status]);
    }

    private function requireLogin()
    {
        if (session()->get('user_id')) {
            return null;
        }

        return redirect()->to('/login')->with('error', 'Please log in to manage tasks.');
    }

    private function findActiveTask(int $id): array
    {
        $task = (new TaskModel())->where('is_archived', false)->find($id);
        if ($task === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $task;
    }

    private function postedTask(): array
    {
        return [
            'title'     => trim((string) $this->request->getPost('title')),
            'task_date' => (string) $this->request->getPost('task_date'),
        ];
    }

    private function validateTask(): bool
    {
        return $this->validate([
            'title'     => 'required',
            'task_date' => 'required|valid_date[Y-m-d]',
        ]);
    }

    private function taskForm(string $title, string $heading, string $formAction, array $task, array $errors = [])
    {
        return view('tasks/form', compact('title', 'heading', 'formAction', 'task', 'errors'));
    }
}