<?php

namespace App\Http\Controllers\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;

class HelperController extends Controller
{
    //File upload Helper Class
    public function fileUpload($upload_file,$name,$path_name,$height,$width)
    {

        $image = $upload_file;
        $image_name = $name.time().'.'.$image->getClientOriginalExtension();
        $path = public_path('/upload/'.$path_name);
        $file = "upload/".$path_name."/".$image_name;
        $resize_image = Image::make($image->getRealPath());
        $resize_image->resize($height, $width)->save($path.'/'.$image_name);

        return $file;
    }

    public function fileUpload2($upload_file,$name,$path_name)
    {
        $doc = $upload_file;
        $docName = $name.time().'.'.$doc->extension();
        $file = 'upload/'.$path_name.'/'.$docName;
        $path = public_path('/upload/'.$path_name);
        $doc->move($path, $docName);

        return $file;
    }

    public function welcomeMail($data)
    {
        Mail::send($data["view"], $data, function($message)use($data) {
            $message->to($data["email"])
                    ->subject($data["title"]);
        });
    }

    public function sendPDFMail($data, $pdf, $pdf_name)
    {
        Mail::send($data["view"], $data, function($message)use($data, $pdf, $pdf_name) {
            $message->to($data["email"], $data["email"])
                    ->subject($data["title"])
                    ->attachData($pdf->output(), $pdf_name);
        });
    }
}
