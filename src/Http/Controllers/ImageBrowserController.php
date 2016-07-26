<?php

namespace Yajra\CMS\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\CMS\Http\NotificationResponse;
use Symfony\Component\Finder\Finder;

/**
 * Class ImageBrowserController
 *
 * @package Yajra\CMS\Http\Controllers
 */
class ImageBrowserController extends Controller
{
    use NotificationResponse;

    /**
     * Get files by directory path.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function getFiles(Request $request)
    {
        $path       = $request->get('path');
        $mediaFiles = $this->getMediaFiles($path);

        return view('administrator.file-browser.container', compact('mediaFiles', 'path'))->render();
    }

    /**
     * Upload image file.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function uploadFile(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|image',
        ]);
        $filename = $request->file('file')->getClientOriginalName();
        $request->file('file')
                ->move(storage_path('app/' . config('media.root_dir') . $request->get('directory') . '/'), $filename);

        return $this->notifySuccess('Image Successfully Uploaded!');
    }

    /**
     * Show all files on selected path.
     *
     * @param string $currentPath
     * @param array $mediaFiles
     * @return array
     */
    public function getMediaFiles($currentPath = null, $mediaFiles = [])
    {
        $path  = storage_path('app/public/media' . $currentPath);
        $files = Finder::create()
                       ->in($path)
                       ->sortByType()
                       ->notName('*.docx')
                       ->notName('*.mp3')
                       ->notName('*.xlsx')
                       ->depth(0);
        foreach ($files as $file) {
            $mediaFiles[] = [
                'filename' => $file->getFilename(),
                'realPath' => $file->getRealPath(),
                'type'     => $file->getType(),
                'filepath' => str_replace(storage_path('app/public/media'), '', $file->getRealPath()),
            ];
        }

        return $mediaFiles;
    }
}
