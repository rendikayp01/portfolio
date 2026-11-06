<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\CvFile;
use App\Models\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Halaman detail proyek yang berstatus tampil.
     */
    public function show(Project $project): View
    {
        abort_unless($project->isTampil(), 404);

        $related = Project::query()
            ->tampil()
            ->whereKeyNot($project->getKey())
            ->ordered()
            ->take(3)
            ->get();

        return view('site.projects.show', [
            'project' => $project,
            'related' => $related,
            'cvFile' => CvFile::current(),
        ]);
    }
}
