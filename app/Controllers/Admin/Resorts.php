<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ResortModel;
use Config\Services;

class Resorts extends BaseController
{
    protected $resortModel;
    protected $validation;
    
    public function __construct()
    {
        $this->resortModel = new ResortModel();
        $this->validation = Services::validation();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Manage Resorts',
            'resorts' => $this->resortModel->findAll(),
            'pager' => $this->resortModel->pager
        ];
        
        return view('admin/resorts/index', $data);
    }
    
    public function new()
    {
        $data = [
            'title' => 'Add New Resort',
            'validation' => $this->validation
        ];
        
        return view('admin/resorts/create', $data);
    }
    
    public function create()
    {
        if (!$this->validate($this->resortModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $image = $this->request->getFile('image');
        $imageName = $image->getRandomName();
        $image->move('uploads/resorts', $imageName);
        
        $this->resortModel->save([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'location' => $this->request->getPost('location'),
            'price_range' => $this->request->getPost('price_range'),
            'facilities' => $this->request->getPost('facilities'),
            'contact_phone' => $this->request->getPost('contact_phone'),
            'contact_email' => $this->request->getPost('contact_email'),
            'website' => $this->request->getPost('website'),
            'image_url' => 'uploads/resorts/' . $imageName,
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0
        ]);
        
        return redirect()->to('/admin/resorts')->with('success', 'Resort added successfully');
    }
    
    public function edit($id)
    {
        $data = [
            'resort' => $this->resortModel->find($id),
            'title' => 'Edit Resort',
            'validation' => $this->validation
        ];
        
        return view('admin/resorts/edit', $data);
    }
    
    public function update($id)
    {
        $resort = $this->resortModel->find($id);
        
        $rules = $this->resortModel->validationRules;
        $rules['name'] = "required|min_length[3]|max_length[100]|is_unique[resorts.name,id,{$id}]";
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'location' => $this->request->getPost('location'),
            'price_range' => $this->request->getPost('price_range'),
            'facilities' => $this->request->getPost('facilities'),
            'contact_phone' => $this->request->getPost('contact_phone'),
            'contact_email' => $this->request->getPost('contact_email'),
            'website' => $this->request->getPost('website'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0
        ];
        
        $image = $this->request->getFile('image');
        if ($image->isValid()) {
            if ($resort['image_url'] && file_exists($resort['image_url'])) {
                unlink($resort['image_url']);
            }
            
            $imageName = $image->getRandomName();
            $image->move('uploads/resorts', $imageName);
            $data['image_url'] = 'uploads/resorts/' . $imageName;
        }
        
        $this->resortModel->update($id, $data);
        
        return redirect()->to('/admin/resorts')->with('success', 'Resort updated successfully');
    }
    
    public function delete($id)
    {
        $resort = $this->resortModel->find($id);
        
        if ($resort['image_url'] && file_exists($resort['image_url'])) {
            unlink($resort['image_url']);
        }
        
        $this->resortModel->delete($id);
        
        return redirect()->to('/admin/resorts')->with('success', 'Resort deleted successfully');
    }
}