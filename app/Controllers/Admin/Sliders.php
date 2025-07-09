<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SliderModel;
use Config\Services;

class Sliders extends BaseController
{
    protected $sliderModel;
    protected $validation;
    
    public function __construct()
    {
        $this->sliderModel = new SliderModel();
        $this->validation = Services::validation();
        helper(['form', 'url']);
    }
    
    public function index()
    {
        $data = [
            'title' => 'Manage Sliders',
            'sliders' => $this->sliderModel->orderBy('display_order', 'ASC')->findAll(),
            'pager' => $this->sliderModel->pager
        ];
        
        return view('admin/sliders/index', $data);
    }
    
    public function new()
    {
        $data = [
            'title' => 'Add New Slider',
            'next_display_order' => $this->sliderModel->getMaxDisplayOrder() + 1,
            'validation' => $this->validation
        ];
        
        return view('admin/sliders/create', $data);
    }
    
    public function create()
    {
        if (!$this->validate($this->sliderModel->validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        
        $image = $this->request->getFile('image');
        $imageName = $image->getRandomName();
        $image->move('uploads/sliders', $imageName);
        
        $this->sliderModel->save([
            'title' => $this->request->getPost('title'),
            'subtitle' => $this->request->getPost('subtitle'),
            'image_url' => 'uploads/sliders/' . $imageName,
            'button_text' => $this->request->getPost('button_text'),
            'button_link' => $this->request->getPost('button_link'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'display_order' => $this->request->getPost('display_order')
        ]);
        
        return redirect()->to('/admin/sliders')
            ->with('success', 'Slider added successfully');
    }
    
    public function edit($id)
    {
        $slider = $this->sliderModel->find($id);
        
        if (!$slider) {
            return redirect()->to('/admin/sliders')
                ->with('error', 'Slider not found');
        }
        
        $data = [
            'title' => 'Edit Slider',
            'slider' => $slider,
            'validation' => $this->validation
        ];
        
        return view('admin/sliders/edit', $data);
    }
    
    public function update($id)
    {
        $slider = $this->sliderModel->find($id);
        
        if (!$slider) {
            return redirect()->to('/admin/sliders')
                ->with('error', 'Slider not found');
        }
        
        $rules = $this->sliderModel->validationRules;
        $rules['image'] = 'max_size[image,2048]|is_image[image]';
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'title' => $this->request->getPost('title'),
            'subtitle' => $this->request->getPost('subtitle'),
            'button_text' => $this->request->getPost('button_text'),
            'button_link' => $this->request->getPost('button_link'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'display_order' => $this->request->getPost('display_order')
        ];
        
        $image = $this->request->getFile('image');
        if ($image->isValid() && !$image->hasMoved()) {
            if ($slider['image_url'] && file_exists($slider['image_url'])) {
                unlink($slider['image_url']);
            }
            
            $imageName = $image->getRandomName();
            $image->move('uploads/sliders', $imageName);
            $data['image_url'] = 'uploads/sliders/' . $imageName;
        }
        
        $this->sliderModel->update($id, $data);
        
        return redirect()->to('/admin/sliders')
            ->with('success', 'Slider updated successfully');
    }
    
    public function delete($id)
    {
        $slider = $this->sliderModel->find($id);
        
        if (!$slider) {
            return redirect()->to('/admin/sliders')
                ->with('error', 'Slider not found');
        }
        
        if ($slider['image_url'] && file_exists($slider['image_url'])) {
            unlink($slider['image_url']);
        }
        
        $this->sliderModel->delete($id);
        
        return redirect()->to('/admin/sliders')
            ->with('success', 'Slider deleted successfully');
    }
    
    public function updateOrder()
    {
        $order = $this->request->getPost('order');
        
        foreach ($order as $i => $id) {
            $this->sliderModel->update($id, ['display_order' => $i + 1]);
        }
        
        return $this->response->setJSON(['success' => true]);
    }
}