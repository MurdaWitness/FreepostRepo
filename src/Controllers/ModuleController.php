<?php

namespace App\Controllers;

use App\Kernel\Controller\Controller;
use App\Services\ModuleService;

class ModuleController extends Controller
{
    public function index(): void
    {
        $modules = new ModuleService($this->db(), $this->config());

        $modules = $modules->regExp(
            [
                'name' => $this->request()->input('query'),
                'brief_description' => $this->request()->input('query'),
                'description' => $this->request()->input('query')
            ]
        );

        $this->view('modules', ['modules' => $modules, 'query' => $this->request()->input('query')], 'Modules - FreepostRepo');
    }

    public function show(): void
    {
        $modules = new ModuleService($this->db(), $this->config());

        $module = $modules->findById($this->request()->input('id'));

        $this->view('module', ['module' => $module], $module->name() . ' - FreepostRepo');
    }

    public function download(): void
    {
        $modules = new ModuleService($this->db(), $this->config());

        $moduleId = $this->request()->input('id');

        $modules->download($moduleId);
    }

    public function profile(): void
    {
        $modules = new ModuleService($this->db(), $this->config());

        $modules = $modules->find(['user_id' => $this->auth()->id()]);

        $this->view('profile/all', ['modules' => $modules], 'My modules - FreepostRepo');
    }

    public function add(): void
    {
        $this->view('profile/add', [], 'Add module - FreepostRepo');
    }

    public function store(): void
    {
        $validation = $this->request()->validate([
            'moduleName' => ['required'],
            'moduleBriefDescription' => ['required', 'max:50'],
            'moduleDescription' => ['required'],
        ]);

        if (!$validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect('/profile/add');
        }

        $modules = new ModuleService($this->db(), $this->config());

        $modules->store(
            $this->request()->input('moduleName'),
            $this->request()->input('moduleBriefDescription'),
            $this->request()->input('moduleDescription'),
            0,
            'unchecked',
            $this->auth()->id(),
            $this->request()->files('moduleFiles'),
        );

        $this->redirect('/profile');
    }

    public function edit(): void
    {
        $modules = new ModuleService($this->db(), $this->config());

        $this->view('profile/edit', ['module' => $modules->findById($this->request()->input('id'))], 'Edit module - FreepostRepo');
    }

    public function change(): void
    {
        $validation = $this->request()->validate([
            'moduleName' => ['required'],
            'moduleBriefDescription' => ['required', 'max:50'],
            'moduleDescription' => ['required'],
        ]);

        if (!$validation) {
            foreach ($this->request()->errors() as $field => $errors) {
                $this->session()->set($field, $errors);
            }

            $this->redirect('/profile/edit?id=' . $this->request()->input('moduleId'));
        }

        $modules = new ModuleService($this->db(), $this->config());

        $modules->update(
            $this->request()->input('moduleId'),
            $this->request()->input('moduleName'),
            $this->request()->input('moduleBriefDescription'),
            $this->request()->input('moduleDescription'),
            $this->request()->input('moduleDownloads'),
            $this->request()->input('moduleStatus'),
            $this->auth()->id(),
            $this->request()->files('moduleFiles'),
        );

        $this->redirect('/profile');
    }

    public function delete(): void
    {
        $modules = new ModuleService($this->db(), $this->config());

        $modules->destroy($this->request()->input('id'));

        $this->redirect('/profile');
    }

    

}