<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;
use App\Services\ModuleService;

class AdminController extends Controller
{
    public function index(): void
    {
        $this->view('admin/admin', [], 'Admin section - FreepostRepo');
    }

    public function modules(): void
    {
        $modules = new ModuleService($this->db(), $this->config());

        $this->view('admin/modules/all', ['modules' => $modules->all()], 'Admin section - FreepostRepo');
    }

    public function moduleAdd(): void
    {
        $this->view('admin/modules/add', [], 'Admin section - FreepostRepo');
    }

    public function moduleStore(): void
    {
        $validation = $this->request()->validate([
            'moduleName' => ['required'],
            'moduleDownloads' => ['required', 'minnum:0'],
            'moduleBriefDescription' => ['required', 'max:50'],
            'moduleDescription' => ['required'],
            'moduleStatus' => ['required'],
            'userId' => ['required', 'minnum:0'],
        ]);

        if (!$validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect('/admin/modules/add');
        }

        $modules = new ModuleService($this->db(), $this->config());

        $modules->store(
            $this->request()->input('moduleName'),
            $this->request()->input('moduleBriefDescription'),
            $this->request()->input('moduleDescription'),
            $this->request()->input('moduleDownloads'),
            $this->request()->input('moduleStatus'),
            $this->request()->input('userId'),
            $this->request()->files('moduleFiles'),
        );

        $this->redirect('/admin/modules');

    }

    public function moduleEdit(): void
    {
        $modules = new ModuleService($this->db(), $this->config());

        $this->view('admin/modules/edit', ['module' => $modules->findById($this->request()->input('id'))], 'Admin section - FreepostRepo');
    }

    public function moduleChange(): void
    {
        $validation = $this->request()->validate([
            'moduleName' => ['required'],
            'moduleDownloads' => ['required', 'minnum:0'],
            'moduleBriefDescription' => ['required', 'max:50'],
            'moduleDescription' => ['required'],
            'moduleStatus' => ['required'],
            'userId' => ['required', 'minnum:0'],
        ]);

        if (!$validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect('/admin/modules/edit?id=' . $this->request()->input('moduleId'));
        }

        $modules = new ModuleService($this->db(), $this->config());

        $modules->update(
            $this->request()->input('moduleId'),
            $this->request()->input('moduleName'),
            $this->request()->input('moduleBriefDescription'),
            $this->request()->input('moduleDescription'),
            $this->request()->input('moduleDownloads'),
            $this->request()->input('moduleStatus'),
            $this->request()->input('userId'),
            $this->request()->files('moduleFiles'),
        );

        $this->redirect('/admin/modules');
    }

    public function moduleDelete(): void
    {
        $modules = new ModuleService($this->db(), $this->config());

        $modules->destroy($this->request()->input('id'));

        $this->redirect('/admin/modules');
    }
}