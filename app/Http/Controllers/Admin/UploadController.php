<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\UploadNewFolderRequest;
use App\Services\UploadsManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    protected $manager;

    public function __construct(UploadsManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Show page of files / subfolders
     */
    public function index(Request $request)
    {
        $folder = $request->get('folder');
        $data = $this->manager->folderInfo($folder);

        return view('admin.upload.index', $data);
    }

    /**
     * Create a new folder
     */
    public function createFolder(UploadNewFolderRequest $request)
    {
        $new_folder = $request->get('new_folder');
        $folder = $request->get('folder').'/'.$new_folder;

        $result = $this->manager->createDirectory($folder);

        if ($result === true) {
            return redirect()
                ->back()
                ->withSuccess("文件夹 '$new_folder' 已创建.");
        }

        $error = $result ? : "创建目录出错.";
        return redirect()
            ->back()
            ->withErrors([$error]);
    }

    /**
     * Delete a file
     */
    public function deleteFile(Request $request)
    {
        $del_file = $request->get('del_file');
        $path = $request->get('folder').'/'.$del_file;

        $result = $this->manager->deleteFile($path);

        if ($result === true) {
            return redirect()
                ->back()
                ->withSuccess("文件 '$del_file' 已删除.");
        }

        $error = $result ? : "删除文件出错.";
        return redirect()
            ->back()
            ->withErrors([$error]);
    }

    /**
     * Delete a folder
     */
    public function deleteFolder(Request $request)
    {
        $del_folder = $request->get('del_folder');
        $folder = $request->get('folder').'/'.$del_folder;

        $result = $this->manager->deleteDirectory($folder);

        if ($result === true) {
            return redirect()
                ->back()
                ->withSuccess("文件夹 '$del_folder' 已删除.");
        }

        $error = $result ? : "目录删除出错.";
        return redirect()
            ->back()
            ->withErrors([$error]);
    }

    /**
     * Upload new file
     */
    public function uploadFile(UploadFileRequest $request)
    {
        $file = $_FILES['file'];
        $fileName = $request->get('file_name');
        $fileName = $fileName ?: $file['name'];
        $path = str_finish($request->get('folder'), '/') . $fileName;
        $content = File::get($file['tmp_name']);

        $result = $this->manager->saveFile($path, $content);

        if ($result === true) {
            return redirect()
                ->back()
                ->withSuccess("文件 '$fileName' 已上传.");
        }

        $error = $result ? : "删除文件出错.";
        return redirect()
            ->back()
            ->withErrors([$error]);
    }
}
