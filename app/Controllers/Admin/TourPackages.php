<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TourPackageModel;
use Config\Services;

class TourPackages extends BaseController
{
    protected $tourPackageModel;
    protected $validation;
    
    public function __construct()
    {
        $this->tourPackageModel = new TourPackageModel();
        $this->validation = Services::validation();
        helper(['form', 'url', 'text']);
    }
    
    public function index()
    {
        $data = [
            'title' => 'Manage Tour Packages',
            'packages' => $this->tourPackageModel->findAll(),
            'pager' => $this->tourPackageModel->pager
        ];
        
        return view('admin/tour_packages/index', $data);
    }
    
    public function new()
    {
        $data = [
            'title' => 'Add New Tour Package',
            'validation' => $this->validation
        ];
        
        return view('admin/tour_packages/create', $data);
    }
    
    public function create()
    {
        if (!$this->validate($this->tourPackageModel->validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        
        $image = $this->request->getFile('image');
        $imageName = $image->getRandomName();
        $image->move('uploads/tour_packages', $imageName);
        
        $this->tourPackageModel->save([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'duration' => $this->request->getPost('duration'),
            'price' => $this->request->getPost('price'),
            'discount' => $this->request->getPost('discount') ?? 0,
            'includes' => $this->request->getPost('includes'),
            'itinerary' => $this->request->getPost('itinerary'),
            'image_url' => 'uploads/tour_packages/' . $imageName,
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0
        ]);
        
        return redirect()->to('/admin/tour-packages')
            ->with('success', 'Tour package added successfully');
    }
    
    public function edit($id)
    {
        $package = $this->tourPackageModel->find($id);
        
        if (!$package) {
            return redirect()->to('/admin/tour-packages')
                ->with('error', 'Package not found');
        }
        
        $data = [
            'title' => 'Edit Tour Package',
            'package' => $package,
            'validation' => $this->validation
        ];
        
        return view('admin/tour_packages/edit', $data);
    }
    
    public function update($id)
    {
        $package = $this->tourPackageModel->find($id);
        
        if (!$package) {
            return redirect()->to('/admin/tour-packages')
                ->with('error', 'Package not found');
        }
        
        $rules = $this->tourPackageModel->validationRules;
        $rules['name'] = "required|min_length[5]|max_length[100]|is_unique[tour_packages.name,id,{$id}]";
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'duration' => $this->request->getPost('duration'),
            'price' => $this->request->getPost('price'),
            'discount' => $this->request->getPost('discount') ?? 0,
            'includes' => $this->request->getPost('includes'),
            'itinerary' => $this->request->getPost('itinerary'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0
        ];
        
        $image = $this->request->getFile('image');
        if ($image->isValid() && !$image->hasMoved()) {
            if ($package['image_url'] && file_exists($package['image_url'])) {
                unlink($package['image_url']);
            }
            
            $imageName = $image->getRandomName();
            $image->move('uploads/tour_packages', $imageName);
            $data['image_url'] = 'uploads/tour_packages/' . $imageName;
        }
        
        $this->tourPackageModel->update($id, $data);
        
        return redirect()->to('/admin/tour-packages')
            ->with('success', 'Tour package updated successfully');
    }
    
    public function delete($id)
    {
        $package = $this->tourPackageModel->find($id);
        
        if (!$package) {
            return redirect()->to('/admin/tour-packages')
                ->with('error', 'Package not found');
        }
        
        if ($package['image_url'] && file_exists($package['image_url'])) {
            unlink($package['image_url']);
        }
        
        $this->tourPackageModel->delete($id);
        
        return redirect()->to('/admin/tour-packages')
            ->with('success', 'Tour package deleted successfully');
    }
}