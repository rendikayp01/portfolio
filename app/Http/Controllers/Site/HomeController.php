<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\CvFile;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Halaman utama portofolio dengan seluruh bagian utama.
     */
    public function index(): View
    {
        $profile = Profile::current();

        $skills = Skill::query()
            ->ordered()
            ->get()
            ->groupBy('kategori');

        $projects = Project::query()
            ->tampil()
            ->ordered()
            ->get();

        $experiences = Experience::query()
            ->ordered()
            ->get()
            ->groupBy('tipe');

        return view('site.home', [
            'profile' => $profile,
            'skills' => $skills,
            'projects' => $projects,
            'experiences' => $experiences,
            'cvFile' => CvFile::current(),
        ]);
    }
}
