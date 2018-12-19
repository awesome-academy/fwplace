<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DesignDiagramRepository;

class DesignDiagramApi extends Controller
{
    private $designDiagramRepository;

    public function __construct(DesignDiagramRepository $designDiagramRepository)
    {
        $this->designDiagramRepository = $designDiagramRepository;
    }

    public function getDesignWithoutDiagram(Request $request, $id)
    {
        $design = $this->designDiagramRepository->getDesignWithoutDiagram($id);

        $content = (object)[];

        if ($design) {
            $content = json_decode($design->content);
        }

        return response()->json($content);
    }
}
