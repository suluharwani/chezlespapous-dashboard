<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DestinationModel;

class Destinations extends BaseController
{
    protected $destinationModel;

    public function __construct()
    {
        $this->destinationModel = new DestinationModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manage Destinations',
            'destinations' => $this->destinationModel->findAll(),
        ];

        return view('admin/destinations/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add New Destination',
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/destinations/create', $data);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|max_length[100]',
            'description' => 'required',
            'location' => 'required|max_length[100]',
            'category' => 'required|in_list[diving,beach,island,viewpoint,cultural]',
            'price_range' => 'permit_empty|decimal',
            'best_season' => 'permit_empty|max_length[100]',
            'image' => 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $image = $this->request->getFile('image');
        $imageName = $image->getRandomName();
        $image->move('assets/admin/uploads/destinations', $imageName);

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'location' => $this->request->getPost('location'),
            'category' => $this->request->getPost('category'),
            'price_range' => $this->request->getPost('price_range'),
            'best_season' => $this->request->getPost('best_season'),
            'image_url' => $imageName,
        ];

        if ($this->destinationModel->save($data)) {
            return redirect()->to('/admin/destinations')->with('success', 'Destination added successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add destination');
        }
    }

    public function edit($id)
    {
        $destination = $this->destinationModel->find($id);

        if (!$destination) {
            return redirect()->to('/admin/destinations')->with('error', 'Destination not found');
        }

        $data = [
            'title' => 'Edit Destination',
            'destination' => $destination,
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/destinations/edit', $data);
    }

    public function update($id)
    {
        $destination = $this->destinationModel->find($id);

        if (!$destination) {
            return redirect()->to('/admin/destinations')->with('error', 'Destination not found');
        }

        $rules = [
            'name' => 'required|max_length[100]',
            'description' => 'required',
            'location' => 'required|max_length[100]',
            'category' => 'required|in_list[diving,beach,island,viewpoint,cultural]',
            'price_range' => 'permit_empty|decimal',
            'best_season' => 'permit_empty|max_length[100]',
            'image' => 'max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id' => $id,
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'location' => $this->request->getPost('location'),
            'category' => $this->request->getPost('category'),
            'price_range' => $this->request->getPost('price_range'),
            'best_season' => $this->request->getPost('best_season'),
        ];

        $image = $this->request->getFile('image');

        if ($image->isValid() && !$image->hasMoved()) {
            // Delete old image
            if ($destination['image_url'] && file_exists('assets/admin/uploads/destinations/' . $destination['image_url'])) {
                unlink('assets/admin/uploads/destinations/' . $destination['image_url']);
            }

            $imageName = $image->getRandomName();
            $image->move('assets/admin/uploads/destinations', $imageName);
            $data['image_url'] = $imageName;
        }

        if ($this->destinationModel->save($data)) {
            return redirect()->to('/admin/destinations')->with('success', 'Destination updated successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update destination');
        }
    }

    public function delete($id)
    {
        $destination = $this->destinationModel->find($id);

        if (!$destination) {
            return redirect()->to('/admin/destinations')->with('error', 'Destination not found');
        }

        // Delete image
        if ($destination['image_url'] && file_exists('assets/admin/uploads/destinations/' . $destination['image_url'])) {
            unlink('assets/admin/uploads/destinations/' . $destination['image_url']);
        }

        if ($this->destinationModel->delete($id)) {
            return redirect()->to('/admin/destinations')->with('success', 'Destination deleted successfully');
        } else {
            return redirect()->to('/admin/destinations')->with('error', 'Failed to delete destination');
        }
    }
}