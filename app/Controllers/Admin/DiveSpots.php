<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DiveSpotModel;
use Config\Services;

class DiveSpots extends BaseController
{
    protected $diveSpotModel;
    protected $validation;
    
    public function __construct()
    {
        $this->diveSpotModel = new DiveSpotModel();
        $this->validation = Services::validation();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Manage Dive Spots',
            'diveSpots' => $this->diveSpotModel->findAll(),
            'validation' => $this->validation
        ];
        
        return view('admin/dive_spots/index', $data);
    }
    
    public function new()
    {
        $data = [
            'title' => 'Add New Dive Spot',
            'validation' => $this->validation
        ];
        
        return view('admin/dive_spots/create', $data);
    }
    
    public function create()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'description' => 'required',
            'location' => 'required',
            'depth_range' => 'required',
            'current_level' => 'required|in_list[low,medium,high]',
            'best_time' => 'permit_empty|max_length[100]',
            'marine_life' => 'permit_empty',
            'image' => 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Handle image upload
        $image = $this->request->getFile('image');
        $imageName = $image->getRandomName();
        $image->move('uploads/dive_spots', $imageName);
        
        $this->diveSpotModel->save([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'location' => $this->request->getPost('location'),
            'depth_range' => $this->request->getPost('depth_range'),
            'current_level' => $this->request->getPost('current_level'),
            'best_time' => $this->request->getPost('best_time'),
            'marine_life' => $this->request->getPost('marine_life'),
            'image_url' => base_url().'uploads/dive_spots/' . $imageName
        ]);
        
        return redirect()->to('/admin/dive-spots')->with('success', 'Dive spot added successfully');
    }
    
    public function edit($id)
    {
        $diveSpot = $this->diveSpotModel->find($id);
        
        if (!$diveSpot) {
            return redirect()->to('/admin/dive-spots')->with('error', 'Dive spot not found');
        }
        
        $data = [
            'title' => 'Edit Dive Spot',
            'diveSpot' => $diveSpot,
            'validation' => $this->validation
        ];
        
        return view('admin/dive_spots/edit', $data);
    }
    
    public function update($id)
    {
        $diveSpot = $this->diveSpotModel->find($id);
        
        if (!$diveSpot) {
            return redirect()->to('/admin/dive-spots')->with('error', 'Dive spot not found');
        }
        
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'description' => 'required',
            'location' => 'required',
            'depth_range' => 'required',
            'current_level' => 'required|in_list[low,medium,high]',
            'best_time' => 'permit_empty|max_length[100]',
            'marine_life' => 'permit_empty',
            'image' => 'max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'location' => $this->request->getPost('location'),
            'depth_range' => $this->request->getPost('depth_range'),
            'current_level' => $this->request->getPost('current_level'),
            'best_time' => $this->request->getPost('best_time'),
            'marine_life' => $this->request->getPost('marine_life')
        ];
        
        $image = $this->request->getFile('image');
        if ($image->isValid()) {
            // Delete old image
            if ($diveSpot['image_url'] && file_exists($diveSpot['image_url'])) {
                unlink($diveSpot['image_url']);
            }
            
            // Upload new image
            $imageName = $image->getRandomName();
            $image->move('uploads/dive_spots', $imageName);
            $data['image_url'] = base_url().'uploads/dive_spots/' . $imageName;
        }
        
        $this->diveSpotModel->update($id, $data);
        
        return redirect()->to('/admin/dive-spots')->with('success', 'Dive spot updated successfully');
    }
    
    public function delete($id)
    {
        $diveSpot = $this->diveSpotModel->find($id);
        
        if (!$diveSpot) {
            return redirect()->to('/admin/dive-spots')->with('error', 'Dive spot not found');
        }
        
        // Delete image file
        if ($diveSpot['image_url'] && file_exists($diveSpot['image_url'])) {
            unlink($diveSpot['image_url']);
        }
        
        $this->diveSpotModel->delete($id);
        
        return redirect()->to('/admin/dive-spots')->with('success', 'Dive spot deleted successfully');
    }
}