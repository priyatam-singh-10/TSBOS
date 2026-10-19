<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

class WebinarReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'webinar:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $now = time();

        $webinars = DB::table('bootcamp_purchases as bp')
            ->join('bootcamps as b', 'b.id', '=', 'bp.bootcamp_id')
            ->join('bootcamp_modules as bm', 'bm.bootcamp_id', '=', 'b.id')
            ->join('bootcamp_live_classes as blc', 'blc.module_id', '=', 'bm.id')
            ->join('users as u', 'u.id', '=', 'bp.user_id')
            ->select(
                'u.name',
                'u.phone',
                'b.title',
                'b.publish_date',
                'blc.start_time',
                'blc.end_time',
                'blc.joining_data'
            )
            ->get();

        foreach ($webinars as $webinar) {

            $join_link = '';

            if ($webinar->joining_data) {
                $zoomData = json_decode($webinar->joining_data, true);
                $join_link = $zoomData['join_url'] ?? '';
            }

            $date = date('d M Y', $webinar->start_time);
            $start_time = date('h:i A', $webinar->start_time);
            $end_time   = date('h:i A', $webinar->end_time);

            $seconds_left = $webinar->start_time - $now;

            // 24 hoursटे reminder → 10 minute window
            if ($seconds_left <= 86400 && $seconds_left >= 85800) {  // 86400 - 600 = 85800

                $message =
                    "⏰ *Webinar Reminder (24 Hours Left)*\n\n" .
                    "Hello *{$webinar->name}*,\n\n" .
                    "Your webinar *{$webinar->title}* will start in approximately 24 hours.\n\n" .
                    "📅 *Date:* {$date}\n" .
                    "⏰ *Time:* {$start_time}\n\n" .
                    "🔗 *Join Link:*\n{$join_link}\n\n" .
                    "🙏 Regards,\n" .
                    "The Sommnath Bhattacharyaa Occult Sciences";

                $this->sendWhatsapp($webinar->phone, $message);
            }

            // 1 टे reminder → 10 minute window
            if ($seconds_left <= 3600 && $seconds_left >= 3000) {  // 3600 - 600 = 3000

                $message =
                    "🚀 *Webinar Starting Soon (1 Hour Left)*\n\n" .
                    "Hello *{$webinar->name}*,\n\n" .
                    "Your webinar *{$webinar->title}* will start in less than 1 hour!\n\n" .
                    "📅 *Date:* {$date}\n" .
                    "⏰ *Time:* {$start_time}\n\n" .
                    "🔗 *Join Link:*\n{$join_link}\n\n" .
                    "🙏 Regards,\n" .
                    "The Sommnath Bhattacharyaa Occult Sciences";

                $this->sendWhatsapp($webinar->phone, $message);
            }
        }
    }
    private function sendWhatsapp($phone, $message)
    {

        $message = urlencode($message);
        $phone = str_replace('+', '', $phone);
        $url = "https://511.wazipers.com/api/send?number={$phone}&type=text&message={$message}&instance_id=6A687EE3B3B2F&access_token=6a4f950a626af";
        
        

        try {
            file_get_contents($url);
        } catch (\Exception $e) {
            \Log::error('WhatsApp API Error: ' . $e->getMessage());
        }
    }
}
