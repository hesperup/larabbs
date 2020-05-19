<?php


namespace App\Handlers;

use Illuminate\Support\Facades\Log;
use  Illuminate\Support\Str;
use Image;

class ImageUploadHandler
{
    //允许上传图片文件后缀
    protected $allowed_ext = ['png', "jpg", "jpeg"];



    public function save($file, $folder, $file_prefix,$max_width = false)
    {
        //文件名格式：uploads/images/avatars/201709/21/
        $folder_name = "uploads/images/$folder/" .  date("Ym/d", time());

        //文件路径
        $upload_path = public_path() . '/' . $folder_name;

        //文件后缀
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        $filename = $file_prefix . '_' . time() .  '-' . Str::random(10) . '.' . $extension;


        // 如果上传的不是图片将终止操作
        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }
        // 将图片移动到我们的目标存储路径中
        $file->move($upload_path, $filename);

        // 如果限制了图片宽度，就进行裁剪
        if ($max_width && $extension != 'gif') {
            // 此类中封装的函数，用于裁剪图片
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

        return [
            'path' => config('app.url') . "/$folder_name/$filename"
        ];
    }


    public function reduceSize($file_path, $max_width)
    {
        Log::error('handle the image');

        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file_path);
        // 进行大小调整的操作
        $image->resize($max_width, null, function ($constraint) {
            // 设定宽度是 $max_width，高度等比例双方缩放
            $constraint->aspectRatio();
            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });
        // 对图片修改后进行保存
        $image->save();
    }
}
