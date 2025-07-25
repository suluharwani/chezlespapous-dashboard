<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LocalGuideModel;

class LocalGuides extends BaseController
{
    protected $localGuideModel;
    
    public function __construct()
    {
        $this->localGuideModel = new LocalGuideModel();
    }
    
    public function index()
    {
        $data = [
            'guides' => $this->localGuideModel->findAll(),
            'title' => 'Manage Local Guides'
        ];
        
        return view('admin/local_guides/index', $data);
    }
    
    public function new()
    {
        $data = [
            'title' => 'Add New Local Guide',
            'validation' => \Config\Services::validation(),
            'specializations' => ['diving', 'snorkeling', 'photography', 'cultural', 'adventure']
        ];
        
        return view('admin/local_guides/create', $data);
    }
    
    public function create()
    {
        if (!$this->validate([
            'full_name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[local_guides.email]',
            'phone' => 'required|max_length[20]',
            'address' => 'required',
            'experience' => 'required',
            'languages' => 'required',
            'specialization' => 'required|in_list[diving,snorkeling,photography,cultural,adventure]',
            'price_per_day' => 'required|decimal',
            'years_experience' => 'required|numeric',
            'photo' => 'uploaded[photo]|is_image[photo]'
        ])) {
            

            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $photo = $this->request->getFile('photo');
        $photoName = $photo->getRandomName();
        $photo->move('uploads/guides', $photoName);
        
        $this->localGuideModel->save([
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'experience' => $this->request->getPost('experience'),
            'languages' => $this->request->getPost('languages'),
            'specialization' => $this->request->getPost('specialization'),
            'price_per_day' => $this->request->getPost('price_per_day'),
            'years_experience' => $this->request->getPost('years_experience'),
            'photo_url' => base_url().'uploads/guides/' . $photoName,
    
            'is_verified' => $this->request->getPost('is_verified') ? 1 : 0,
            'rating' => $this->request->getPost('rating') ?? 5.0
        ]);
        
        return redirect()->to('/admin/local-guides')->with('success', 'Local guide added successfully');
    }
    
    public function edit($id)
    {
        $data = [
            'guide' => $this->localGuideModel->find($id),
            'title' => 'Edit Local Guide',
            'validation' => \Config\Services::validation(),
            'specializations' => ['diving', 'snorkeling', 'photography', 'cultural', 'adventure']
        ];
        
        return view('admin/local_guides/edit', $data);
    }
    
public function update($id)
{
    $guide = $this->localGuideModel->find($id);
    
    $rules = [
        'full_name' => 'required|min_length[3]|max_length[100]',
        'email' => "required",
        'phone' => 'required|max_length[20]',
        'address' => 'required',
        'experience' => 'required',
        'languages' => 'required',
        'specialization' => 'required|in_list[diving,snorkeling,photography,cultural,adventure]',
        'price_per_day' => 'required',
        'years_experience' => 'required|numeric'
    ];
    
    if ($this->request->getFile('photo')->isValid()) {
        $rules['photo'] = 'uploaded[photo]|max_size[photo,2048]|is_image[photo]';
    }
    
    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }
    
    $data = [
        'full_name' => $this->request->getPost('full_name'),
        'email' => $this->request->getPost('email'),
        'phone' => $this->request->getPost('phone'),
        'address' => $this->request->getPost('address'),
        'experience' => $this->request->getPost('experience'),
        'languages' => $this->request->getPost('languages'),
        'specialization' => $this->request->getPost('specialization'),
        'price_per_day' => $this->request->getPost('price_per_day'),
        'years_experience' => $this->request->getPost('years_experience'),
        'is_verified' => $this->request->getPost('is_verified') ? 1 : 0,
        'rating' => $this->request->getPost('rating') ?? $guide['rating']
    ];

    $photo = $this->request->getFile('photo');
    if ($photo->isValid()) {
        // Delete old photo
        if ($guide['photo_url'] && file_exists($guide['photo_url'])) {
            unlink($guide['photo_url']);
        }
        
        $photoName = $photo->getRandomName();
        $photo->move('uploads/guides', $photoName);
        $data['photo_url'] = base_url().'uploads/guides/' . $photoName;
    
    }

    try {
        // Debug: Tampilkan data yang akan diupdate
        // log_message('debug', 'Update data: ' . print_r($data, true));
        
        // Dapatkan query builder instance
        $builder = $this->localGuideModel->builder();
        
        // Debug: Tampilkan query SQL sebelum dijalankan
        $builder->where('id', $id);
        $updateQuery = $builder->set($data)->getCompiledUpdate();
        log_message('debug', 'Update query: ' . $updateQuery);
        
        // Jalankan update
        $updateResult = $this->localGuideModel->set($data)->where('id', $id)->update();
        
        if (!$updateResult) {
            // Dapatkan error database terakhir
            $dbError = $this->localGuideModel->errors();
            log_message('error', 'Database error: ' . print_r($dbError, true));
            
            throw new \RuntimeException('Failed to update guide in database. Error: ' . print_r($dbError, true));
        }
        
        return redirect()->to('/admin/local-guides')->with('success', 'Local guide updated successfully');
    } catch (\Exception $e) {
        // Jika ada error saat update, hapus foto baru yang sudah diupload (jika ada)
        if (isset($photoName) && file_exists('uploads/guides/' . $photoName)) {
            unlink('uploads/guides/' . $photoName);
        }
        
        // Log error lengkap
        log_message('error', 'Update error: ' . $e->getMessage());
        log_message('error', 'Stack trace: ' . $e->getTraceAsString());
        
        // Dapatkan error database terakhir jika ada
        $dbError = $this->localGuideModel->errors();
        if ($dbError) {
            log_message('error', 'Database error details: ' . print_r($dbError, true));
        }
        
        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to update guide: ' . $e->getMessage())
            ->with('debug_error', $dbError); // Tambahkan debug error ke session
    }
}
    
    public function delete($id)
    {
        $guide = $this->localGuideModel->find($id);
        
        if ($guide['photo_url'] && file_exists($guide['photo_url'])) {
            unlink($guide['photo_url']);
        }
        
        $this->localGuideModel->delete($id);
        
        return redirect()->to('/admin/local-guides')->with('success', 'Local guide deleted successfully');
    }
}