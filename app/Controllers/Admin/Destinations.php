<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DestinationModel;
use Config\Services;

class Destinations extends BaseController
{
    protected $destinationModel;
    protected $validation;
    
    public function __construct()
    {
        $this->destinationModel = new DestinationModel();
        $this->validation = Services::validation();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Manage Destinations',
            'destinations' => $this->destinationModel->findAll(),
            'categories' => ['diving', 'beach', 'island', 'viewpoint', 'cultural'],
            'validation' => $this->validation
        ];
        
        return view('admin/destinations/index', $data);
    }
    
    public function create()
    {
        $data = [
            'title' => 'Add New Destination',
            'categories' => ['diving', 'beach', 'island', 'viewpoint', 'cultural'],
            'validation' => $this->validation
        ];
        
        return view('admin/destinations/create', $data);
    }
    
    public function store()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'description' => 'required',
            'location' => 'required',
            'category' => 'required|in_list[diving,beach,island,viewpoint,cultural]',
            'price_range' => 'permit_empty|decimal',
            'best_season' => 'permit_empty|max_length[100]',
            'image' => 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Handle image upload
        $image = $this->request->getFile('image');
        $imageName = $image->getRandomName();
        $image->move('uploads/destinations', $imageName);
        
        $this->destinationModel->save([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'location' => $this->request->getPost('location'),
            'category' => $this->request->getPost('category'),
            'price_range' => $this->request->getPost('price_range'),
            'best_season' => $this->request->getPost('best_season'),
            'image_url' => 'uploads/destinations/' . $imageName
        ]);
        
        return redirect()->to('/admin/destinations')->with('success', 'Destination added successfully');
    }
    
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Destination',
            'destination' => $this->destinationModel->find($id),
            'categories' => ['diving', 'beach', 'island', 'viewpoint', 'cultural'],
            'validation' => $this->validation
        ];
        
        return view('admin/destinations/edit', $data);
    }
    
    public function update($id)
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'description' => 'required',
            'location' => 'required',
            'category' => 'required|in_list[diving,beach,island,viewpoint,cultural]',
            'price_range' => 'permit_empty|decimal',
            'best_season' => 'permit_empty|max_length[100]',
            'image' => 'max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'location' => $this->request->getPost('location'),
            'category' => $this->request->getPost('category'),
            'price_range' => $this->request->getPost('price_range'),
            'best_season' => $this->request->getPost('best_season')
        ];
        
        $image = $this->request->getFile('image');
        if ($image->isValid()) {
            // Delete old image
            $oldImage = $this->destinationModel->find($id)['image_url'];
            if ($oldImage && file_exists($oldImage)) {
                unlink($oldImage);
            }
            
            // Upload new image
            $imageName = $image->getRandomName();
            $image->move('uploads/destinations', $imageName);
            $data['image_url'] = 'uploads/destinations/' . $imageName;
        }
        
        $this->destinationModel->update($id, $data);
        
        return redirect()->to('/admin/destinations')->with('success', 'Destination updated successfully');
    }
    
    public function delete($id)
    {
        $destination = $this->destinationModel->find($id);
        
        // Delete image file
        if ($destination['image_url'] && file_exists($destination['image_url'])) {
            unlink($destination['image_url']);
        }
        
        $this->destinationModel->delete($id);
        
        return redirect()->to('/admin/destinations')->with('success', 'Destination deleted successfully');
    }
    
}