<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DestinationModel;
use App\Models\DiveSpotModel;
use App\Models\LocalGuideModel;
use App\Models\ResortModel;
use App\Models\TourPackageModel;
use App\Models\GalleryModel;
use App\Models\TestimonialModel;
use App\Models\SliderModel;

class Dashboard extends BaseController
{
public function index()
{
    $destinationModel = new DestinationModel();
    $diveSpotModel = new DiveSpotModel();
    $localGuideModel = new LocalGuideModel();
    $resortModel = new ResortModel();
    $tourPackageModel = new TourPackageModel();
    $galleryModel = new GalleryModel();
    $testimonialModel = new TestimonialModel();
    $sliderModel = new SliderModel();
    
    $data = [
        'title' => 'Dashboard',
        'destinationCount' => $destinationModel->countAll(),
        'diveSpotCount' => $diveSpotModel->countAll(),
        'guideCount' => $localGuideModel->countAll(),
        'resortCount' => $resortModel->countAll(),
        'packageCount' => $tourPackageModel->countAll(),
        'galleryCount' => $galleryModel->countAll(),
        'testimonialCount' => $testimonialModel->countAll(),
        'sliderCount' => $sliderModel->countAll(),
        'recentGuides' => $localGuideModel->orderBy('created_at', 'DESC')->limit(5)->find(),
        'recentDestinations' => $destinationModel->orderBy('created_at', 'DESC')->limit(5)->find(),
        'recentPackages' => $tourPackageModel->orderBy('created_at', 'DESC')->limit(5)->find()
    ];
    
    return view('admin/dashboard', $data);
}
}