<?php

namespace App\Http\Controllers\Base;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

    public function repairSMS($data)
    {
        $sms_data = $this->returnFinalSMS($data);
        // dd($sms_data['text']);
        $user = env('TEXTIT_SMS_USER');
        $password = env('TEXTIT_SMS_PASS');
        $text = urlencode($sms_data['text']);
        $to = '94'.$sms_data['to'];

        $baseurl ="http://www.textit.biz/sendmsg";
        $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
        $ret = file($url);

        $res= explode(":",$ret[0]);

        if (trim($res[0])=="OK")
        {
            Log::info("Message Sent - ID : ".$res[1]);
        }
        else
        {
            Log::info("Message Sent Failed - ID : ".$res[1]);
        }
    }

    function returnFinalSMS($data)
    {
        $company = Company::find(1);

        $paid_status = $data->paid_status;
        $repair_status = $data->status;
        $collect_before = '';
        $collected_at = '';
        $advance = '';
        $due = 0;
        $to = $data->customer->contact;

        //Payment Status
        if ($paid_status == 0) {
            $pay_status = 'Paid Status - Not Paid';
            $due = $data->amount - $data->adv_amount;
        }

        if ($paid_status == 1) {
            $pay_status = 'Paid Status - Advance Paid';
            $advance = 'Advance Paid Amount - RS.'.$data->adv_amount;
            $due = $data->amount - $data->adv_amount;
        }

        if ($paid_status == 2) {
            $pay_status = 'Paid Status - Fully Paid';
        }

        //Repairing Status
        if ($repair_status == 0) {
            $repairstatus = 'Status - Taken';
        }

        if ($repair_status == 1) {
            $repairstatus = 'Status - Processing';
        }

        if ($repair_status == 2) {
            $repairstatus = 'Status - Ready to Collect';
            $collect_before = 'Collect Before - '.  date('l, F, jS, Y', strtotime($data->collect_before));
        }

        if ($repair_status == 3) {
            $repairstatus = 'Status - Collected';
            $collected_at = 'Collected at - '. date('l, F, jS, Y', strtotime($data->updated_at));
        }

        $text = "Hi ".$data->customer->name.",\n\n\n".
                "Service Details From ".$company->name."\n\n".
                $data->title."\n".
                "Ref.No #.".$data->ref_no."\n\n".
                "Service Amount RS.".$data->amount."\n".
                $advance."\n".
                "Due Amount RS.". number_format($due,2,".","")."\n".
                "Token At - ".date('l, F, jS, Y', strtotime($data->taken_date))."\n".
                $repairstatus."\n".
                $collect_before."\n".
                $pay_status."\n".
                $collected_at."\n".
                "\n\n Thank You...";

        return ['text'=>$text, 'to' =>$to];
    }
}
