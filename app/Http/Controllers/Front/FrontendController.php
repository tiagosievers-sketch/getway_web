<?php

namespace App\Http\Controllers\Front;

use App\Models\Faq;
use App\Models\Job;
use App\Models\Blog;
use App\Models\Team;
use App\Models\Quote;
use App\Models\Client;
use App\Models\Slider;
use App\Models\Social;
use App\Models\Archive;
use App\Models\Counter;
use App\Models\Feature;
use App\Models\Gallery;
use App\Models\History;
use App\Models\Package;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Language;
use App\Models\Bcategory;
use App\Models\Gcategory;
use App\Models\Jcategory;
use App\Models\Portfolio;
use App\Models\WhySelect;
use App\Models\Testimonial;
use Illuminate\Support\Str;
use App\Models\Daynamicpage;
use App\Models\Emailsetting;
use App\Models\Sectiontitle;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\PortfolioImage;
use App\Http\Controllers\Controller;
use App\Models\AgentHealth;
use App\Models\ClientHealth;
use App\Models\Comments;
use App\Models\Contact;
use App\Models\CrmLogin;
use App\Models\Dependents;
use App\Models\Documents;
use App\Models\Ebanner;
use App\Models\Enterprises;
use App\Models\Eslider;
use App\Models\Event_leads;
use App\Models\Events;
use App\Models\FormLang;
use App\Models\InsuranceName;
use App\Models\InsurancePlans;
use App\Models\Leads;
use App\Models\LifeInsurance;
use App\Models\MedicaidCalc;
use App\Models\PassType;
use App\Models\Permalink;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\PublicLinks;
use App\Models\ReferFriend;
use App\Models\Statuses;
use App\Models\UploadDocuments;
use App\Models\User;
use App\Models\Visibility;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;
use IntlDateFormatter;
use SplFixedArray;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

use function PHPUnit\Framework\returnSelf;


use OpenApi\Attributes as OA;

class FrontendController extends Controller
{

        public function __construct()
        {
            $commonsetting = Setting::where('id', 1)->first();


            Config::set('captcha.sitekey', $commonsetting->google_recaptcha_site_key);
            Config::set('captcha.secret', $commonsetting->google_recaptcha_secret_key);


        }

        public function clear() {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            Session::flash('success', 'Cache, route, view, config cleared successfully!');
            return back();

        }

    #region TEMP



    public function getP3rotocol(){

        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        // CURLOPT_URL => 'https://api.sac.digital/v2/client/protocol/search?p=1&filter=8&operator=7aDa',
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        // CURLOPT_CUSTOMREQUEST => 'GET',
        // CURLOPT_HTTPHEADER => array(
        //     'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5N2UxNWJmNC01NTc3LTQ1OWYtODEyYi05Yzk5MTkwODY2ZjciLCJqdGkiOiIzMTEwMzU3NWYzNjM1NjkwOTVlZTY2ODNhYWE3MjY5MTQ2NmFkMWNkMjcwMmMzMDZmM2QyMzRhNDE2ZGVmZDAzNGE4MDY0OTU3YjI1MTU2MCIsImlhdCI6MTY2OTk5MDAwMCwibmJmIjoxNjY5OTkwMDAwLCJleHAiOjE2NzA1OTQ4MDAsInN1YiI6IiIsInNjb3BlcyI6WyJtYW5hZ2VyIl19.2C0i1ZsrrJGbg8RtsjoHQ4j2kUc8Px7GTxnvFRAdoGD20EZ1OkL8GNxix6btGl0USXzepZRnCrNxfKbXzv9eaxoUiO07sGc-4q6IyC7LESvtb5co4JnEhsed1oWAjT9doSaqdUChyc8Tevv7R7xJC6MvisXtnuHwo-RqOkwJu5znhWPpNQJG1n8BO-M5DyvnKRFYgM3c4D2oVtREY4iQBje_Xfjv2QLzsfPOqAbyTeigoBJEzAUmJ2MOlPx5wwLY_YoRPIRaGZOSvJ7uuheEwLTmzidVrVEuNTYy0nZjdtvg7PXkrrKwDKcBY5qubp2VUWd6JiKuKA3jAKOQm5iqCNO3Z9bpSR0IjS05PatdLJwmUnqydTki0a4N5x7O19YVPaP1lVc5_NVXpCbul9j4j1gbC2V-OVZ9ctefqC64gXWOH4pDZViosZ0Q5pzS9ArWU1rT4CxsbhD64RG6dy5ribn-qsjaQ3a4xzLVqkSv_-MxosXjLCBw3YRfLHHyPqMpbK9wdUYljG55KKTkhSvQUWVgRhv6yOGDa_jr2rjVPIlHGjWV8K54bxnp-O-2f-Cg2rhlMHDygd1lXf1PbeZPmvDyx_vuurFyLRS5rz7vzNzLliLSK788jZftDW-7EptUE3SepwA0Vqo7s__1TfpDqkZ1wTonPC_wxkAdHmfrfWU'
        // ),
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);
        // $responses = json_decode($response);
        // $total = $responses->total;

        // for($i = 1; $i <= ceil($total/100); $i++) {

        //     $curl2 = curl_init();

        //     curl_setopt_array($curl2, array(
        //     CURLOPT_URL => 'https://api.sac.digital/v2/client/protocol/search?p='.$i.'&filter=8&operator=7aDa',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'GET',
        //     CURLOPT_HTTPHEADER => array(
        //         'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5N2UxNWJmNC01NTc3LTQ1OWYtODEyYi05Yzk5MTkwODY2ZjciLCJqdGkiOiIzMTEwMzU3NWYzNjM1NjkwOTVlZTY2ODNhYWE3MjY5MTQ2NmFkMWNkMjcwMmMzMDZmM2QyMzRhNDE2ZGVmZDAzNGE4MDY0OTU3YjI1MTU2MCIsImlhdCI6MTY2OTk5MDAwMCwibmJmIjoxNjY5OTkwMDAwLCJleHAiOjE2NzA1OTQ4MDAsInN1YiI6IiIsInNjb3BlcyI6WyJtYW5hZ2VyIl19.2C0i1ZsrrJGbg8RtsjoHQ4j2kUc8Px7GTxnvFRAdoGD20EZ1OkL8GNxix6btGl0USXzepZRnCrNxfKbXzv9eaxoUiO07sGc-4q6IyC7LESvtb5co4JnEhsed1oWAjT9doSaqdUChyc8Tevv7R7xJC6MvisXtnuHwo-RqOkwJu5znhWPpNQJG1n8BO-M5DyvnKRFYgM3c4D2oVtREY4iQBje_Xfjv2QLzsfPOqAbyTeigoBJEzAUmJ2MOlPx5wwLY_YoRPIRaGZOSvJ7uuheEwLTmzidVrVEuNTYy0nZjdtvg7PXkrrKwDKcBY5qubp2VUWd6JiKuKA3jAKOQm5iqCNO3Z9bpSR0IjS05PatdLJwmUnqydTki0a4N5x7O19YVPaP1lVc5_NVXpCbul9j4j1gbC2V-OVZ9ctefqC64gXWOH4pDZViosZ0Q5pzS9ArWU1rT4CxsbhD64RG6dy5ribn-qsjaQ3a4xzLVqkSv_-MxosXjLCBw3YRfLHHyPqMpbK9wdUYljG55KKTkhSvQUWVgRhv6yOGDa_jr2rjVPIlHGjWV8K54bxnp-O-2f-Cg2rhlMHDygd1lXf1PbeZPmvDyx_vuurFyLRS5rz7vzNzLliLSK788jZftDW-7EptUE3SepwA0Vqo7s__1TfpDqkZ1wTonPC_wxkAdHmfrfWU'
        //     ),
        //     ));


        //     $response2 = curl_exec($curl2);

        //     curl_close($curl2);
        //     $responses2 = json_decode($response2);
        //     if (!empty($responses2->list)) {
        //         $list[] =  $responses2->list;
        //     }else {
        //         $list[] = null;
        //     }
        //     if($list==null) {
        //         $array[$i] = null;
        //     }else{
        //         foreach($list[$i-1] as $key => $value) {
        //             $curl3 = curl_init();

        //             curl_setopt_array($curl3, array(
        //             CURLOPT_URL => 'https://api.sac.digital/v2/client/protocol/messages?protocol='.$value->protocol,
        //             CURLOPT_RETURNTRANSFER => true,
        //             CURLOPT_ENCODING => '',
        //             CURLOPT_MAXREDIRS => 10,
        //             CURLOPT_TIMEOUT => 0,
        //             CURLOPT_FOLLOWLOCATION => true,
        //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //             CURLOPT_CUSTOMREQUEST => 'GET',
        //             CURLOPT_HTTPHEADER => array(
        //                 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5N2UxNWJmNC01NTc3LTQ1OWYtODEyYi05Yzk5MTkwODY2ZjciLCJqdGkiOiIzMTEwMzU3NWYzNjM1NjkwOTVlZTY2ODNhYWE3MjY5MTQ2NmFkMWNkMjcwMmMzMDZmM2QyMzRhNDE2ZGVmZDAzNGE4MDY0OTU3YjI1MTU2MCIsImlhdCI6MTY2OTk5MDAwMCwibmJmIjoxNjY5OTkwMDAwLCJleHAiOjE2NzA1OTQ4MDAsInN1YiI6IiIsInNjb3BlcyI6WyJtYW5hZ2VyIl19.2C0i1ZsrrJGbg8RtsjoHQ4j2kUc8Px7GTxnvFRAdoGD20EZ1OkL8GNxix6btGl0USXzepZRnCrNxfKbXzv9eaxoUiO07sGc-4q6IyC7LESvtb5co4JnEhsed1oWAjT9doSaqdUChyc8Tevv7R7xJC6MvisXtnuHwo-RqOkwJu5znhWPpNQJG1n8BO-M5DyvnKRFYgM3c4D2oVtREY4iQBje_Xfjv2QLzsfPOqAbyTeigoBJEzAUmJ2MOlPx5wwLY_YoRPIRaGZOSvJ7uuheEwLTmzidVrVEuNTYy0nZjdtvg7PXkrrKwDKcBY5qubp2VUWd6JiKuKA3jAKOQm5iqCNO3Z9bpSR0IjS05PatdLJwmUnqydTki0a4N5x7O19YVPaP1lVc5_NVXpCbul9j4j1gbC2V-OVZ9ctefqC64gXWOH4pDZViosZ0Q5pzS9ArWU1rT4CxsbhD64RG6dy5ribn-qsjaQ3a4xzLVqkSv_-MxosXjLCBw3YRfLHHyPqMpbK9wdUYljG55KKTkhSvQUWVgRhv6yOGDa_jr2rjVPIlHGjWV8K54bxnp-O-2f-Cg2rhlMHDygd1lXf1PbeZPmvDyx_vuurFyLRS5rz7vzNzLliLSK788jZftDW-7EptUE3SepwA0Vqo7s__1TfpDqkZ1wTonPC_wxkAdHmfrfWU'
        //             ),
        //             ));

        //             $response3 = curl_exec($curl3);

        //             curl_close($curl3);
        //             $responses3 = json_decode($response3);
        //             if (!empty($responses3->historic)) {
        //                 $historic = $responses3->historic;
        //             }else {
        //                 $historic = null;
        //             }
        //             $array[] = [
        //                 'protocol' => $value->protocol,
        //                 'name' => $value->contact->name,
        //                 'number' => $value->contact->number,
        //                 'historic' => $historic
        //             ];


        //         }
        //     }
        // }

        // $utf8 = json_encode($array);

        // file_put_contents('doc14.json', print_r($utf8, true));
        // return $array;


        $size = filesize('doc19.json');
        $fd = file_get_contents('doc19.json', 'rb');
        $join = json_decode($fd);
        $len = (int) count($join);

        $firsthalf = json_encode(array_slice($join, 0, $len / 2));
        $secondhalf = json_encode(array_slice($join, $len / 2));
        file_put_contents('doc20.json', print_r($firsthalf, true));
        file_put_contents('doc21.json', print_r($secondhalf, true));

    }

    public function getprotocol2() {
        ini_set('memory_limit', '2048M');
        $list = [
            'doc1.json',
            'doc2.json',
            'doc3.json',
            'doc4.json',
            'doc5.json',
            'doc6.json',
            'doc7.json',
            'doc8.json',
            'doc9.json',
            'doc10.json',
            'doc11.json',
            'doc12.json',
            'doc13.json',
            'doc14.json'
        ];
        $result = null;

        foreach($list as $item) {
            $join = file_get_contents($item);
            $join = json_decode($join);
            foreach($join as $key => $value) {
                $text = [];
                $historic = [];
                    $historic = $value->historic;
                    if(isset($historic)) {
                        foreach($historic as $itens) {
                            $text[] = ['text'=> $itens->text];
                        }
                    }
                    $result[] = [
                        'number' => $value->number,
                        'historic' => $text
                    ];
            }
        }
        $result = json_encode($result);
        file_put_contents('doc22.json', print_r($result, true));
        return $result;
    }







    public function getProtocols(){

        set_time_limit(0);
        $clerk = [
            'XQzJ',
            '7aDa',
        ];
        'm6zB';
        'QazA';
        'MGZZ';
        'Vlko';
        'W9RG';
        'mmlG';
        'bo1R';
        'BVnA';
        'zY9y';
        'p1aD';
        'Bnnqk';
        '3aLB1';
        '2BD1Q';
        '0kMoD';
        'W8gW9';
        'r6an9';
            $i=1;

            $url = 'https://api.sac.digital/v2/client/protocol/search?p='. $i .'&filter=8&operator=0kMoD';

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NzQzODQ5Ni1lMzJhLTQ2ODAtYjAyNC0wMTA4YWY1NTkwZjEiLCJqdGkiOiI3MDYyNWNhMzFlNTY5NDRjZDVhMWQyNDE4ZTM1YmYyODhmYjNmMDdlNjAxOTAwMjBjMzJjNWJhYjMzYjAwN2QyMDlhNmIwMDk0MDNhNTJjMCIsImlhdCI6MTY2MzE2NjE5NSwibmJmIjoxNjYzMTY2MTk1LCJleHAiOjE2NjM3NzA5OTUsInN1YiI6IiIsInNjb3BlcyI6WyJtYW5hZ2VyIl19.Of1d3UHvKJr-S4kKtJWsQZS3PQYoR5ErpDHThOOwZZumiQRNYCVbaCwc-NVEYsDZANn4jxcm7_4Gm6N0tYLIxSntzmy43kS3aan27FKAfdhwZn6nUqfvNN5ppFsnIz3txAPRGzEryZt9fNSpQb_JPPFeWQBFADT3T1A6BSPwyaF5WdLluj_x3u8mSgJu7yA3qRKQTNqs1LIYEG8SA_rQLhGF-PwgOlk6oLdWtgCVV22I9InvP4w4Myd313bwSK4_hYbHDkyYQBuxZwufHS4CboJ8RCDJJmYg_PR0CxIynq6HSA6UoHROirh0xXyHCEcPJgvwiVwj0M8pgRxv8TD5LTIBayfQ8U3fQJLOZn2bAoqOiW-aWny1cBakdOf6QoedAss0CljfR0pbh7yvXnQPM_JQ-r400_PbcPrAopZJoISJlF33jVkU40j15TzDlV_CxEDJ5Z0itkvB9eLXNACAOyUnnY5cm1AzwckK5ztPjIA5X3PPzI_UM7FSu0JzWnHPPmyqL4fnlpcOR0SBgCDUOi4002VJ_3qTxlb7hlj2EPCYDwr-oR2fFnJ1afTENTZ06xIBKFRbhSzT_TKeYKkjG8Z4kcYOXKx3Ct-4WErFbwy3YzClOtEGJGvsUmOXAhGFlCv2qGIqtf78cowIj1FWO0mA7Cr7K43bRauAd52WAeg'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $responses = json_decode($response);
            $total = $responses->total;


            for($i = 1; $i <= ceil($total/100); $i++) {

                $curl2 = curl_init();

                curl_setopt_array($curl2, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NzQzODQ5Ni1lMzJhLTQ2ODAtYjAyNC0wMTA4YWY1NTkwZjEiLCJqdGkiOiI3MDYyNWNhMzFlNTY5NDRjZDVhMWQyNDE4ZTM1YmYyODhmYjNmMDdlNjAxOTAwMjBjMzJjNWJhYjMzYjAwN2QyMDlhNmIwMDk0MDNhNTJjMCIsImlhdCI6MTY2MzE2NjE5NSwibmJmIjoxNjYzMTY2MTk1LCJleHAiOjE2NjM3NzA5OTUsInN1YiI6IiIsInNjb3BlcyI6WyJtYW5hZ2VyIl19.Of1d3UHvKJr-S4kKtJWsQZS3PQYoR5ErpDHThOOwZZumiQRNYCVbaCwc-NVEYsDZANn4jxcm7_4Gm6N0tYLIxSntzmy43kS3aan27FKAfdhwZn6nUqfvNN5ppFsnIz3txAPRGzEryZt9fNSpQb_JPPFeWQBFADT3T1A6BSPwyaF5WdLluj_x3u8mSgJu7yA3qRKQTNqs1LIYEG8SA_rQLhGF-PwgOlk6oLdWtgCVV22I9InvP4w4Myd313bwSK4_hYbHDkyYQBuxZwufHS4CboJ8RCDJJmYg_PR0CxIynq6HSA6UoHROirh0xXyHCEcPJgvwiVwj0M8pgRxv8TD5LTIBayfQ8U3fQJLOZn2bAoqOiW-aWny1cBakdOf6QoedAss0CljfR0pbh7yvXnQPM_JQ-r400_PbcPrAopZJoISJlF33jVkU40j15TzDlV_CxEDJ5Z0itkvB9eLXNACAOyUnnY5cm1AzwckK5ztPjIA5X3PPzI_UM7FSu0JzWnHPPmyqL4fnlpcOR0SBgCDUOi4002VJ_3qTxlb7hlj2EPCYDwr-oR2fFnJ1afTENTZ06xIBKFRbhSzT_TKeYKkjG8Z4kcYOXKx3Ct-4WErFbwy3YzClOtEGJGvsUmOXAhGFlCv2qGIqtf78cowIj1FWO0mA7Cr7K43bRauAd52WAeg'
                ),
                ));


                $response2 = curl_exec($curl2);

                curl_close($curl2);
                $responses2 = json_decode($response2);
                $list[] = $responses2->list;

                foreach($list[$i-1] as $key => $value) {$a[] = $value->contact->name;
                    $curl3 = curl_init();

                    curl_setopt_array($curl3, array(
                      CURLOPT_URL => 'https://api.sac.digital/v2/client/protocol/messages?protocol='.$value->protocol,
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => '',
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 0,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => 'GET',
                      CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NzQzODQ5Ni1lMzJhLTQ2ODAtYjAyNC0wMTA4YWY1NTkwZjEiLCJqdGkiOiI3MDYyNWNhMzFlNTY5NDRjZDVhMWQyNDE4ZTM1YmYyODhmYjNmMDdlNjAxOTAwMjBjMzJjNWJhYjMzYjAwN2QyMDlhNmIwMDk0MDNhNTJjMCIsImlhdCI6MTY2MzE2NjE5NSwibmJmIjoxNjYzMTY2MTk1LCJleHAiOjE2NjM3NzA5OTUsInN1YiI6IiIsInNjb3BlcyI6WyJtYW5hZ2VyIl19.Of1d3UHvKJr-S4kKtJWsQZS3PQYoR5ErpDHThOOwZZumiQRNYCVbaCwc-NVEYsDZANn4jxcm7_4Gm6N0tYLIxSntzmy43kS3aan27FKAfdhwZn6nUqfvNN5ppFsnIz3txAPRGzEryZt9fNSpQb_JPPFeWQBFADT3T1A6BSPwyaF5WdLluj_x3u8mSgJu7yA3qRKQTNqs1LIYEG8SA_rQLhGF-PwgOlk6oLdWtgCVV22I9InvP4w4Myd313bwSK4_hYbHDkyYQBuxZwufHS4CboJ8RCDJJmYg_PR0CxIynq6HSA6UoHROirh0xXyHCEcPJgvwiVwj0M8pgRxv8TD5LTIBayfQ8U3fQJLOZn2bAoqOiW-aWny1cBakdOf6QoedAss0CljfR0pbh7yvXnQPM_JQ-r400_PbcPrAopZJoISJlF33jVkU40j15TzDlV_CxEDJ5Z0itkvB9eLXNACAOyUnnY5cm1AzwckK5ztPjIA5X3PPzI_UM7FSu0JzWnHPPmyqL4fnlpcOR0SBgCDUOi4002VJ_3qTxlb7hlj2EPCYDwr-oR2fFnJ1afTENTZ06xIBKFRbhSzT_TKeYKkjG8Z4kcYOXKx3Ct-4WErFbwy3YzClOtEGJGvsUmOXAhGFlCv2qGIqtf78cowIj1FWO0mA7Cr7K43bRauAd52WAeg'
                      ),
                    ));

                    $response3 = curl_exec($curl3);

                    curl_close($curl3);
                    $responses3 = json_decode($response3);




                    $array[] = [
                        'protocol' => $value->protocol,
                        'name' => $value->contact->name,
                        'number' => $value->contact->number,
                        'historic' =>$responses3->historic
                    ];
                }
            }

        return $array;

    }


    #endregion



    // Home Page Funtions
    public function index(){
        session_start();
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

        $setting = Setting::where('language_id', $currlang->id)->first();

        if($setting->theme_version == 'theme9'){
            $data['esliders'] = Eslider::where('status',1)->where('language_id', $currlang->id)->orderBy('id', 'desc')->get();
            $data['products'] = Product::where('status',1)->where('language_id', $currlang->id)->orderBy('id', 'desc')->limit(8)->get();
            $data['ebanners'] = Ebanner::where('language_id', $currlang->id)->orderBy('id', 'desc')->limit(2)->get();
            $data['popularCategories'] = ProductCategory::where('status',1)->where('is_popular', 1)->where('language_id', $currlang->id)->orderBy('id', 'desc')->get();
            $data['featuredCategories'] = ProductCategory::with('products')->where('status', 1)->where('is_feature',1)->where('language_id', $currlang->id)->orderBy('id', 'desc')->get();
        }else{
            $data['sliders'] = Slider::where('status',1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->get();
            $data['features'] = Feature::where('status',1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->get();
            $data['services'] = Service::where('status',1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->limit(6)->get();
            $data['why_selects'] = WhySelect::where('status',1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->get();
            $data['portfolios'] = Portfolio::with('service')->where('status',1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->limit(8)->get();
            $data['teams'] = Team::where('status',1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->limit(8)->get();
            $data['faqs'] = Faq::where('status',1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->get();
            $data['counters'] = Counter::where('status',1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->get();
            $data['blogs'] = Blog::where('status',1)->where('language_id', $currlang->id)->limit(3)->get();
            $data['clients'] = Client::where('status',1)->where('language_id', $currlang->id)->get();
            $data['testimonials'] = Testimonial::where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->get();
        }


        return view('front.index', $data);
    }

    //WHATSAPP YEBA
    public function listProtocol($number, Request $request){

        header("Access-Control-Allow-Headers: Authorization, Content-Type");
        header("Access-Control-Allow-Origin: *");
        header('content-type: application/json; charset=utf-8');
        ini_set('memory_limit', '2048M');

        $list = [
            'doc22.json'
        ];

        $modelHealthCare = new CrmLogin;
        $modelHealthCare->setConnection('mysql2');

        $modelHealthCare2 = new AgentHealth;
        $modelHealthCare2->setConnection('mysql2');

        $user = $modelHealthCare::where('login_email', $request->email)->first();

        $result = null;

        if(isset($user)){
            if($user->is_admin==1){
                foreach($list as $item) {
                    $join = file_get_contents($item);
                    $join = json_decode($join);
                    foreach($join as $key => $value) {
                        if ($value->number === $number) {
                            $result[] = $value;
                        }
                    }
                }
                if ($result==null) {
                    return ["response" => "Phone not found !"];
                }
                return ['result' => $result, 'response' => null];
            }else {
                return ["response" => "Login not found !"];
            }
        }else {
            return ["response" => "Login not found !"];
        }

    }
    public function searchProtocol() {

        session_start();
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        if(!isset($_SESSION['usersAdmin'])){
            return redirect('/loginAdm');
        }

        $role = DB::connection('mysql2')->table('user_roles as userRole')
        ->join('roles AS role', 'userRole.role_id', '=', 'role.id_roles')
        ->join('crm_login AS login', 'userRole.user_id', '=', 'login.id_login')
        ->where('role.role_permission', 'can-access-historic-whatsapp')
        ->where('login.login_email', $_SESSION['usersAdmin']['email'])
        ->select('userRole.*', 'role.role_permission', 'login.is_admin', 'login.login_email')
        ->first();

        if(!isset($role)){
            if($_SESSION['usersAdmin']['is_admin']==0) {
                return redirect()->route('user.logoutCrmAdmin');
            }
        }

        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('US/Eastern'));
        $DateAndTime = $Object->format('Y-m-d');

        return view('front.protocol.listProtocol', [
            'DateAndTime'   => $DateAndTime
        ]);

    }
    public function searchProtocolJson(Request $request) {

        session_start();

        $email = $_SESSION['usersAdmin']['email'];

        $body = [
            "email" => $email
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_PORT => "8000",
        CURLOPT_URL => "http://localhost:8000/api/getProtocol/17748269248",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "{\r\n    \"email\": \"arnomroque@gmail.com\"\r\n}",
        CURLOPT_HTTPHEADER => [
            "Accept: */*",
            "Content-Type: application/json",
            "User-Agent: Thunder Client (https://www.thunderclient.com)"
        ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        $return = json_decode($response);

        return [
            'list'  => $return
        ];

    }

    //Raffle
    public function raffleRegister() {

        session_start();


        return view('front.raffle.raffleRegister');

    }
    public function raffleForm() {

        session_start();

		$modelHealthCare = new Events;
        $modelHealthCare->setConnection('mysql2');

        $events =  $modelHealthCare::where('is_active', 1)->get();

        return view('front.raffle.formRaffle', [
            'events'    => $events
        ]);

    }
    public function raffleShow($id) {

        session_start();
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        if(!isset($_SESSION['usersAdmin'])){
            return redirect('/loginAdm');
        }

        $role = DB::connection('mysql2')->table('user_roles as userRole')
        ->join('roles AS role', 'userRole.role_id', '=', 'role.id_roles')
        ->join('crm_login AS login', 'userRole.user_id', '=', 'login.id_login')
        ->where('role.role_permission', 'view-raffles')
        ->where('login.login_email', $_SESSION['usersAdmin']['email'])
        ->select('userRole.*', 'role.role_permission', 'login.is_admin', 'login.login_email')
        ->first();

        if(!isset($role) && $_SESSION['usersAdmin']['is_admin']==0){
            return redirect()->route('user.logoutCrmAdmin');
        }

		$modelHealthCare = new Events;
        $modelHealthCare->setConnection('mysql2');
		$modelHealthCare2 = new Event_leads;
        $modelHealthCare2->setConnection('mysql2');

        $clients = $modelHealthCare::where('id', $id)->first();

        $participants = $modelHealthCare2::where([['event_id', $id],['is_winner', '!=' , 1]])->orWhere([['event_id', $id],['is_winner', '=' , null]])->get();

        if($clients->is_active==0){
            return redirect()->back()->with('messageError', 'Sorteio Finalizado!');
        }

        if($participants->isEmpty()==1){
            return redirect('/listRaffle')->with('messageError', 'Nenhum participante cadastrado!');
        }

        return view('front.raffle.raffleIndex', ['clients' => $clients, 'participants' => $participants]);

    }
    public function raffleShuffle(Request $request) {

		$modelHealthCare2 = new Event_leads;
        $modelHealthCare2->setConnection('mysql2');

		$modelHealthCare3 = new Events;
        $modelHealthCare3->setConnection('mysql2');


        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('US/Eastern'));
        $DateAndTime = $Object->format('Y-m-d');

        $eventName = $modelHealthCare3::where('id', $request->raffle)->first();

        $clients = $modelHealthCare2::where([['event_id', $request->raffle],['is_winner', '!=' , 1]])->orWhere([['event_id', $request->raffle],['is_winner', '=' , null]])->get();

        if(count($clients)==0){
            $message = 'Nenhum participante cadastrado!';
            return $message;
        }

        $clients = json_decode($clients);
        $selectClient = $clients[array_rand($clients)];

        while($request->lastClient==$selectClient->id){
            $selectClient = $clients[array_rand($clients)];
        }

        $eventsNew = $modelHealthCare3::where('is_active', 1)->get();

        return [
            'selectClient'  => $selectClient,
            'raffle'        => $request->raffle,
            'eventsNew'     => $eventsNew,
            'eventName'     => $eventName->event_name
        ];

    }
    public function raffleSaveWinner(Request $request) {

		$modelHealthCare2 = new Event_leads;
        $modelHealthCare2->setConnection('mysql2');

		$modelHealthCare3 = new Events;
        $modelHealthCare3->setConnection('mysql2');

        $newPhone = str_replace([' ','-','(',')','+'], '', $request->phone);

        $body = [
            "fullname" => $request->name
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://admin.2easyinsurance.com/whatsapp/direct-start-flow/'. $newPhone .'/266155',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $modelHealthCare2::where('id', $request->id)->update([
            'is_winner'         => 1,
            'details_reward'    => $request->details
        ]);

        $url = '/raffle/'.$request->raffle;

        return redirect($url)->with('message', 'Ganhador Adicionado com Successo!');

    }
    public function rafflePost(Request $request) {

        session_start();

        return $request;

		$modelHealthCare = new Event_leads;
        $modelHealthCare->setConnection('mysql2');

        $client = $modelHealthCare::where('phone', $request->phone)->first();

        if(isset($client)) {

            $event = $modelHealthCare::insertGetId([
                'firstname' => $request->firstname,
                'lastname'  => $request->lastname,
                'phone'     => $request->phone,
                'email'     => $request->email,
                'event_id'  => $request->event_id
            ]);

            $_SESSION["name"]     = $request->firstname . ' ' . $request->lastname;
            $_SESSION["event_id"] = $request->event_id;
            $_SESSION["id"]       = $event;

            return;

        }else {
            return ;
        }


    }

    //CRUD EVENT SORTEIO
    public function addEventRaffleForm() {

        session_start();


        return view('front.raffle.CRUD.addEventsRaffle');

    }
    public function addEventRaffle(Request $request) {

        session_start();

		$modelHealthCare = new Events;
        $modelHealthCare->setConnection('mysql2');

        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('US/Eastern'));
        $DateAndTime = $Object->format('Y-m-d');

        $modelHealthCare::create([
            'event_name'    => $request->event_name,
            'created_at'    => $DateAndTime,
            'is_active'     => 1
        ]);

        return redirect()->back()->with('message', 'Sorteio Adicionado com Successo!');

    }
    public function listEventRaffle() {

        session_start();
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        if(!isset($_SESSION['usersAdmin'])){
            return redirect('/loginAdm');
        }

        $role = DB::connection('mysql2')->table('user_roles as userRole')
        ->join('roles AS role', 'userRole.role_id', '=', 'role.id_roles')
        ->join('crm_login AS login', 'userRole.user_id', '=', 'login.id_login')
        ->where('role.role_permission', 'view-raffles')
        ->where('login.login_email', $_SESSION['usersAdmin']['email'])
        ->select('userRole.*', 'role.role_permission', 'login.is_admin', 'login.login_email')
        ->first();

        if(!isset($role) && $_SESSION['usersAdmin']['is_admin']==0){
            return redirect()->route('user.logoutCrmAdmin');
        }

		$modelHealthCare = new Events;
        $modelHealthCare->setConnection('mysql2');


        $list = DB::connection('mysql2')->table('events')
        ->leftJoin('event_leads', 'events.id', '=', 'event_leads.event_id')
        ->select('events.*', DB::raw('count(event_leads.event_id) as count'))
        ->groupBy('events.id')
        ->get();

        return view('front.raffle.CRUD.listEventsRaffle', ['list' => $list]);

    }
    public function listIdEventRaffle($id, Request $request) {

        session_start();
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        if(!isset($_SESSION['usersAdmin'])){
            return redirect('/loginAdm');
        }

        $role = DB::connection('mysql2')->table('user_roles as userRole')
        ->join('roles AS role', 'userRole.role_id', '=', 'role.id_roles')
        ->join('crm_login AS login', 'userRole.user_id', '=', 'login.id_login')
        ->where('role.role_permission', 'view-raffles')
        ->where('login.login_email', $_SESSION['usersAdmin']['email'])
        ->select('userRole.*', 'role.role_permission', 'login.is_admin', 'login.login_email')
        ->first();

        if(!isset($role) && $_SESSION['usersAdmin']['is_admin']==0){
            return redirect()->route('user.logoutCrmAdmin');
        }

		$modelHealthCare = new Event_leads();
        $modelHealthCare->setConnection('mysql2');

        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('US/Eastern'));
        $DateAndTime = $Object->format('Y-m-d');

        $list = DB::connection('mysql2')->table('event_leads as participant')
        ->where('event_id', $id)
        ->join('events AS raffle', 'participant.event_id', '=', 'raffle.id')
        ->select('participant.*', 'raffle.event_name')
        ->get();

        return view('front.raffle.CRUD.listIdEventsRaffle', [
            'list'          => $list,
            'id'            => $id,
            'DateAndTime'   => $DateAndTime
        ]);

    }
    public function updateEventRaffle($id, Request $request) {

        session_start();

		$modelHealthCare = new Events;
        $modelHealthCare->setConnection('mysql2');

        $modelHealthCare::where('id', $id)->update([
            'event_name'    => $request->event_name,
            'is_active'     => $request->is_active
        ]);

        return redirect()->back()->with('message', 'Sorteio Alterado com Successo!');

    }
    public function deleteEventRaffle($id) {

        session_start();

		$modelHealthCare = new Events;
        $modelHealthCare->setConnection('mysql2');

        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('US/Eastern'));
        $DateAndTime = $Object->format('Y-m-d');

        $modelHealthCare::where('id', $id)->update([
            'is_active' => 0,
            'finished_at' => $DateAndTime
        ]);

        return redirect()->back()->with('message', 'Sorteio Encerrado com Successo!');

    }

    //REFER-WIN INDEX
    public function referIndex() {

        session_start();
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        if(!isset($_SESSION['usersAdmin'])){
            return redirect('/loginAdm');
        }

        $role = DB::connection('mysql2')->table('user_roles as userRole')
        ->join('roles AS role', 'userRole.role_id', '=', 'role.id_roles')
        ->join('crm_login AS login', 'userRole.user_id', '=', 'login.id_login')
        ->where('role.role_permission', 'view-client')
        ->where('login.login_email', $_SESSION['usersAdmin']['email'])
        ->select('userRole.*', 'role.role_permission', 'login.is_admin', 'login.login_email')
        ->first();

        if(!isset($role) && $_SESSION['usersAdmin']['is_admin']==0){
            return redirect()->route('user.logoutCrmAdmin');
        }

        $modelHealthCare = new ReferFriend;
        $modelHealthCare->setConnection('mysql2');

		$modelHealthCare2 = new ClientHealth;
        $modelHealthCare2->setConnection('mysql2');

        $modelHealthCare3 = new Statuses;
        $modelHealthCare3->setConnection('mysql2');

        $listFriend = DB::connection('mysql2')->table('refer_a_friend as refer1')
        ->leftJoin('clients AS clients1', 'refer1.is_client', '=', 'clients1.idclient')
        ->join('clients AS clients2', 'refer1.client_id', '=', 'clients2.idclient')
        ->leftJoin('statuses AS statuses1', 'clients1.status', '=', 'statuses1.idstatuses')
        ->select('refer1.*', 'clients1.status', 'statuses1.status_portuguese', 'clients2.firstname', 'clients2.lastname')
        ->orderBy('id')
        ->get();

        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('US/Eastern'));
        $DateAndTime = $Object->format('Y-m-d-H-i-s');

        return view('front.refer-a-friend.refer-index', compact(
            'listFriend',
            'DateAndTime'
            )
        );


    }

    //API HEALTH REQUESTS
    public function apiHealth(){
        //FORM DE PREENCHIMENTO DO CLIENTE(SEM USO)
        session_start();


        return view('front.api.apiHealth');
    }

    public function apiHealthView(){

        session_start();

		$modelHealthCare = new ClientHealth;
        $modelHealthCare->setConnection('mysql2');

		$client = $modelHealthCare->where('idclient', request()->client_id)->first();

        return view('front.api.apiHealthSubmit', ['client' => $client]);
    }

    public function apiHealthJson(Request $request) {
        //Manipulação da URL recebida do CRM
        if($request->uses_tobacco==1){
            $tobacco = true;
        }else {
            $tobacco = false;
        }

        $people[] =
        [
            "age" => intval($request->age),
            "aptc_eligible" => true,
            "gender" => $request->gender,
            "uses_tobacco" => $tobacco
        ];
        if(isset($request->spouseAge) && isset($request->spouseGender) && isset($request->spouseUseTobacco)){

            $people[] =
            [
                'age' => intval($request->spouseAge[0]),
                'aptc_eligible' => true,
                'gender' => $request->spouseGender[0],
                'uses_tobacco' => filter_var($request->spouseUseTobacco[0], FILTER_VALIDATE_BOOLEAN)
            ];
        }

        if(isset($request->dependentAge) && isset($request->dependentGender) && isset($request->dependentUseTobacco)){
            foreach($request->dependentAge as $key => $value){
            $people[] =
            [
                'age' => intval($request->dependentAge[$key]),
                'aptc_eligible' => true,
                'gender' => $request->dependentGender[$key+1],
                'uses_tobacco' => filter_var($request->dependentUseTobacco[$key+1], FILTER_VALIDATE_BOOLEAN)
            ];}
        }
        $query = urlencode(serialize($people));
        $url = '/apiHealth/submit' .
        '?zipcode=' .$request->zipcode .
        '&income=' .$request->income .
        '&people=' .$query;
        return Redirect::to($url);

    }

    public function apiHealthId($id) {
        //Detalhes do seguro por ID

        #region Request
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/plans/'. $id .'?year='. request()->year .'&' .'?apikey={$apikey}',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(unserialize(urldecode(request()->body))),
            CURLOPT_HTTPHEADER => array(
                'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                'Content-Type: text/plain'
            ),
        ));

        $response = curl_exec($curl);

        if(curl_errno($curl)) {
            return 'Curl error: '.curl_error($curl);
        }

        curl_close($curl);

        $plan = json_decode($response);

        if(isset($plan->message)){
            return $plan->error;
        }

        #endregion

        setlocale(LC_MONETARY,"en_US");
        foreach($plan->plan->deductibles as $value) {
            $deductibles[] = $value->amount;
        }
        //Benefits mudança de nomenclatura para view
        foreach($plan->plan->benefits as $key => $value) {
            #region Doctor visit
            if($value->name == 'Primary Care Visit to Treat an Injury or Illness') {
                $doctorCostAfter = null;
                $doctorCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $doctorCostAfter = 'Free';
                                $doctorCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $doctorCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $doctorCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $doctorCostAfter = 'Full Price';
                                    $doctorCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $doctorCostAfter = 'Full Price';
                                    $doctorCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $doctorCostAfter = 'Full Price';
                                    $doctorCostBefore = 'Free';
                                }
                            }else {
                                $doctorCostAfter = $value->cost_sharings[$i]->display_string;
                                $doctorCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $doctorCostAfter = 'Not Covered';
                            $doctorCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Specialist Visit') {
                $specialistCostAfter = null;
                $specialistCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $specialistCostAfter = 'Free';
                                $specialistCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $specialistCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $specialistCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $specialistCostAfter = 'Full Price';
                                    $specialistCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $specialistCostAfter = 'Full Price';
                                    $specialistCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $specialistCostAfter = 'Full Price';
                                    $specialistCostBefore = 'Free';
                                }
                            }else {
                                $specialistCostAfter = $value->cost_sharings[$i]->display_string;
                                $specialistCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $specialistCostAfter = 'Not Covered';
                            $specialistCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Preventive Care/Screening/Immunization') {
                $preventiveCostAfter = null;
                $preventiveCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $preventiveCostAfter = 'Free';
                                $preventiveCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $preventiveCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $preventiveCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $preventiveCostAfter = 'Full Price';
                                    $preventiveCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $preventiveCostAfter = 'Full Price';
                                    $preventiveCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $preventiveCostAfter = 'Full Price';
                                    $preventiveCostBefore = 'Free';
                                }
                            }else {
                                $preventiveCostAfter = $value->cost_sharings[$i]->display_string;
                                $preventiveCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $preventiveCostAfter = 'Not Covered';
                            $preventiveCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            #endregion

            #region Drugs
            if($value->name == 'Generic Drugs') {
                $drugCostAfter = null;
                $drugCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $drugCostAfter = 'Free';
                                $drugCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $drugCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $drugCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $drugCostAfter = 'Full Price';
                                    $drugCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $drugCostAfter = 'Full Price';
                                    $drugCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $drugCostAfter = 'Full Price';
                                    $drugCostBefore = 'Free';
                                }
                            }else {
                                $drugCostAfter = $value->cost_sharings[$i]->display_string;
                                $drugCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $drugCostAfter = 'Not Covered';
                            $drugCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Preferred Brand Drugs') {
                $brandDrugCostAfter = null;
                $brandDrugCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $brandDrugCostAfter = 'Free';
                                $brandDrugCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $brandDrugCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $brandDrugCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $brandDrugCostAfter = 'Full Price';
                                    $brandDrugCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $brandDrugCostAfter = 'Full Price';
                                    $brandDrugCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $brandDrugCostAfter = 'Full Price';
                                    $brandDrugCostBefore = 'Free';
                                }
                            }else {
                                $brandDrugCostAfter = $value->cost_sharings[$i]->display_string;
                                $brandDrugCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $brandDrugCostAfter = 'Not Covered';
                            $brandDrugCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Non-Preferred Brand Drugs') {
                $nonBrandDrugCostAfter = null;
                $nonBrandDrugCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $nonBrandDrugCostAfter = 'Free';
                                $nonBrandDrugCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $nonBrandDrugCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $nonBrandDrugCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $nonBrandDrugCostAfter = 'Full Price';
                                    $nonBrandDrugCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $nonBrandDrugCostAfter = 'Full Price';
                                    $nonBrandDrugCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $nonBrandDrugCostAfter = 'Full Price';
                                    $nonBrandDrugCostBefore = 'Free';
                                }
                            }else {
                                $nonBrandDrugCostAfter = $value->cost_sharings[$i]->display_string;
                                $nonBrandDrugCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $nonBrandDrugCostAfter = 'Not Covered';
                            $nonBrandDrugCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Specialty Drugs') {
                $specialtyDrugCostAfter = null;
                $specialtyDrugCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $specialtyDrugCostAfter = 'Free';
                                $specialtyDrugCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $specialtyDrugCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $specialtyDrugCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $specialtyDrugCostAfter = 'Full Price';
                                    $specialtyDrugCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $specialtyDrugCostAfter = 'Full Price';
                                    $specialtyDrugCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $specialtyDrugCostAfter = 'Full Price';
                                    $specialtyDrugCostBefore = 'Free';
                                }
                            }else {
                                $specialtyDrugCostAfter = $value->cost_sharings[$i]->display_string;
                                $specialtyDrugCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $specialtyDrugCostAfter = 'Not Covered';
                            $specialtyDrugCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            #endregion

            #region Labs
            if($value->name == 'X-rays and Diagnostic Imaging') {
                $xRayCostAfter = null;
                $xRayCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $xRayCostAfter = 'Free';
                                $xRayCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $xRayCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $xRayCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $xRayCostAfter = 'Full Price';
                                    $xRayCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $xRayCostAfter = 'Full Price';
                                    $xRayCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $xRayCostAfter = 'Full Price';
                                    $xRayCostBefore = 'Free';
                                }
                            }else {
                                $xRayCostAfter = $value->cost_sharings[$i]->display_string;
                                $xRayCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $xRayCostAfter = 'Not Covered';
                            $xRayCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Imaging (CT/PET Scans, MRIs)') {
                $imagingCostAfter = null;
                $imagingCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $imagingCostAfter = 'Free';
                                $imagingCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $imagingCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $imagingCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $imagingCostAfter = 'Full Price';
                                    $imagingCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $imagingCostAfter = 'Full Price';
                                    $imagingCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $imagingCostAfter = 'Full Price';
                                    $imagingCostBefore = 'Free';
                                }
                            }else {
                                $imagingCostAfter = $value->cost_sharings[$i]->display_string;
                                $imagingCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $imagingCostAfter = 'Not Covered';
                            $imagingCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Laboratory Outpatient and Professional Services') {
                $bloodCostAfter = null;
                $bloodCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $bloodCostAfter = 'Free';
                                $bloodCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $bloodCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $bloodCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $bloodCostAfter = 'Full Price';
                                    $bloodCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $bloodCostAfter = 'Full Price';
                                    $bloodCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $bloodCostAfter = 'Full Price';
                                    $bloodCostBefore = 'Free';
                                }
                            }else {
                                $bloodCostAfter = $value->cost_sharings[$i]->display_string;
                                $bloodCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $bloodCostAfter = 'Not Covered';
                            $bloodCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }

            #endregion

            #region Emergency

            if($value->name == 'Emergency Room Services') {
                $emergencyCostAfter = null;
                $emergencyCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $emergencyCostAfter = 'Free';
                                $emergencyCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $emergencyCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $emergencyCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $emergencyCostAfter = 'Full Price';
                                    $emergencyCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $emergencyCostAfter = 'Full Price';
                                    $emergencyCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $emergencyCostAfter = 'Full Price';
                                    $emergencyCostBefore = 'Free';
                                }
                            }else {
                                $emergencyCostAfter = $value->cost_sharings[$i]->display_string;
                                $emergencyCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $emergencyCostAfter = 'Not Covered';
                            $emergencyCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Outpatient Facility Fee (e.g., Ambulatory Surgery Center)') {
                $outpatientFacilityCostAfter = null;
                $outpatientFacilityCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $outpatientFacilityCostAfter = 'Free';
                                $outpatientFacilityCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $outpatientFacilityCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $outpatientFacilityCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $outpatientFacilityCostAfter = 'Full Price';
                                    $outpatientFacilityCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $outpatientFacilityCostAfter = 'Full Price';
                                    $outpatientFacilityCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $outpatientFacilityCostAfter = 'Full Price';
                                    $outpatientFacilityCostBefore = 'Free';
                                }
                            }else {
                                $outpatientFacilityCostAfter = $value->cost_sharings[$i]->display_string;
                                $outpatientFacilityCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $outpatientFacilityCostAfter = 'Not Covered';
                            $outpatientFacilityCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Outpatient Surgery Physician/Surgical Services') {
                $outpatientPhysicianCostAfter = null;
                $outpatientPhysicianCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $outpatientPhysicianCostAfter = 'Free';
                                $outpatientPhysicianCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $outpatientPhysicianCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $outpatientPhysicianCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $outpatientPhysicianCostAfter = 'Full Price';
                                    $outpatientPhysicianCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $outpatientPhysicianCostAfter = 'Full Price';
                                    $outpatientPhysicianCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $outpatientPhysicianCostAfter = 'Full Price';
                                    $outpatientPhysicianCostBefore = 'Free';
                                }
                            }else {
                                $outpatientPhysicianCostAfter = $value->cost_sharings[$i]->display_string;
                                $outpatientPhysicianCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $outpatientPhysicianCostAfter = 'Not Covered';
                            $outpatientPhysicianCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Emergency Transportation/Ambulance') {
                $ambulanceCostAfter = null;
                $ambulanceCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $ambulanceCostAfter = 'Free';
                                $ambulanceCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $ambulanceCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $ambulanceCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $ambulanceCostAfter = 'Full Price';
                                    $ambulanceCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $ambulanceCostAfter = 'Full Price';
                                    $ambulanceCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $ambulanceCostAfter = 'Full Price';
                                    $ambulanceCostBefore = 'Free';
                                }
                            }else {
                                $ambulanceCostAfter = $value->cost_sharings[$i]->display_string;
                                $ambulanceCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $ambulanceCostAfter = 'Not Covered';
                            $ambulanceCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Outpatient Rehabilitation Services') {
                $rehabilitationCostAfter = null;
                $rehabilitationCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $rehabilitationCostAfter = 'Free';
                                $rehabilitationCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $rehabilitationCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $rehabilitationCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $rehabilitationCostAfter = 'Full Price';
                                    $rehabilitationCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $rehabilitationCostAfter = 'Full Price';
                                    $rehabilitationCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $rehabilitationCostAfter = 'Full Price';
                                    $rehabilitationCostBefore = 'Free';
                                }
                            }else {
                                $rehabilitationCostAfter = $value->cost_sharings[$i]->display_string;
                                $rehabilitationCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $rehabilitationCostAfter = 'Not Covered';
                            $rehabilitationCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Inpatient Hospital Services (e.g., Hospital Stay)') {
                $hospitalFacilityCostAfter = null;
                $hospitalFacilityCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $hospitalFacilityCostAfter = 'Free';
                                $hospitalFacilityCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $hospitalFacilityCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $hospitalFacilityCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $hospitalFacilityCostAfter = 'Full Price';
                                    $hospitalFacilityCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $hospitalFacilityCostAfter = 'Full Price';
                                    $hospitalFacilityCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $hospitalFacilityCostAfter = 'Full Price';
                                    $hospitalFacilityCostBefore = 'Free';
                                }
                            }else {
                                $hospitalFacilityCostAfter = $value->cost_sharings[$i]->display_string;
                                $hospitalFacilityCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $hospitalFacilityCostAfter = 'Not Covered';
                            $hospitalFacilityCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Inpatient Physician and Surgical Services') {
                $hospitalPhysicianCostAfter = null;
                $hospitalPhysicianCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $hospitalPhysicianCostAfter = 'Free';
                                $hospitalPhysicianCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $hospitalPhysicianCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $hospitalPhysicianCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $hospitalPhysicianCostAfter = 'Full Price';
                                    $hospitalPhysicianCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $hospitalPhysicianCostAfter = 'Full Price';
                                    $hospitalPhysicianCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $hospitalPhysicianCostAfter = 'Full Price';
                                    $hospitalPhysicianCostBefore = 'Free';
                                }
                            }else {
                                $hospitalPhysicianCostAfter = $value->cost_sharings[$i]->display_string;
                                $hospitalPhysicianCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $hospitalPhysicianCostAfter = 'Not Covered';
                            $hospitalPhysicianCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }

            #endregion

            #region Mental
            if($value->name == 'Mental/Behavioral Health Outpatient Services') {
                $mentalOutpatientAfter = null;
                $mentalOutpatientBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $mentalOutpatientAfter = 'Free';
                                $mentalOutpatientBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $mentalOutpatientAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $mentalOutpatientBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $mentalOutpatientAfter = 'Full Price';
                                    $mentalOutpatientBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $mentalOutpatientAfter = 'Full Price';
                                    $mentalOutpatientBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $mentalOutpatientAfter = 'Full Price';
                                    $mentalOutpatientBefore = 'Free';
                                }
                            }else {
                                $mentalOutpatientAfter = $value->cost_sharings[$i]->display_string;
                                $mentalOutpatientBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $mentalOutpatientAfter = 'Not Covered';
                            $mentalOutpatientBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }

            if($value->name == 'Mental/Behavioral Health Inpatient Services') {
                $mentalInpatientAfter = null;
                $mentalInpatientBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $mentalInpatientAfter = 'Free';
                                $mentalInpatientBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $mentalInpatientAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $mentalInpatientBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $mentalInpatientAfter = 'Full Price';
                                    $mentalInpatientBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $mentalInpatientAfter = 'Full Price';
                                    $mentalInpatientBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $mentalInpatientAfter = 'Full Price';
                                    $mentalInpatientBefore = 'Free';
                                }
                            }else {
                                $mentalInpatientAfter = $value->cost_sharings[$i]->display_string;
                                $mentalInpatientBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $mentalInpatientAfter = 'Not Covered';
                            $mentalInpatientBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }

            #endregion

        }

        return view('front.api.apiHealthId', [
            'plan' => $plan->plan,
            'deductibles' => $deductibles[0],
            'doctorCostAfter' => $doctorCostAfter,
            'doctorCostBefore' => $doctorCostBefore,
            'drugCostAfter' => $drugCostAfter,
            'drugCostBefore' => $drugCostBefore,
            'brandDrugCostAfter' => $brandDrugCostAfter,
            'brandDrugCostBefore' => $brandDrugCostBefore,
            'nonBrandDrugCostAfter' => $nonBrandDrugCostAfter,
            'nonBrandDrugCostBefore' => $nonBrandDrugCostBefore,
            'specialtyDrugCostAfter' => $specialtyDrugCostAfter,
            'specialtyDrugCostBefore' => $specialtyDrugCostBefore,
            'specialistCostAfter' => $specialistCostAfter,
            'specialistCostBefore' => $specialistCostBefore,
            'xRayCostAfter' => $xRayCostAfter,
            'xRayCostBefore' => $xRayCostBefore,
            'imagingCostAfter' => $imagingCostAfter,
            'imagingCostBefore' => $imagingCostBefore,
            'bloodCostAfter' => $bloodCostAfter,
            'bloodCostBefore' => $bloodCostBefore,
            'emergencyCostAfter' => $emergencyCostAfter,
            'emergencyCostBefore' => $emergencyCostBefore,
            'outpatientFacilityCostAfter' => $outpatientFacilityCostAfter,
            'outpatientFacilityCostBefore' => $outpatientFacilityCostBefore,
            'outpatientPhysicianCostAfter' => $outpatientPhysicianCostAfter,
            'outpatientPhysicianCostBefore' => $outpatientPhysicianCostBefore,
            'ambulanceCostAfter' => $ambulanceCostAfter,
            'ambulanceCostBefore' => $ambulanceCostBefore,
            'rehabilitationCostAfter' => $rehabilitationCostAfter,
            'rehabilitationCostBefore' => $rehabilitationCostBefore,
            'hospitalFacilityCostAfter' => $hospitalFacilityCostAfter,
            'hospitalFacilityCostBefore' => $hospitalFacilityCostBefore,
            'hospitalPhysicianCostAfter' => $hospitalPhysicianCostAfter,
            'hospitalPhysicianCostBefore' => $hospitalPhysicianCostBefore,
            'preventiveCostAfter' => $preventiveCostAfter,
            'preventiveCostBefore' => $preventiveCostBefore,
            'mentalOutpatientAfter' => $mentalOutpatientAfter,
            'mentalOutpatientBefore' => $mentalOutpatientBefore,
            'mentalInpatientAfter' => $mentalInpatientAfter,
            'mentalInpatientBefore' => $mentalInpatientBefore,
            'response' => $response
        ]);

    }

    public function apiHealthPdf(Request $request) {
        //Salvar cotação em pdf
        $modelHealthCare = new ClientHealth;
        $modelHealthCare->setConnection('mysql2');

        $modelHealthCare2 = new AgentHealth;
        $modelHealthCare2->setConnection('mysql2');


        $modelHealthCare3 = new UploadDocuments;
        $modelHealthCare3->setConnection('mysql2');


        $client = $modelHealthCare->where('idclient', request()->client_id)->first();

        if(!isset($client)){
            return redirect()->back()->with('messageError', 'Client not found!');
        }

        $mes_extenso = array(
            'Jan' => 'Janeiro',
            'Feb' => 'Fevereiro',
            'Mar' => 'Marco',
            'Apr' => 'Abril',
            'May' => 'Maio',
            'Jun' => 'Junho',
            'Jul' => 'Julho',
            'Aug' => 'Agosto',
            'Nov' => 'Novembro',
            'Sep' => 'Setembro',
            'Oct' => 'Outubro',
            'Dec' => 'Dezembro'
        );
        $mes = date('M');

        setlocale(LC_ALL, NULL);
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

        $date = date('d').' de '.$mes_extenso["$mes"].' de '.date('Y');

        $idDate = new DateTime();
        $idDate->setTimezone(new DateTimeZone('US/Eastern'));

        $quotation = 'Quotation'. '#' . $idDate->format('YmdHis');

        $path = 'images/table-head.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $path2 = 'assets/images/watermark.png';
        $type2 = pathinfo($path2, PATHINFO_EXTENSION);
        $data2 = file_get_contents($path2);
        $logo2 = 'data:image/' . $type2 . ';base64,' . base64_encode($data2);
        $path3 = 'assets/images/logo-color.png';
        $type3 = pathinfo($path3, PATHINFO_EXTENSION);
        $data3 = file_get_contents($path3);
        $logo3 = 'data:image/' . $type3 . ';base64,' . base64_encode($data3);


        view()->share([
            'logo' => $logo,
            'logo2' => $logo2,
            'logo3' => $logo3,
            'client' => $client,
            'date' => $date,
            'request' => $request
        ]);

        //return view('pdf.download.apiHealth-pdf');


        $name = '2easyinsurance-Health-Insurance';


        /* Options */
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', false);
        $options->set('isPhpEnabled', true);
        $options->set('isJavascriptEnabled', TRUE);

        /********/

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('pdf.download.apiHealth-pdf'));
        $dompdf->setPaper("letter");
        $dompdf->render();
        //$dompdf->stream(strtoupper($name).".pdf",["Attachment" => false]);
        $pdf = $dompdf->output();

        $hash = time() . md5(uniqid());

        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('US/Eastern'));

        $modelHealthCare3::create([
            'document_type' => $quotation,
            'id_client' => $client->idclient,
            'associated' => 'client',
            'due_date_defined' => $Object->format('Y-m-d'),
            'document_name' => $hash . '.pdf'
        ]);

        //Salvar pdf no servidor
        if(empty($pdf)){
            /* Return if Empty Signature */
            $this->set_flashdata("error-mini", "Erro ao gerar PDF!");
            redirect()->back();
        }

		if (!file_exists(resource_path('../../healthcare/healthcare/application/uploads/clientdocs_' . $client->idclient))) {
			mkdir(resource_path('../../healthcare/healthcare/application/uploads/clientdocs_' . $client->idclient) . '', 0777, true);
		}

        file_put_contents(resource_path('../../healthcare/healthcare/application/uploads/clientdocs_' . $client->idclient . '/') .$hash.'.pdf',$pdf);


        $url = 'https://admin.2easyinsurance.com/admin/client/' . request()->client_id;

        return Redirect::to($url);

    }

    public function apiHealthPdfNoDb(Request $request) {
        //Vizualizar pdf sem salvar no CRM
        $modelHealthCare = new ClientHealth;
        $modelHealthCare->setConnection('mysql2');

        $client = $modelHealthCare->where('idclient', request()->client_id)->first();

        if(!isset($client)){
            return redirect()->back()->with('messageError', 'Client not found!');
        }

        $mes_extenso = array(
            'Jan' => 'Janeiro',
            'Feb' => 'Fevereiro',
            'Mar' => 'Marco',
            'Apr' => 'Abril',
            'May' => 'Maio',
            'Jun' => 'Junho',
            'Jul' => 'Julho',
            'Aug' => 'Agosto',
            'Nov' => 'Novembro',
            'Sep' => 'Setembro',
            'Oct' => 'Outubro',
            'Dec' => 'Dezembro'
        );
        $mes = date('M');

        setlocale(LC_ALL, NULL);
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

        $date = date('d').' de '.$mes_extenso["$mes"].' de '.date('Y');

        $idDate = new DateTime();
        $idDate->setTimezone(new DateTimeZone('US/Eastern'));

        $path = 'images/table-head.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $path2 = 'assets/images/watermark.png';
        $type2 = pathinfo($path2, PATHINFO_EXTENSION);
        $data2 = file_get_contents($path2);
        $logo2 = 'data:image/' . $type2 . ';base64,' . base64_encode($data2);
        $path3 = 'assets/images/logo-color.png';
        $type3 = pathinfo($path3, PATHINFO_EXTENSION);
        $data3 = file_get_contents($path3);
        $logo3 = 'data:image/' . $type3 . ';base64,' . base64_encode($data3);


        view()->share([
            'logo' => $logo,
            'logo2' => $logo2,
            'logo3' => $logo3,
            'client' => $client,
            'date' => $date,
            'request' => $request
        ]);

        //return view('pdf.download.apiHealth-pdf');

        $name = '2easyinsurance-Health-Insurance';

        /* Options */
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', false);
        $options->set('isPhpEnabled', true);
        $options->set('isJavascriptEnabled', TRUE);

        /********/

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('pdf.download.apiHealth-pdf'));
        $dompdf->setPaper("letter");
        $dompdf->render();
        $dompdf->stream(strtoupper($name).".pdf",["Attachment" => false]);

    }

    public function apiHealthZipcode(Request $request){
        //Busca zipcode
        $curlZip = curl_init();

        curl_setopt_array($curlZip, array(
            CURLOPT_URL =>
            'https://marketplace.api.healthcare.gov/api/v1/counties/by/zip/'. $request->zipcode .'?apikey={$apikey}',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                'Content-Type: text/plain'
            ),
        ));

        $responseZip = curl_exec($curlZip);
        if(curl_errno($curlZip)) {
            return 'Curl error: '.curl_error($curlZip);
        }
        curl_close($curlZip);

        $info = json_decode($responseZip);

        if(isset($info->message)){
            return $info->error;
        }

        $city = $info->counties;
        if(count($city)==0){
            return 'Zipcode não encontrado!';
        }

        return $city;

    }

    public function apiHealthRequest(Request $request) {

        #region VARS
        if(isset($request->children)){
            $childrenArray = $request->children;
        }else {
            $childrenArray = [];
        }

        $children = [];
        $adult = [];
        $bodyAffordability = [];
        $peopleAffordability = [];
        $affordability = null;
        $benefitsDrugLowest = null;
        $benefitsDoctorVisitsLowest = null;
        $benefitsDrugAffordable = null;
        $mostAffordable = null;
        $benefitsDoctorVisitsAffordable = null;
        $lowestPremium = null;
        $specialistCostAffordable = null;
        $specialistCostLowest = null;
        $maxAgeChip = 0;
        $plans = null;
        $rating = null;
        $doctorCost = null;
        $drugCost = null;
        $emergencyCost = null;
        $specialistCost = null;

        $place = [
            'countyfips' => $request->zipcodeFips,
            'state' => $request->zipcodeState,
            'zipcode' => $request->zipcodeNumber
        ];

        if($request->issuers==null || $request->issuers==[null] || $request->issuers==[]) {
            $issuers = [];
        }else {
            $issuers = $request->issuers;
        }

        if($request->metal_level==null || $request->metal_level==[null] || $request->metal_level==[]) {
            $metalLevels = [];
        }else {
            $metalLevels = $request->metal_level;
        }

        if($request->deductible==null) {
            $reqDeductible = null;
        }else {
            $reqDeductible = intval($request->deductible);
        }

        if($request->year==null) {
            $reqYear = intval(date('Y', strtotime('+1 year')));
        }else {
            $reqYear = intval($request->year);
        }

        if(isset($request->offset)) {
            $offset = intval($request->offset);
        }else {
            $offset = 0;
        }


        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('US/Eastern'));
        $DateAndTime = $Object->format('Y');

        #endregion

        //Idade mínima de cobertura
        $curlChip = curl_init();

        curl_setopt_array($curlChip, array(
          CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/states/'. $request->zipcodeState .'/medicaid??apikey=$apikey',
          CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                'Content-Type: text/plain'
            ),
        ));

        $responseChip = curl_exec($curlChip);

        curl_close($curlChip);

        $chip = json_decode($responseChip);

        if(isset($chip->message)){
            return $chip->error;
        }

        if(count($chip->chip)==0){
            $maxAgeChip = 18;
        }else {
            $maxAgeChip = $chip->chip[0]->max_age;
        }


        #region SEARCH PLANS

        //Array clientes inclusos no plano, depende da idade
        foreach($request->people as $key => $value) {
            if($value['age'] <= $maxAgeChip) {

                $hasMec[$key] = true;

            }else{
                $hasMec[$key] = false;
            }
            $peopleEstimate[] = [
                'age' => intval($value['age']),
                'aptc_eligible' => filter_var($value['aptc_eligible'], FILTER_VALIDATE_BOOLEAN),
                'gender' => $value['gender'],
                'has_mec' => $hasMec[$key],
                'uses_tobacco' => filter_var($value['uses_tobacco'], FILTER_VALIDATE_BOOLEAN),
                "utilization_level"=> "Medium"
            ];
        };


        #region ESTIMATE SUBSIDY

        //Cálculo de subsídio do governo
        $bodyEstimate = [
            "household" => [
                "income" => intval(str_replace(',', '', $request->income)),
                "people" => $peopleEstimate,
            ],
            "market" => "Individual",
            "place" => $place,
            "year" => $reqYear,
        ];
        $curlEstimate = curl_init();

        curl_setopt_array($curlEstimate, array(
            CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/households/eligibility/estimates?apikey=$apikey&year='. $reqYear,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($bodyEstimate),
            CURLOPT_HTTPHEADER => array(
                'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                'Content-Type: application/json'
            ),
        ));

        $responseEstimate = curl_exec($curlEstimate);

        curl_close($curlEstimate);

        $estimate = json_decode($responseEstimate);

        if(isset($estimate->message)){
            return $estimate->error;
        }

        $estimateSub = $estimate->estimates[0]->aptc;

        foreach($estimate->estimates as $key => $value) {
            if($value->is_medicaid_chip==true){
                $chips[] = 1;
            }else {
                $chips[] = 0;
            }
        };

        foreach($request->people as $key => $value) {

            if(in_array(1, $chips)==0 || in_array(0, $chips)==0){

                if(in_array(1, $chips)==0 || in_array(0, $chips)==1){
                    //recalculando subsídio com medicaid
                    $hasMec[$key] = false;
                    $hasMecAffordability[$key] = true;
                    $peopleEstimate2[] = [
                        'age' => intval($value['age']),
                        'aptc_eligible' => filter_var($value['aptc_eligible'], FILTER_VALIDATE_BOOLEAN),
                        'gender' => $value['gender'],
                        'has_mec' => $hasMec[$key],
                        'uses_tobacco' => filter_var($value['uses_tobacco'], FILTER_VALIDATE_BOOLEAN),
                        "utilization_level"=> "Medium"
                    ];
                    $bodyEstimate = [
                        "household" => [
                            "income" => intval(str_replace(',', '', $request->income)),
                            "people" => $peopleEstimate2,
                        ],
                        "market" => "Individual",
                        "place" => $place,
                        "year" => $reqYear,
                    ];
                    $curlEstimate = curl_init();

                    curl_setopt_array($curlEstimate, array(
                        CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/households/eligibility/estimates?apikey=$apikey&year='. $reqYear,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => json_encode($bodyEstimate),
                        CURLOPT_HTTPHEADER => array(
                            'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                            'Content-Type: application/json'
                        ),
                    ));

                    $responseEstimate = curl_exec($curlEstimate);

                    curl_close($curlEstimate);

                    $estimate = json_decode($responseEstimate);

                    $estimateSub = $estimate->estimates[0]->aptc;
                }else {
                    if($value['age'] <= $maxAgeChip) {
                        $hasMec[$key] = false;
                        $hasMecAffordability[$key] = true;
                    }else{
                        $hasMec[$key] = false;
                        $hasMecAffordability[$key] = true;
                    }
                    $adult[] = [
                        'index' => $key,
                        'gender' => $value['gender'],
                        'age' => $value['age']
                    ];
                }

            }else {
                if($estimateSub!==0){
                    if($value['age'] <= $maxAgeChip) {
                        $hasMec[$key] = true;
                        $hasMecAffordability[$key] = true;
                        $children[] = [
                            'index' => $key,
                            'gender' => $value['gender'],
                            'age' => $value['age']
                        ];
                    }else{
                        $hasMec[$key] = false;
                        $hasMecAffordability[$key] = true;
                        $adult[] = [
                            'index' => $key,
                            'gender' => $value['gender'],
                            'age' => $value['age']
                        ];
                    }
                }else {
                    if($value['age'] <= $maxAgeChip) {
                        $hasMec[$key] = false;
                        $hasMecAffordability[$key] = true;
                    }else{
                        $hasMec[$key] = false;
                        $hasMecAffordability[$key] = true;
                    }
                    $adult[] = [
                        'index' => $key,
                        'gender' => $value['gender'],
                        'age' => $value['age']
                    ];
                }
            }

            for($i=0; $i<count($childrenArray); $i++){
                if($key == $childrenArray[$i]){
                    $hasMec[$key] = false;
                    $hasMecAffordability[$key] = false;
                }
            }
            $people[] = [
                'age' => intval($value['age']),
                'aptc_eligible' => filter_var($value['aptc_eligible'], FILTER_VALIDATE_BOOLEAN),
                'gender' => $value['gender'],
                'has_mec' => $hasMec[$key],
                'uses_tobacco' => filter_var($value['uses_tobacco'], FILTER_VALIDATE_BOOLEAN),
                "utilization_level"=> "Medium"
            ];
            $peopleAffordability[] = [
                'age' => intval($value['age']),
                'aptc_eligible' => filter_var($value['aptc_eligible'], FILTER_VALIDATE_BOOLEAN),
                'gender' => $value['gender'],
                'has_mec' => $hasMecAffordability[$key],
                'uses_tobacco' => filter_var($value['uses_tobacco'], FILTER_VALIDATE_BOOLEAN),
                "utilization_level"=> "Medium"
            ];
        };
            //Calculo de subsidio caso selecionar CHIP
            if(count($childrenArray)!==0) {
                foreach($request->people as $key => $value) {
                    if($estimateSub!==0) {
                        if(in_array(1, $chips)!==0 || in_array(0, $chips)!==0){
                            $bodyAffordability = [
                                "household" => [
                                    "people" => $peopleAffordability,
                                ],
                                "market" => "Individual",
                                "place" => $place,
                                "year" => $reqYear,
                            ];
                            $curlAffordability = curl_init();

                            curl_setopt_array($curlAffordability, array(
                                CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/households/slcsp?apikey=$apikey&year=2024',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($bodyAffordability),
                                CURLOPT_HTTPHEADER => array(
                                    'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                                    'Content-Type: application/json'
                                ),
                            ));

                            $responseAffordability = curl_exec($curlAffordability);

                            curl_close($curlAffordability);

                            $affordability = json_decode($responseAffordability);

                            if(isset($affordability->message)){
                                return $affordability->error;
                            }

                            $estimateSub = round($estimateSub + $affordability->premium);
                            break;
                        }
                    }
                }

            }


        #endregion

        #region Most Affordable
        $bodyAffordable = [

            "household" => [
                "income" => intval(str_replace(',', '', $request->income)),
                "people" =>
                    $people
                ,
            ],
            "market" => "Individual",
            "place" => $place,
            "sort"=>
                   "total_costs"
                ,
            "limit" => 10,
            "offset" => $offset,
            "year" => $reqYear,
        ];
        $curlAffordable = curl_init();

        curl_setopt_array($curlAffordable, array(
            CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/plans/search?apikey=$apikey',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($bodyAffordable),
            CURLOPT_HTTPHEADER => array(
                'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                'Content-Type: text/plain'
            ),
        ));
        $responseAffordable = curl_exec($curlAffordable);
        if(curl_errno($curlAffordable)) {
            return 'Curl error: '.curl_error($curlAffordable);
        }
        curl_close($curlAffordable);
        $affordable = json_decode($responseAffordable);

        if(isset($affordable->message)){
            return $affordable->error;
        }

        $mostAffordable = $affordable->plans[0];



        #endregion

        //Range de planos dos filtros
        if($request->premium==null) {
            $reqPremium = null;
        }else if($affordable->ranges->premiums->min > $request->premium) {
            $reqPremium = ($affordable->ranges->premiums->min * 1.2);
        }else {
            $reqPremium = (floatval($request->premium) * 1.2);
        }

        //Lista de Levels e Issuers
        foreach ($affordable->facet_groups as $key => $value) {
            if($value->name == 'metalLevels') {
                $levels = $value->facets;
            }
            if($value->name == 'issuers') {
                $issuer = $value->facets;
            }
        }

        $query = urlencode(serialize($bodyAffordable));


        #region ALL PLANS

        $body = [
            "filter" => [
                "issuers" =>

                    $issuers

                ,
                "metal_levels" =>

                    $metalLevels

                ,
                "deductible" => $reqDeductible,
                "premium" => $reqPremium
            ],
            "household" => [
                "income" => intval(str_replace(',', '', $request->income)),
                "people" =>
                    $people
                ,
            ],
            "market" => "Individual",
            "place" => $place,
            "sort"=> "premium",
            "limit" => 10,
            "offset" => $offset,
            "year" => $reqYear,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/plans/search?apikey=$apikey',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => array(
                'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                'Content-Type: text/plain'
            ),
        ));
        $response = curl_exec($curl);
        if(curl_errno($curl)) {
            return 'Curl error: '.curl_error($curl);
        }
        curl_close($curl);
        $plan = json_decode($response);
        if(isset($plan->message)){
            return $plan->error;
        }
        $plans = $plan->plans;

        //Recalculando planos removendo filtro de premium(Para não ter pesquisas iniciais sem nenhum plano retornado)
        if(count($plans)==0) {
            $reqPremium = null;
            $body = [
                "filter" => [
                    "issuers" =>

                        $issuers

                    ,
                    "metal_levels" =>

                        $metalLevels

                    ,
                    "deductible" => $reqDeductible,
                    "premium" => $reqPremium
                ],
                "household" => [
                    "income" => intval(str_replace(',', '', $request->income)),
                    "people" =>
                        $people
                    ,
                ],
                "market" => "Individual",
                "place" => $place,
                "sort"=> "premium",
                "limit" => 10,
                "offset" => $offset,
                "year" => $reqYear,
            ];

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/plans/search?apikey=$apikey',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($body),
                CURLOPT_HTTPHEADER => array(
                    'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                    'Content-Type: text/plain'
                ),
            ));
            $response = curl_exec($curl);
            if(curl_errno($curl)) {
                return 'Curl error: '.curl_error($curl);
            }
            curl_close($curl);
            $plan = json_decode($response);
            if(isset($plan->message)){
                return $plan->error;
            }
            $plans = $plan->plans;
        }

        //Recalculando planos removendo filtro de premium e deductible
        if(count($plans)==0) {
            $reqPremium = null;
            $reqDeductible = null;
            $body = [
                "filter" => [
                    "issuers" =>

                        $issuers

                    ,
                    "metal_levels" =>

                        $metalLevels

                    ,
                    "deductible" => $reqDeductible,
                    "premium" => $reqPremium
                ],
                "household" => [
                    "income" => intval(str_replace(',', '', $request->income)),
                    "people" =>
                        $people
                    ,
                ],
                "market" => "Individual",
                "place" => $place,
                "sort"=> "premium",
                "limit" => 10,
                "offset" => $offset,
                "year" => $reqYear,
            ];

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/plans/search?apikey=$apikey',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($body),
                CURLOPT_HTTPHEADER => array(
                    'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                    'Content-Type: text/plain'
                ),
            ));
            $response = curl_exec($curl);
            if(curl_errno($curl)) {
                return 'Curl error: '.curl_error($curl);
            }
            curl_close($curl);
            $plan = json_decode($response);
            if(isset($plan->message)){
                return $plan->error;
            }
            $plans = $plan->plans;
        }

        #endregion

        #region Lowest Premium


        if(count($plans) !== 0){

            $lowestPremium = $plan->plans[0];

            //Mudança de nomenclaturas de beneficios Lowest Premium
            foreach($lowestPremium->benefits as $keys => $values) {
                if($values->name == 'Primary Care Visit to Treat an Injury or Illness') {
                    for ($i = 0; $i < count($values->cost_sharings); $i++) {
                        if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                            if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                $benefitsDoctorVisitsLowest = 'Free';
                            }else {
                                $benefitsDoctorVisitsLowest = $values->cost_sharings[$i]->display_string;
                            }
                            break;
                        }
                    }
                }

                if($values->name == 'Generic Drugs') {
                    for ($i = 0; $i < count($values->cost_sharings); $i++) {
                        if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                            if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                $benefitsDrugLowest = 'Free';
                            }else {
                                $benefitsDrugLowest = $values->cost_sharings[$i]->display_string;
                            }
                            break;
                        }
                    }
                }

                if($values->name == 'Specialist Visit') {
                    for ($i = 0; $i < count($values->cost_sharings); $i++) {$a[]= $i;
                        if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                            if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                $specialistCostLowest = 'Free';
                            }else {
                                $specialistCostLowest = $values->cost_sharings[$i]->display_string;
                            }
                            break;
                        }
                    }
                }
            }

            //Mudança de nomenclaturas de beneficios Most affordable
            foreach($mostAffordable->benefits as $keys => $values) {
                if($values->name == 'Primary Care Visit to Treat an Injury or Illness') {
                    for ($i = 0; $i < count($values->cost_sharings); $i++) {
                        if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                            if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                $benefitsDoctorVisitsAffordable = 'Free';
                            }else {
                                $benefitsDoctorVisitsAffordable = $values->cost_sharings[$i]->display_string;
                            }
                            break;
                        }
                    }
                }

                if($values->name == 'Generic Drugs') {
                    for ($i = 0; $i < count($values->cost_sharings); $i++) {
                        if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                            if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                $benefitsDrugAffordable = 'Free';
                            }else {
                                $benefitsDrugAffordable = $values->cost_sharings[$i]->display_string;
                            }
                            break;
                        }
                    }
                }

                if($values->name == 'Specialist Visit') {
                    for ($i = 0; $i < count($values->cost_sharings); $i++) {$a[]= $i;
                        if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                            if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                $specialistCostAffordable = 'Free';
                            }else {
                                $specialistCostAffordable = $values->cost_sharings[$i]->display_string;
                            }
                            break;
                        }
                    }
                }
            }

            //Mudança de nomenclaturas de beneficios All plans
            foreach($plan->plans as $key => $value) {
                $benefits[] = $value->benefits;
                $rating[] = $value->quality_rating->global_rating;
                foreach($benefits[$key] as $keys => $values) {
                    if($values->name == 'Primary Care Visit to Treat an Injury or Illness') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $doctorCost[] = 'Free';
                                }else {
                                    $doctorCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Generic Drugs') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $drugCost[] = 'Free';
                                }else {
                                    $drugCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Specialist Visit') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $specialistCost[] = 'Free';
                                }else {
                                    $specialistCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Emergency Room Services') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $emergencyCost[] = 'Free';
                                }else {
                                    $emergencyCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                }
            }

        }

        #endregion

        #endregion

        return [
            'plan' => $plans,
            'filter' => $affordable,
            'affordability' => $affordability,
            'body' => $body,
            'ranges' => $plan,
            'people' => $people,
            'query' => $query,
            'estimate' => $estimate,
            'estimateSub' => $estimateSub,
            'offset' => $offset,
            'mostAffordable' => $mostAffordable,
            'benefitsDoctorVisitsAffordable' => $benefitsDoctorVisitsAffordable,
            'benefitsDrugAffordable' => $benefitsDrugAffordable,
            'specialistCostAffordable' => $specialistCostAffordable,
            'lowestPremium' => $lowestPremium,
            'benefitsDoctorVisitsLowest' => $benefitsDoctorVisitsLowest,
            'benefitsDrugLowest' => $benefitsDrugLowest,
            'specialistCostLowest' => $specialistCostLowest,
            'benefitsDoctorVisits' => $doctorCost,
            'benefitsDrug' => $drugCost,
            'emergencyCost' => $emergencyCost,
            'specialistCost' => $specialistCost,
            'children' => $children,
            'adult' => $adult,
            'hasMec' => $hasMec,
            'rating' => $rating,
            'issuers' => $issuer,
            'levels' => $levels
        ];

    }

    public function apiHealthSearch(Request $request) {
        //Search plans com filtros
        #region VARS
        if(isset($request->children)){
            $childrenArray = $request->children;
        }else {
            $childrenArray = [];
        }

        $plans = null;
        $rating = null;
        $doctorCost = null;
        $drugCost = null;
        $emergencyCost = null;
        $specialistCost = null;

        $place = [
            'countyfips' => $request->zipcodeFips,
            'state' => $request->zipcodeState,
            'zipcode' => $request->zipcodeNumber
        ];

        if(isset($request->offset)) {
            $offset = intval($request->offset);
        }else {
            $offset = 0;
        }

        if($request->issuers==null) {
            $issuers = [];
        }else {
            $issuers = $request->issuers;
        }

        if($request->metal_level==null) {
            $metalLevels = [];
        }else {
            $metalLevels = $request->metal_level;
        }

        if($request->deductible==null) {
            $reqDeductible = null;
        }else {
            $reqDeductible = intval($request->deductible);
        }

        if($request->premium==null) {
            $reqPremium = null;
        }else if($request->premiumsMin > $request->premium) {
            $reqPremium = ($request->premiumsMin * 1.2);
        }else {
            $reqPremium = (floatval($request->premium) * 1.2);
        }

        if($request->year==null) {
            $reqYear = 2024;
        }else {
            $reqYear = intval($request->year);
        }

        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('US/Eastern'));
        $DateAndTime = $Object->format('Y');
        #endregion

        //Idade mínima de cobertura
        $curlChip = curl_init();

        curl_setopt_array($curlChip, array(
          CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/states/'. $request->zipcodeState .'/medicaid??apikey=$apikey',
          CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                'Content-Type: text/plain'
            ),
        ));

        $responseChip = curl_exec($curlChip);

        curl_close($curlChip);

        $chip = json_decode($responseChip);

        if(isset($chip->message)){
            return $chip->error;
        }

        if(count($chip->chip)==0){
            $maxAgeChip = 18;
        }else {
            $maxAgeChip = $chip->chip[0]->max_age;
        }

        #region Estimate

        foreach($request->people as $key => $value) {
            if($value['age'] <= $maxAgeChip) {

                    $hasMec[$key] = true;

            }else{
                $hasMec[$key] = false;
            }
            $peopleEstimate[] = [
                'age' => intval($value['age']),
                'aptc_eligible' => filter_var($value['aptc_eligible'], FILTER_VALIDATE_BOOLEAN),
                'gender' => $value['gender'],
                'has_mec' => $hasMec[$key],
                'uses_tobacco' => filter_var($value['uses_tobacco'], FILTER_VALIDATE_BOOLEAN),
                "utilization_level"=> "Medium"
            ];
        };

        $bodyEstimate = [
            "household" => [
                "income" => intval(str_replace(',', '', $request->income)),
                "people" => $peopleEstimate,
            ],
            "market" => "Individual",
            "place" => $place,
            "year" => $reqYear,
        ];
        $curlEstimate = curl_init();

        curl_setopt_array($curlEstimate, array(
            CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/households/eligibility/estimates?apikey=$apikey&year='. $reqYear,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($bodyEstimate),
            CURLOPT_HTTPHEADER => array(
                'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                'Content-Type: application/json'
            ),
        ));

        $responseEstimate = curl_exec($curlEstimate);

        curl_close($curlEstimate);

        $estimate = json_decode($responseEstimate);

        if(isset($estimate->message)){
            return $estimate->error;
        }

        foreach($estimate->estimates as $key => $value) {
            if($value->is_medicaid_chip==true){
                $chips[] = 1;
            }else {
                $chips[] = 0;
            }
        };

        foreach($request->people as $key => $value) {
            if(in_array(1, $chips)==0 || in_array(0, $chips)==0){

                if(in_array(1, $chips)==0 || in_array(0, $chips)==1){
                    $hasMec[$key] = false;
                }else {
                    if($value['age'] <= $maxAgeChip) {
                        $hasMec[$key] = false;
                    }else{
                        $hasMec[$key] = false;
                    }
                }
            }else {
                if($estimate->estimates[0]->aptc!==0){
                    if($value['age'] <= $maxAgeChip) {
                        $hasMec[$key] = true;
                    }else{
                        $hasMec[$key] = false;
                    }
                }else {
                    if($value['age'] <= $maxAgeChip) {
                        $hasMec[$key] = false;
                    }else{
                        $hasMec[$key] = false;
                    }
                }
            }

            for($i=0; $i<count($childrenArray); $i++){
                if($key == $childrenArray[$i]){
                    $hasMec[$key] = false;
                }
            }
            $people[] = [
                'age' => intval($value['age']),
                'aptc_eligible' => filter_var($value['aptc_eligible'], FILTER_VALIDATE_BOOLEAN),
                'gender' => $value['gender'],
                'has_mec' => $hasMec[$key],
                'uses_tobacco' => filter_var($value['uses_tobacco'], FILTER_VALIDATE_BOOLEAN),
                "utilization_level"=> "Medium"
            ];
        };


        #region ALL PLANS
        $body = [
            "filter" => [
                "issuers" =>

                    $issuers

                ,
                "metal_levels" =>

                    $metalLevels

                ,
                "deductible" => $reqDeductible,
                "premium" => $reqPremium
            ],
            "household" => [
                "income" => intval(str_replace(',', '', $request->income)),
                "people" =>
                    $people
                ,
            ],
            "market" => "Individual",
            "place" => $place,
            "sort"=> "premium",
            "limit" => 10,
            "offset" => $offset,
            "year" => $reqYear,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/plans/search?apikey=$apikey',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => array(
                'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                'Content-Type: text/plain'
            ),
        ));
        $response = curl_exec($curl);
        if(curl_errno($curl)) {
            return 'Curl error: '.curl_error($curl);
        }
        curl_close($curl);
        $plan = json_decode($response);
        if(isset($plan->message)){
            return $plan->error;
        }
        $plans = $plan->plans;


        if(count($plans)==0) {
            $reqPremium = null;
            $body = [
                "filter" => [
                    "issuers" =>

                        $issuers

                    ,
                    "metal_levels" =>

                        $metalLevels

                    ,
                    "deductible" => $reqDeductible,
                    "premium" => $reqPremium
                ],
                "household" => [
                    "income" => intval(str_replace(',', '', $request->income)),
                    "people" =>
                        $people
                    ,
                ],
                "market" => "Individual",
                "place" => $place,
                "sort"=> "premium",
                "limit" => 10,
                "offset" => $offset,
                "year" => $reqYear,
            ];

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/plans/search?apikey=$apikey',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($body),
                CURLOPT_HTTPHEADER => array(
                    'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                    'Content-Type: text/plain'
                ),
            ));
            $response = curl_exec($curl);
            if(curl_errno($curl)) {
                return 'Curl error: '.curl_error($curl);
            }
            curl_close($curl);
            $plan = json_decode($response);
            if(isset($plan->message)){
                return $plan->error;
            }
            $plans = $plan->plans;
        }

        #endregion

        #endregion

        if(count($plans) !== 0) {
            foreach($plan->plans as $key => $value) {
                $benefits[] = $value->benefits;
                $rating[] = $value->quality_rating->global_rating;
                foreach($benefits[$key] as $keys => $values) {
                    if($values->name == 'Primary Care Visit to Treat an Injury or Illness') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $doctorCost[] = 'Free';
                                }else {
                                    $doctorCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Generic Drugs') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $drugCost[] = 'Free';
                                }else {
                                    $drugCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Specialist Visit') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $specialistCost[] = 'Free';
                                }else {
                                    $specialistCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Emergency Room Services') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $emergencyCost[] = 'Free';
                                }else {
                                    $emergencyCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                }
            }
        }

        return [
            'plan' => $plans,
            'ranges' => $plan,
            'body' => $body,
            'offset' => $offset,
            'benefitsDoctorVisits' => $doctorCost,
            'benefitsDrug' => $drugCost,
            'emergencyCost' => $emergencyCost,
            'specialistCost' => $specialistCost,
            'rating' => $rating
        ];

    }

    public function apiHealthEnroll(Request $request){

        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('US/Eastern'));
        $DateAndTime = $Object->format('Y-m-d H:i:s');

        $modelHealthCare = new InsurancePlans;
        $modelHealthCare->setConnection('mysql2');

        $modelHealthCare2 = new ClientHealth;
        $modelHealthCare2->setConnection('mysql2');

        if(isset($request->client_id)){
            $client = $modelHealthCare2->where('idclient', $request->client_id)->first();
            $seller = $client->owneruser;
            $agent = $client->owner_agent;
            $idclient = $request->client_id;
        }else {
            return redirect()->back()->with('messageError', 'Client not found!');
        }

        if($request->insurance_tier == 'Bronze') {
            $metalLevel = 1;
        }elseif($request->insurance_tier == 'Silver') {
            $metalLevel = 2;
        }elseif($request->insurance_tier == 'Gold') {
            $metalLevel = 3;
        }else {
            $metalLevel = 3;
        }

        $price = str_replace('.','', $request->price);

        $modelHealthCare::create([
            'insurance_name'            => $request->insurance_name,
            'insurance_company'         => $request->insurance_company,
            'insurance_companies_id'    => intval($request->insurance_company),
            'insurance_type'            => 1000,
            'insurance_tier'            => $metalLevel,
            'until_date'                => $Object->format('Y-m-d'),
            'renewed_on'                => $Object->format('Y-m-d'),
            'price'                     => (float)$price,
            'recurrency'                => 'monthly',
            'description'               => $request->description,
            'active'                    => 20,
            'id_client'                 => intval($idclient),
            'auto_renew'                => 0,
            'is_renovation'             => 0,
            'created_at'                => $DateAndTime,
            'updated_at'                => $DateAndTime,
            'start_on'                  => $Object->format('Y-m-d'),
            'seller'                    => $seller,
            'activated_at'              => $Object->format('Y-m-d'),
            'owner_agent'               => null
        ]);

        $url = 'https://admin.2easyinsurance.com/admin/client/' . intval($idclient);

        return Redirect::to($url);

    }

    public function apiHealthCompare(Request $request) {
        //Compare planos

        #region vars
        if(isset($request->children)){
            $childrenArray = $request->children;
        }else {
            $childrenArray = [];
        }

        $plans = null;
        $rating = null;
        $doctorCost = null;
        $drugCost = null;
        $emergencyCost = null;
        $specialistCost = null;
        $xRayCost = null;
        $imagingCost = null;
        $bloodCost = null;
        $preventiveCost = null;

        if($request->year==null) {
            $reqYear = intval(date('Y', strtotime('+1 year')));
        }else {
            $reqYear = intval($request->year);
        }

        foreach($request->planId as $key => $value) {
            $comparePlans[] =
                $value
            ;
        };

        $place = [
            'countyfips' => $request->zipcodeFips,
            'state' => $request->zipcodeState,
            'zipcode' => $request->zipcodeNumber
        ];

        $curlChip = curl_init();

            curl_setopt_array($curlChip, array(
              CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/states/'. $request->zipcodeState .'/medicaid??apikey=$apikey',
              CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                    'Content-Type: text/plain'
                ),
            ));

            $responseChip = curl_exec($curlChip);

            curl_close($curlChip);

            $chip = json_decode($responseChip);

            if(count($chip->chip)==0){
                $maxAgeChip = 18;
            }else {
                $maxAgeChip = $chip->chip[0]->max_age;
            }

        #endregion

        #region SEARCH PLANS

        foreach($request->people as $key => $value) {
            if($value['age'] <= $maxAgeChip) {

                    $hasMec[$key] = true;

            }else{
                $hasMec[$key] = false;
            }
            $peopleEstimate[] = [
                'age' => intval($value['age']),
                'aptc_eligible' => filter_var($value['aptc_eligible'], FILTER_VALIDATE_BOOLEAN),
                'gender' => $value['gender'],
                'has_mec' => $hasMec[$key],
                'uses_tobacco' => filter_var($value['uses_tobacco'], FILTER_VALIDATE_BOOLEAN),
                "utilization_level"=> "Medium"
            ];
        };

        $bodyEstimate = [
            "household" => [
                "income" => intval(str_replace(',', '', $request->income)),
                "people" => $peopleEstimate,
            ],
            "market" => "Individual",
            "place" => $place,
            "year" => $reqYear,
        ];
        $curlEstimate = curl_init();

        curl_setopt_array($curlEstimate, array(
            CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/households/eligibility/estimates?apikey=$apikey&year='. $reqYear,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($bodyEstimate),
            CURLOPT_HTTPHEADER => array(
                'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                'Content-Type: application/json'
            ),
        ));

        $responseEstimate = curl_exec($curlEstimate);

        curl_close($curlEstimate);

        $estimate = json_decode($responseEstimate);
        if(isset($estimate->message)){
            return $estimate->error;
        }
        foreach($estimate->estimates as $key => $value) {
            if($value->is_medicaid_chip==true){
                $chips[] = 1;
            }else {
                $chips[] = 0;
            }
        };

        foreach($request->people as $key => $value) {
            if(in_array(1, $chips)==0 || in_array(0, $chips)==0){

                if(in_array(1, $chips)==0 || in_array(0, $chips)==1){
                    $hasMec[$key] = false;
                }else {
                    if($value['age'] <= $maxAgeChip) {
                        $hasMec[$key] = false;
                    }else{
                        $hasMec[$key] = false;
                    }
                }
            }else {
                if($estimate->estimates[0]->aptc!==0){
                    if($value['age'] <= $maxAgeChip) {
                        $hasMec[$key] = true;
                    }else{
                        $hasMec[$key] = false;
                    }
                }else {
                    if($value['age'] <= $maxAgeChip) {
                        $hasMec[$key] = false;
                    }else{
                        $hasMec[$key] = false;
                    }
                }
            }

            for($i=0; $i<count($childrenArray); $i++){
                if($key == $childrenArray[$i]){
                    $hasMec[$key] = false;
                }
            }
            $people[] = [
                'age' => intval($value['age']),
                'aptc_eligible' => filter_var($value['aptc_eligible'], FILTER_VALIDATE_BOOLEAN),
                'gender' => $value['gender'],
                'has_mec' => $hasMec[$key],
                'uses_tobacco' => filter_var($value['uses_tobacco'], FILTER_VALIDATE_BOOLEAN),
                "utilization_level"=> "Medium"
            ];
        };

        #endregion

        #region Compare PLANS
        $body = [
            "household" => [
                "income" => intval(str_replace(',', '', $request->income)),
                "people" =>
                    $people
                ,
            ],
            "market" => "Individual",
            "place" => $place,
            "plan_ids" =>
                $comparePlans
            ,
            "year" => $reqYear,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/plans?apikey=$apikey&year='. $reqYear,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => array(
                'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                'Content-Type: text/plain'
            ),
        ));
        $response = curl_exec($curl);
        if(curl_errno($curl)) {
            return 'Curl error: '.curl_error($curl);
        }
        curl_close($curl);
        $plan = json_decode($response);
        if(isset($plan->message)){
            return $plan->error;
        }
        $plans = $plan->plans;
        #endregion

        if(count($plans) !== 0) {
            foreach($plan->plans as $key => $value) {
                $benefits[] = $value->benefits;
                $rating[] = $value->quality_rating->global_rating;
                foreach($benefits[$key] as $keys => $values) {
                    if($values->name == 'Primary Care Visit to Treat an Injury or Illness') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $doctorCost[] = 'Free';
                                }else {
                                    $doctorCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Generic Drugs') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $drugCost[] = 'Free';
                                }else {
                                    $drugCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Specialist Visit') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {$a[]= $i;
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $specialistCost[] = 'Free';
                                }else {
                                    $specialistCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Emergency Room Services') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $emergencyCost[] = 'Free';
                                }else {
                                    $emergencyCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'X-rays and Diagnostic Imaging') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $xRayCost[] = 'Free';
                                }else {
                                    $xRayCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Imaging (CT/PET Scans, MRIs)') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $imagingCost[] = 'Free';
                                }else {
                                    $imagingCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Laboratory Outpatient and Professional Services') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $bloodCost[] = 'Free';
                                }else {
                                    $bloodCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Preventive Care/Screening/Immunization') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $preventiveCost[] = 'Free';
                                }else {
                                    $preventiveCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                }
            }
        }

        return [
            'plan' => $plans,
            'ranges' => $plan,
            'body' => $body,
            'benefitsDoctorVisits' => $doctorCost,
            'benefitsDrug' => $drugCost,
            'emergencyCost' => $emergencyCost,
            'specialistCost' => $specialistCost,
            'xRayCost' => $xRayCost,
            'imagingCost' => $imagingCost,
            'bloodCost' => $bloodCost,
            'preventiveCost' => $preventiveCost,
            'rating' => $rating
        ];

    }

    //API NEW -- Modificações para atender vendedores(sem uso no momento)
    public function apiHealthViewNew(){

        session_start();

		$modelHealthCare = new ClientHealth;
        $modelHealthCare->setConnection('mysql2');
        $modelHealthCare2 = new InsurancePlans;
        $modelHealthCare2->setConnection('mysql2');

		$client = $modelHealthCare->where('idclient', request()->client_id)->first();

        return view('front.api.apiHealthSubmitNew', ['client' => $client]);
    }

    public function apiHealthJsonNew(Request $request) {

        if($request->uses_tobacco==1){
            $tobacco = true;
        }else {
            $tobacco = false;
        }

        $people[] =
        [
            "age" => intval($request->age),
            "aptc_eligible" => true,
            "gender" => $request->gender,
            "uses_tobacco" => $tobacco
        ];
        if(isset($request->spouseAge) && isset($request->spouseGender) && isset($request->spouseUseTobacco)){

            $people[] =
            [
                'age' => intval($request->spouseAge[0]),
                'aptc_eligible' => true,
                'gender' => $request->spouseGender[0],
                'uses_tobacco' => filter_var($request->spouseUseTobacco[0], FILTER_VALIDATE_BOOLEAN)
            ];
        }

        if(isset($request->dependentAge) && isset($request->dependentGender) && isset($request->dependentUseTobacco)){
            foreach($request->dependentAge as $key => $value){
            $people[] =
            [
                'age' => intval($request->dependentAge[$key]),
                'aptc_eligible' => true,
                'gender' => $request->dependentGender[$key+1],
                'uses_tobacco' => filter_var($request->dependentUseTobacco[$key+1], FILTER_VALIDATE_BOOLEAN)
            ];}
        }
        $query = urlencode(serialize($people));
        $url = '/apiHealthNew/submit' .
        '?zipcode=' .$request->zipcode .
        '&income=' .$request->income .
        '&people=' .$query;
        return Redirect::to($url);

    }

    public function apiHealthIdNew($id) {

        #region Request
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/plans/'. $id .'?year='. request()->year .'&' .'?apikey={$apikey}',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(unserialize(urldecode(request()->body))),
            CURLOPT_HTTPHEADER => array(
                'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                'Content-Type: text/plain'
            ),
        ));

        $response = curl_exec($curl);

        if(curl_errno($curl)) {
            return 'Curl error: '.curl_error($curl);
        }

        curl_close($curl);

        $plan = json_decode($response);

        if(isset($plan->message)){
            return $plan->error;
        }

        #endregion

        setlocale(LC_MONETARY,"en_US");
        foreach($plan->plan->deductibles as $value) {
            $deductibles[] = $value->amount;
        }

        foreach($plan->plan->benefits as $key => $value) {
            #region Doctor visit
            if($value->name == 'Primary Care Visit to Treat an Injury or Illness') {
                $doctorCostAfter = null;
                $doctorCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $doctorCostAfter = 'Free';
                                $doctorCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $doctorCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $doctorCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $doctorCostAfter = 'Full Price';
                                    $doctorCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $doctorCostAfter = 'Full Price';
                                    $doctorCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $doctorCostAfter = 'Full Price';
                                    $doctorCostBefore = 'Free';
                                }
                            }else {
                                $doctorCostAfter = $value->cost_sharings[$i]->display_string;
                                $doctorCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $doctorCostAfter = 'Not Covered';
                            $doctorCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Specialist Visit') {
                $specialistCostAfter = null;
                $specialistCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $specialistCostAfter = 'Free';
                                $specialistCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $specialistCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $specialistCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $specialistCostAfter = 'Full Price';
                                    $specialistCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $specialistCostAfter = 'Full Price';
                                    $specialistCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $specialistCostAfter = 'Full Price';
                                    $specialistCostBefore = 'Free';
                                }
                            }else {
                                $specialistCostAfter = $value->cost_sharings[$i]->display_string;
                                $specialistCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $specialistCostAfter = 'Not Covered';
                            $specialistCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Preventive Care/Screening/Immunization') {
                $preventiveCostAfter = null;
                $preventiveCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $preventiveCostAfter = 'Free';
                                $preventiveCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $preventiveCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $preventiveCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $preventiveCostAfter = 'Full Price';
                                    $preventiveCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $preventiveCostAfter = 'Full Price';
                                    $preventiveCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $preventiveCostAfter = 'Full Price';
                                    $preventiveCostBefore = 'Free';
                                }
                            }else {
                                $preventiveCostAfter = $value->cost_sharings[$i]->display_string;
                                $preventiveCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $preventiveCostAfter = 'Not Covered';
                            $preventiveCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            #endregion

            #region Drugs
            if($value->name == 'Generic Drugs') {
                $drugCostAfter = null;
                $drugCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $drugCostAfter = 'Free';
                                $drugCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $drugCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $drugCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $drugCostAfter = 'Full Price';
                                    $drugCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $drugCostAfter = 'Full Price';
                                    $drugCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $drugCostAfter = 'Full Price';
                                    $drugCostBefore = 'Free';
                                }
                            }else {
                                $drugCostAfter = $value->cost_sharings[$i]->display_string;
                                $drugCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $drugCostAfter = 'Not Covered';
                            $drugCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Preferred Brand Drugs') {
                $brandDrugCostAfter = null;
                $brandDrugCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $brandDrugCostAfter = 'Free';
                                $brandDrugCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $brandDrugCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $brandDrugCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $brandDrugCostAfter = 'Full Price';
                                    $brandDrugCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $brandDrugCostAfter = 'Full Price';
                                    $brandDrugCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $brandDrugCostAfter = 'Full Price';
                                    $brandDrugCostBefore = 'Free';
                                }
                            }else {
                                $brandDrugCostAfter = $value->cost_sharings[$i]->display_string;
                                $brandDrugCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $brandDrugCostAfter = 'Not Covered';
                            $brandDrugCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Non-Preferred Brand Drugs') {
                $nonBrandDrugCostAfter = null;
                $nonBrandDrugCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $nonBrandDrugCostAfter = 'Free';
                                $nonBrandDrugCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $nonBrandDrugCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $nonBrandDrugCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $nonBrandDrugCostAfter = 'Full Price';
                                    $nonBrandDrugCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $nonBrandDrugCostAfter = 'Full Price';
                                    $nonBrandDrugCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $nonBrandDrugCostAfter = 'Full Price';
                                    $nonBrandDrugCostBefore = 'Free';
                                }
                            }else {
                                $nonBrandDrugCostAfter = $value->cost_sharings[$i]->display_string;
                                $nonBrandDrugCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $nonBrandDrugCostAfter = 'Not Covered';
                            $nonBrandDrugCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Specialty Drugs') {
                $specialtyDrugCostAfter = null;
                $specialtyDrugCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $specialtyDrugCostAfter = 'Free';
                                $specialtyDrugCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $specialtyDrugCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $specialtyDrugCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $specialtyDrugCostAfter = 'Full Price';
                                    $specialtyDrugCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $specialtyDrugCostAfter = 'Full Price';
                                    $specialtyDrugCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $specialtyDrugCostAfter = 'Full Price';
                                    $specialtyDrugCostBefore = 'Free';
                                }
                            }else {
                                $specialtyDrugCostAfter = $value->cost_sharings[$i]->display_string;
                                $specialtyDrugCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $specialtyDrugCostAfter = 'Not Covered';
                            $specialtyDrugCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            #endregion

            #region Labs
            if($value->name == 'X-rays and Diagnostic Imaging') {
                $xRayCostAfter = null;
                $xRayCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $xRayCostAfter = 'Free';
                                $xRayCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $xRayCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $xRayCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $xRayCostAfter = 'Full Price';
                                    $xRayCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $xRayCostAfter = 'Full Price';
                                    $xRayCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $xRayCostAfter = 'Full Price';
                                    $xRayCostBefore = 'Free';
                                }
                            }else {
                                $xRayCostAfter = $value->cost_sharings[$i]->display_string;
                                $xRayCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $xRayCostAfter = 'Not Covered';
                            $xRayCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Imaging (CT/PET Scans, MRIs)') {
                $imagingCostAfter = null;
                $imagingCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $imagingCostAfter = 'Free';
                                $imagingCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $imagingCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $imagingCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $imagingCostAfter = 'Full Price';
                                    $imagingCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $imagingCostAfter = 'Full Price';
                                    $imagingCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $imagingCostAfter = 'Full Price';
                                    $imagingCostBefore = 'Free';
                                }
                            }else {
                                $imagingCostAfter = $value->cost_sharings[$i]->display_string;
                                $imagingCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $imagingCostAfter = 'Not Covered';
                            $imagingCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Laboratory Outpatient and Professional Services') {
                $bloodCostAfter = null;
                $bloodCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $bloodCostAfter = 'Free';
                                $bloodCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $bloodCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $bloodCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $bloodCostAfter = 'Full Price';
                                    $bloodCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $bloodCostAfter = 'Full Price';
                                    $bloodCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $bloodCostAfter = 'Full Price';
                                    $bloodCostBefore = 'Free';
                                }
                            }else {
                                $bloodCostAfter = $value->cost_sharings[$i]->display_string;
                                $bloodCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $bloodCostAfter = 'Not Covered';
                            $bloodCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }

            #endregion

            #region Emergency

            if($value->name == 'Emergency Room Services') {
                $emergencyCostAfter = null;
                $emergencyCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $emergencyCostAfter = 'Free';
                                $emergencyCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $emergencyCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $emergencyCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $emergencyCostAfter = 'Full Price';
                                    $emergencyCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $emergencyCostAfter = 'Full Price';
                                    $emergencyCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $emergencyCostAfter = 'Full Price';
                                    $emergencyCostBefore = 'Free';
                                }
                            }else {
                                $emergencyCostAfter = $value->cost_sharings[$i]->display_string;
                                $emergencyCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $emergencyCostAfter = 'Not Covered';
                            $emergencyCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Outpatient Facility Fee (e.g., Ambulatory Surgery Center)') {
                $outpatientFacilityCostAfter = null;
                $outpatientFacilityCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $outpatientFacilityCostAfter = 'Free';
                                $outpatientFacilityCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $outpatientFacilityCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $outpatientFacilityCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $outpatientFacilityCostAfter = 'Full Price';
                                    $outpatientFacilityCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $outpatientFacilityCostAfter = 'Full Price';
                                    $outpatientFacilityCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $outpatientFacilityCostAfter = 'Full Price';
                                    $outpatientFacilityCostBefore = 'Free';
                                }
                            }else {
                                $outpatientFacilityCostAfter = $value->cost_sharings[$i]->display_string;
                                $outpatientFacilityCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $outpatientFacilityCostAfter = 'Not Covered';
                            $outpatientFacilityCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Outpatient Surgery Physician/Surgical Services') {
                $outpatientPhysicianCostAfter = null;
                $outpatientPhysicianCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $outpatientPhysicianCostAfter = 'Free';
                                $outpatientPhysicianCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $outpatientPhysicianCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $outpatientPhysicianCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $outpatientPhysicianCostAfter = 'Full Price';
                                    $outpatientPhysicianCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $outpatientPhysicianCostAfter = 'Full Price';
                                    $outpatientPhysicianCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $outpatientPhysicianCostAfter = 'Full Price';
                                    $outpatientPhysicianCostBefore = 'Free';
                                }
                            }else {
                                $outpatientPhysicianCostAfter = $value->cost_sharings[$i]->display_string;
                                $outpatientPhysicianCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $outpatientPhysicianCostAfter = 'Not Covered';
                            $outpatientPhysicianCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Emergency Transportation/Ambulance') {
                $ambulanceCostAfter = null;
                $ambulanceCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $ambulanceCostAfter = 'Free';
                                $ambulanceCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $ambulanceCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $ambulanceCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $ambulanceCostAfter = 'Full Price';
                                    $ambulanceCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $ambulanceCostAfter = 'Full Price';
                                    $ambulanceCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $ambulanceCostAfter = 'Full Price';
                                    $ambulanceCostBefore = 'Free';
                                }
                            }else {
                                $ambulanceCostAfter = $value->cost_sharings[$i]->display_string;
                                $ambulanceCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $ambulanceCostAfter = 'Not Covered';
                            $ambulanceCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Outpatient Rehabilitation Services') {
                $rehabilitationCostAfter = null;
                $rehabilitationCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $rehabilitationCostAfter = 'Free';
                                $rehabilitationCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $rehabilitationCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $rehabilitationCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $rehabilitationCostAfter = 'Full Price';
                                    $rehabilitationCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $rehabilitationCostAfter = 'Full Price';
                                    $rehabilitationCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $rehabilitationCostAfter = 'Full Price';
                                    $rehabilitationCostBefore = 'Free';
                                }
                            }else {
                                $rehabilitationCostAfter = $value->cost_sharings[$i]->display_string;
                                $rehabilitationCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $rehabilitationCostAfter = 'Not Covered';
                            $rehabilitationCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Inpatient Hospital Services (e.g., Hospital Stay)') {
                $hospitalFacilityCostAfter = null;
                $hospitalFacilityCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $hospitalFacilityCostAfter = 'Free';
                                $hospitalFacilityCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $hospitalFacilityCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $hospitalFacilityCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $hospitalFacilityCostAfter = 'Full Price';
                                    $hospitalFacilityCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $hospitalFacilityCostAfter = 'Full Price';
                                    $hospitalFacilityCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $hospitalFacilityCostAfter = 'Full Price';
                                    $hospitalFacilityCostBefore = 'Free';
                                }
                            }else {
                                $hospitalFacilityCostAfter = $value->cost_sharings[$i]->display_string;
                                $hospitalFacilityCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $hospitalFacilityCostAfter = 'Not Covered';
                            $hospitalFacilityCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }
            if($value->name == 'Inpatient Physician and Surgical Services') {
                $hospitalPhysicianCostAfter = null;
                $hospitalPhysicianCostBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $hospitalPhysicianCostAfter = 'Free';
                                $hospitalPhysicianCostBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $hospitalPhysicianCostAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $hospitalPhysicianCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $hospitalPhysicianCostAfter = 'Full Price';
                                    $hospitalPhysicianCostBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $hospitalPhysicianCostAfter = 'Full Price';
                                    $hospitalPhysicianCostBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $hospitalPhysicianCostAfter = 'Full Price';
                                    $hospitalPhysicianCostBefore = 'Free';
                                }
                            }else {
                                $hospitalPhysicianCostAfter = $value->cost_sharings[$i]->display_string;
                                $hospitalPhysicianCostBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $hospitalPhysicianCostAfter = 'Not Covered';
                            $hospitalPhysicianCostBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }

            #endregion

            #region Mental
            if($value->name == 'Mental/Behavioral Health Outpatient Services') {
                $mentalOutpatientAfter = null;
                $mentalOutpatientBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $mentalOutpatientAfter = 'Free';
                                $mentalOutpatientBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $mentalOutpatientAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $mentalOutpatientBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $mentalOutpatientAfter = 'Full Price';
                                    $mentalOutpatientBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $mentalOutpatientAfter = 'Full Price';
                                    $mentalOutpatientBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $mentalOutpatientAfter = 'Full Price';
                                    $mentalOutpatientBefore = 'Free';
                                }
                            }else {
                                $mentalOutpatientAfter = $value->cost_sharings[$i]->display_string;
                                $mentalOutpatientBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $mentalOutpatientAfter = 'Not Covered';
                            $mentalOutpatientBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }

            if($value->name == 'Mental/Behavioral Health Inpatient Services') {
                $mentalInpatientAfter = null;
                $mentalInpatientBefore = null;
                for ($i = 0; $i < count($value->cost_sharings); $i++) {
                    if ($value->cost_sharings[$i]->network_tier == 'In-Network') {
                        if($value->covered == true) {
                            if($value->cost_sharings[$i]->display_string  == 'No Charge') {
                                $mentalInpatientAfter = 'Free';
                                $mentalInpatientBefore = 'Free';
                            }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'after deductible')) {
                                if(str_contains($value->cost_sharings[$i]->display_string, '$') && str_contains($value->cost_sharings[$i]->display_string, '%')){
                                    $mentalInpatientAfter = '$'.$value->cost_sharings[$i]->copay_amount;
                                    $mentalInpatientBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '$')){
                                    $mentalInpatientAfter = 'Full Price';
                                    $mentalInpatientBefore = '$'.$value->cost_sharings[$i]->copay_amount;
                                }else if(str_contains($value->cost_sharings[$i]->display_string, '%')) {
                                    $mentalInpatientAfter = 'Full Price';
                                    $mentalInpatientBefore = ($value->cost_sharings[$i]->coinsurance_rate*100).'%';
                                }else if(str_contains(strtolower($value->cost_sharings[$i]->display_string), 'no charge')) {
                                    $mentalInpatientAfter = 'Full Price';
                                    $mentalInpatientBefore = 'Free';
                                }
                            }else {
                                $mentalInpatientAfter = $value->cost_sharings[$i]->display_string;
                                $mentalInpatientBefore = $value->cost_sharings[$i]->display_string;
                            }
                        }else {
                            $mentalInpatientAfter = 'Not Covered';
                            $mentalInpatientBefore = 'Not Covered';
                        }
                        break;
                    }
                }
            }

            #endregion

        }

        return view('front.api.apiHealthIdNew', [
            'plan' => $plan->plan,
            'deductibles' => $deductibles[0],
            'doctorCostAfter' => $doctorCostAfter,
            'doctorCostBefore' => $doctorCostBefore,
            'drugCostAfter' => $drugCostAfter,
            'drugCostBefore' => $drugCostBefore,
            'brandDrugCostAfter' => $brandDrugCostAfter,
            'brandDrugCostBefore' => $brandDrugCostBefore,
            'nonBrandDrugCostAfter' => $nonBrandDrugCostAfter,
            'nonBrandDrugCostBefore' => $nonBrandDrugCostBefore,
            'specialtyDrugCostAfter' => $specialtyDrugCostAfter,
            'specialtyDrugCostBefore' => $specialtyDrugCostBefore,
            'specialistCostAfter' => $specialistCostAfter,
            'specialistCostBefore' => $specialistCostBefore,
            'xRayCostAfter' => $xRayCostAfter,
            'xRayCostBefore' => $xRayCostBefore,
            'imagingCostAfter' => $imagingCostAfter,
            'imagingCostBefore' => $imagingCostBefore,
            'bloodCostAfter' => $bloodCostAfter,
            'bloodCostBefore' => $bloodCostBefore,
            'emergencyCostAfter' => $emergencyCostAfter,
            'emergencyCostBefore' => $emergencyCostBefore,
            'outpatientFacilityCostAfter' => $outpatientFacilityCostAfter,
            'outpatientFacilityCostBefore' => $outpatientFacilityCostBefore,
            'outpatientPhysicianCostAfter' => $outpatientPhysicianCostAfter,
            'outpatientPhysicianCostBefore' => $outpatientPhysicianCostBefore,
            'ambulanceCostAfter' => $ambulanceCostAfter,
            'ambulanceCostBefore' => $ambulanceCostBefore,
            'rehabilitationCostAfter' => $rehabilitationCostAfter,
            'rehabilitationCostBefore' => $rehabilitationCostBefore,
            'hospitalFacilityCostAfter' => $hospitalFacilityCostAfter,
            'hospitalFacilityCostBefore' => $hospitalFacilityCostBefore,
            'hospitalPhysicianCostAfter' => $hospitalPhysicianCostAfter,
            'hospitalPhysicianCostBefore' => $hospitalPhysicianCostBefore,
            'preventiveCostAfter' => $preventiveCostAfter,
            'preventiveCostBefore' => $preventiveCostBefore,
            'mentalOutpatientAfter' => $mentalOutpatientAfter,
            'mentalOutpatientBefore' => $mentalOutpatientBefore,
            'mentalInpatientAfter' => $mentalInpatientAfter,
            'mentalInpatientBefore' => $mentalInpatientBefore,
            'response' => $response
        ]);

    }

    public function apiHealthRequestNew(Request $request) {

        if(isset($request->children)){
            $childrenArray = $request->children;
        }else {
            $childrenArray = [];
        }

        $children = [];
        $adult = [];
        $bodyAffordability = [];
        $peopleAffordability = [];
        $affordability = null;
        $benefitsDrugLowest = null;
        $benefitsDoctorVisitsLowest = null;
        $benefitsDrugAffordable = null;
        $mostAffordable = null;
        $benefitsDoctorVisitsAffordable = null;
        $lowestPremium = null;
        $specialistCostAffordable = null;
        $specialistCostLowest = null;

        $place = [
            'countyfips' => $request->zipcodeFips,
            'state' => $request->zipcodeState,
            'zipcode' => $request->zipcodeNumber
        ];

            $curlChip = curl_init();

            curl_setopt_array($curlChip, array(
              CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/states/'. $request->zipcodeState .'/medicaid??apikey=$apikey',
              CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                    'Content-Type: text/plain'
                ),
            ));

            $responseChip = curl_exec($curlChip);

            curl_close($curlChip);

            $chip = json_decode($responseChip);

            if(isset($chip->message)){
                return $chip->error;
            }

            if(count($chip->chip)==0){
                $maxAgeChip = 18;
            }else {
                $maxAgeChip = $chip->chip[0]->max_age;
            }


        #region SEARCH PLANS
        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('US/Eastern'));
        $DateAndTime = $Object->format('Y');

        foreach($request->people as $key => $value) {
            if($value['age'] <= $maxAgeChip) {

                    $hasMec[$key] = true;

            }else{
                $hasMec[$key] = false;
            }
            $peopleEstimate[] = [
                'age' => intval($value['age']),
                'aptc_eligible' => filter_var($value['aptc_eligible'], FILTER_VALIDATE_BOOLEAN),
                'gender' => $value['gender'],
                'has_mec' => $hasMec[$key],
                'uses_tobacco' => filter_var($value['uses_tobacco'], FILTER_VALIDATE_BOOLEAN),
                "utilization_level"=> "Medium"
            ];
        };

        if(isset($request->offset)) {
            $offset = intval($request->offset);
        }else {
            $offset = 0;
        }

        if($request->issuers==null || $request->issuers==[null] || $request->issuers==[]) {
            $issuers = [];
        }else {
            $issuers = $request->issuers;
        }

        if($request->metal_level==null || $request->metal_level==[null] || $request->metal_level==[]) {
            $metalLevels = [];
        }else {
            $metalLevels = $request->metal_level;
        }

        if($request->deductible==null) {
            $reqDeductible = null;
        }else {
            $reqDeductible = intval($request->deductible);
        }

        if($request->year==null) {
            $reqYear = $DateAndTime;
        }else {
            $reqYear = intval($request->year);
        }


        #region ESTIMATE SUBSIDY
        $bodyEstimate = [
            "household" => [
                "income" => intval(str_replace(',', '', $request->income)),
                "people" => $peopleEstimate,
            ],
            "market" => "Individual",
            "place" => $place,
            "year" => $reqYear,
        ];
        $curlEstimate = curl_init();

        curl_setopt_array($curlEstimate, array(
            CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/households/eligibility/estimates?apikey=$apikey&year='. $reqYear,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($bodyEstimate),
            CURLOPT_HTTPHEADER => array(
                'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                'Content-Type: application/json'
            ),
        ));

        $responseEstimate = curl_exec($curlEstimate);

        curl_close($curlEstimate);

        $estimate = json_decode($responseEstimate);

        if(isset($estimate->message)){
            return $estimate->error;
        }

        $estimateSub = $estimate->estimates[0]->aptc;

        foreach($estimate->estimates as $key => $value) {
            if($value->is_medicaid_chip==true){
                $chips[] = 1;
            }else {
                $chips[] = 0;
            }
        };

        foreach($request->people as $key => $value) {

            if(in_array(1, $chips)==0 || in_array(0, $chips)==0){

                if(in_array(1, $chips)==0 || in_array(0, $chips)==1){
                    $hasMec[$key] = false;
                    $hasMecAffordability[$key] = true;
                    $peopleEstimate2[] = [
                        'age' => intval($value['age']),
                        'aptc_eligible' => filter_var($value['aptc_eligible'], FILTER_VALIDATE_BOOLEAN),
                        'gender' => $value['gender'],
                        'has_mec' => $hasMec[$key],
                        'uses_tobacco' => filter_var($value['uses_tobacco'], FILTER_VALIDATE_BOOLEAN),
                        "utilization_level"=> "Medium"
                    ];
                    $bodyEstimate = [
                        "household" => [
                            "income" => intval(str_replace(',', '', $request->income)),
                            "people" => $peopleEstimate2,
                        ],
                        "market" => "Individual",
                        "place" => $place,
                        "year" => $reqYear,
                    ];
                    $curlEstimate = curl_init();

                    curl_setopt_array($curlEstimate, array(
                        CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/households/eligibility/estimates?apikey=$apikey&year='. $reqYear,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => json_encode($bodyEstimate),
                        CURLOPT_HTTPHEADER => array(
                            'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                            'Content-Type: application/json'
                        ),
                    ));

                    $responseEstimate = curl_exec($curlEstimate);

                    curl_close($curlEstimate);

                    $estimate = json_decode($responseEstimate);

                    $estimateSub = $estimate->estimates[0]->aptc;
                }else {
                    if($value['age'] <= $maxAgeChip) {
                        $hasMec[$key] = false;
                        $hasMecAffordability[$key] = true;
                    }else{
                        $hasMec[$key] = false;
                        $hasMecAffordability[$key] = true;
                    }
                    $adult[] = [
                        'index' => $key,
                        'gender' => $value['gender'],
                        'age' => $value['age']
                    ];
                }

            }else {
                if($estimateSub!==0){
                    if($value['age'] <= $maxAgeChip) {
                        $hasMec[$key] = true;
                        $hasMecAffordability[$key] = true;
                        $children[] = [
                            'index' => $key,
                            'gender' => $value['gender'],
                            'age' => $value['age']
                        ];
                    }else{
                        $hasMec[$key] = false;
                        $hasMecAffordability[$key] = false;
                        $adult[] = [
                            'index' => $key,
                            'gender' => $value['gender'],
                            'age' => $value['age']
                        ];
                    }
                }else {
                    if($value['age'] <= $maxAgeChip) {
                        $hasMec[$key] = false;
                        $hasMecAffordability[$key] = true;
                    }else{
                        $hasMec[$key] = false;
                        $hasMecAffordability[$key] = true;
                    }
                    $adult[] = [
                        'index' => $key,
                        'gender' => $value['gender'],
                        'age' => $value['age']
                    ];
                }
            }

            for($i=0; $i<count($childrenArray); $i++){
                if($key == $childrenArray[$i]){
                    $hasMec[$key] = false;
                    $hasMecAffordability[$key] = false;
                }
            }
            $people[] = [
                'age' => intval($value['age']),
                'aptc_eligible' => filter_var($value['aptc_eligible'], FILTER_VALIDATE_BOOLEAN),
                'gender' => $value['gender'],
                'has_mec' => $hasMec[$key],
                'uses_tobacco' => filter_var($value['uses_tobacco'], FILTER_VALIDATE_BOOLEAN),
                "utilization_level"=> "Medium"
            ];
            $peopleAffordability[] = [
                'age' => intval($value['age']),
                'aptc_eligible' => filter_var($value['aptc_eligible'], FILTER_VALIDATE_BOOLEAN),
                'gender' => $value['gender'],
                'has_mec' => $hasMecAffordability[$key],
                'uses_tobacco' => filter_var($value['uses_tobacco'], FILTER_VALIDATE_BOOLEAN),
                "utilization_level"=> "Medium"
            ];
        };

            if(count($childrenArray)!==0) {
                foreach($request->people as $key => $value) {
                    if($estimateSub!==0) {
                        if(in_array(1, $chips)!==0 || in_array(0, $chips)!==0){
                            $bodyAffordability = [
                                "household" => [
                                    "people" => $peopleAffordability,
                                ],
                                "market" => "Individual",
                                "place" => $place,
                                "year" => $reqYear,
                            ];
                            $curlAffordability = curl_init();

                            curl_setopt_array($curlAffordability, array(
                                CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/households/slcsp?apikey=$apikey&year=2024',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($bodyAffordability),
                                CURLOPT_HTTPHEADER => array(
                                    'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                                    'Content-Type: application/json'
                                ),
                            ));

                            $responseAffordability = curl_exec($curlAffordability);

                            curl_close($curlAffordability);

                            $affordability = json_decode($responseAffordability);

                            if(isset($affordability->message)){
                                return $affordability->error;
                            }

                            $estimateSub = ceil($affordability->premium);
                            break;
                        }
                    }
                }

            }


        #endregion



        #endregion

        #region Most Affordable
        $bodyAffordable = [

            "household" => [
                "income" => intval(str_replace(',', '', $request->income)),
                "people" =>
                    $people
                ,
            ],
            "market" => "Individual",
            "place" => $place,
            "sort"=>
                   "total_costs"
                ,
            "limit" => 10,
            "offset" => $offset,
            "year" => $reqYear,
        ];
        $curlAffordable = curl_init();

        curl_setopt_array($curlAffordable, array(
            CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/plans/search?apikey=$apikey',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($bodyAffordable),
            CURLOPT_HTTPHEADER => array(
                'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                'Content-Type: text/plain'
            ),
        ));
        $responseAffordable = curl_exec($curlAffordable);
        if(curl_errno($curlAffordable)) {
            return 'Curl error: '.curl_error($curlAffordable);
        }
        curl_close($curlAffordable);
        $affordable = json_decode($responseAffordable);

        if(isset($affordable->message)){
            return $affordable->error;
        }

        $mostAffordable = $affordable->plans[0];



        #endregion

        if($request->premium==null) {
            $reqPremium = null;
        }else if($affordable->ranges->premiums->min > $request->premium) {
            $reqPremium = ($affordable->ranges->premiums->min * 1.2);
        }else {
            $reqPremium = (floatval($request->premium) * 1.2);
        }


        #region ALL PLANS



        $body = [
            "filter" => [
                "issuers" =>

                    $issuers

                ,
                "metal_levels" =>

                    $metalLevels

                ,
                "deductible" => $reqDeductible,
                "premium" => $reqPremium
            ],
            "household" => [
                "income" => intval(str_replace(',', '', $request->income)),
                "people" =>
                    $people
                ,
            ],
            "market" => "Individual",
            "place" => $place,
            "sort"=> "premium",
            "limit" => 10,
            "offset" => $offset,
            "year" => $reqYear,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/plans/search?apikey=$apikey',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => array(
                'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                'Content-Type: text/plain'
            ),
        ));
        $response = curl_exec($curl);
        if(curl_errno($curl)) {
            return 'Curl error: '.curl_error($curl);
        }
        curl_close($curl);
        $plan = json_decode($response);
        if(isset($plan->message)){
            return $plan->error;
        }
        $plans = $plan->plans;

        if(count($plans)==0) {
            $reqPremium = null;
            $body = [
                "filter" => [
                    "issuers" =>

                        $issuers

                    ,
                    "metal_levels" =>

                        $metalLevels

                    ,
                    "deductible" => $reqDeductible,
                    "premium" => $reqPremium
                ],
                "household" => [
                    "income" => intval(str_replace(',', '', $request->income)),
                    "people" =>
                        $people
                    ,
                ],
                "market" => "Individual",
                "place" => $place,
                "sort"=> "premium",
                "limit" => 10,
                "offset" => $offset,
                "year" => $reqYear,
            ];

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/plans/search?apikey=$apikey',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($body),
                CURLOPT_HTTPHEADER => array(
                    'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                    'Content-Type: text/plain'
                ),
            ));
            $response = curl_exec($curl);
            if(curl_errno($curl)) {
                return 'Curl error: '.curl_error($curl);
            }
            curl_close($curl);
            $plan = json_decode($response);
            if(isset($plan->message)){
                return $plan->error;
            }
            $plans = $plan->plans;
        }
        if(count($plans)==0) {
            $reqPremium = null;
            $reqDeductible = null;
            $body = [
                "filter" => [
                    "issuers" =>

                        $issuers

                    ,
                    "metal_levels" =>

                        $metalLevels

                    ,
                    "deductible" => $reqDeductible,
                    "premium" => $reqPremium
                ],
                "household" => [
                    "income" => intval(str_replace(',', '', $request->income)),
                    "people" =>
                        $people
                    ,
                ],
                "market" => "Individual",
                "place" => $place,
                "sort"=> "premium",
                "limit" => 10,
                "offset" => $offset,
                "year" => $reqYear,
            ];

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/plans/search?apikey=$apikey',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($body),
                CURLOPT_HTTPHEADER => array(
                    'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                    'Content-Type: text/plain'
                ),
            ));
            $response = curl_exec($curl);
            if(curl_errno($curl)) {
                return 'Curl error: '.curl_error($curl);
            }
            curl_close($curl);
            $plan = json_decode($response);
            if(isset($plan->message)){
                return $plan->error;
            }
            $plans = $plan->plans;
        }

        #endregion

        #region Lowest Premium
        if(count($plans) !== 0){

            $lowestPremium = $plan->plans[0];

            foreach($lowestPremium->benefits as $keys => $values) {
                if($values->name == 'Primary Care Visit to Treat an Injury or Illness') {
                    for ($i = 0; $i < count($values->cost_sharings); $i++) {
                        if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                            if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                $benefitsDoctorVisitsLowest = 'Free';
                            }else {
                                $benefitsDoctorVisitsLowest = $values->cost_sharings[$i]->display_string;
                            }
                            break;
                        }
                    }
                }

                if($values->name == 'Generic Drugs') {
                    for ($i = 0; $i < count($values->cost_sharings); $i++) {
                        if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                            if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                $benefitsDrugLowest = 'Free';
                            }else {
                                $benefitsDrugLowest = $values->cost_sharings[$i]->display_string;
                            }
                            break;
                        }
                    }
                }

                if($values->name == 'Specialist Visit') {
                    for ($i = 0; $i < count($values->cost_sharings); $i++) {$a[]= $i;
                        if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                            if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                $specialistCostLowest = 'Free';
                            }else {
                                $specialistCostLowest = $values->cost_sharings[$i]->display_string;
                            }
                            break;
                        }
                    }
                }
            }
        }else {
            $lowestPremium = null;
            $benefitsDrugLowest = null;
            $benefitsDoctorVisitsLowest = null;
        }

        #endregion


        if(count($plans) !== 0){

            foreach($mostAffordable->benefits as $keys => $values) {
                if($values->name == 'Primary Care Visit to Treat an Injury or Illness') {
                    for ($i = 0; $i < count($values->cost_sharings); $i++) {
                        if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                            if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                $benefitsDoctorVisitsAffordable = 'Free';
                            }else {
                                $benefitsDoctorVisitsAffordable = $values->cost_sharings[$i]->display_string;
                            }
                            break;
                        }
                    }
                }

                if($values->name == 'Generic Drugs') {
                    for ($i = 0; $i < count($values->cost_sharings); $i++) {
                        if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                            if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                $benefitsDrugAffordable = 'Free';
                            }else {
                                $benefitsDrugAffordable = $values->cost_sharings[$i]->display_string;
                            }
                            break;
                        }
                    }
                }

                if($values->name == 'Specialist Visit') {
                    for ($i = 0; $i < count($values->cost_sharings); $i++) {$a[]= $i;
                        if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                            if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                $specialistCostAffordable = 'Free';
                            }else {
                                $specialistCostAffordable = $values->cost_sharings[$i]->display_string;
                            }
                            break;
                        }
                    }
                }
            }
        }else {
            $mostAffordable = null;
            $benefitsDrugAffordable = null;
            $benefitsDoctorVisitsAffordable = null;
            $specialistCostAffordable = null;
            $specialistCostLowest = null;
        }

        if(count($plans) == 0) {
            $plans = null;
            $rating = null;
            $doctorCost = null;
            $drugCost = null;
            $emergencyCost = null;
            $specialistCost = null;
        }else {
            foreach($plan->plans as $key => $value) {
                $benefits[] = $value->benefits;
                $rating[] = $value->quality_rating->global_rating;
                foreach($benefits[$key] as $keys => $values) {
                    if($values->name == 'Primary Care Visit to Treat an Injury or Illness') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $doctorCost[] = 'Free';
                                }else {
                                    $doctorCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Generic Drugs') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $drugCost[] = 'Free';
                                }else {
                                    $drugCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Specialist Visit') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $specialistCost[] = 'Free';
                                }else {
                                    $specialistCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Emergency Room Services') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $emergencyCost[] = 'Free';
                                }else {
                                    $emergencyCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                }
            }
        }

        foreach ($affordable->facet_groups as $key => $value) {
            if($value->name == 'metalLevels') {
                $levels = $value->facets;
            }
            if($value->name == 'issuers') {
                $issuer = $value->facets;
            }
        }

        $query = urlencode(serialize($bodyAffordable));

        return [
            'plan' => $plans,
            'filter' => $affordable,
            'affordability' => $affordability,
            'body' => $body,
            'ranges' => $plan,
            'people' => $people,
            'query' => $query,
            'estimate' => $estimate,
            'estimateSub' => $estimateSub,
            'offset' => $offset,
            'mostAffordable' => $mostAffordable,
            'benefitsDoctorVisitsAffordable' => $benefitsDoctorVisitsAffordable,
            'benefitsDrugAffordable' => $benefitsDrugAffordable,
            'specialistCostAffordable' => $specialistCostAffordable,
            'lowestPremium' => $lowestPremium,
            'benefitsDoctorVisitsLowest' => $benefitsDoctorVisitsLowest,
            'benefitsDrugLowest' => $benefitsDrugLowest,
            'specialistCostLowest' => $specialistCostLowest,
            'benefitsDoctorVisits' => $doctorCost,
            'benefitsDrug' => $drugCost,
            'emergencyCost' => $emergencyCost,
            'specialistCost' => $specialistCost,
            'children' => $children,
            'adult' => $adult,
            'hasMec' => $hasMec,
            'rating' => $rating,
            'issuers' => $issuer,
            'levels' => $levels
        ];

    }

    public function apiHealthSearchNew(Request $request) {

        if(isset($request->children)){
            $childrenArray = $request->children;
        }else {
            $childrenArray = [];
        }

        $plans = null;
        $rating = null;
        $doctorCost = null;
        $drugCost = null;
        $emergencyCost = null;
        $specialistCost = null;

        $place = [
            'countyfips' => $request->zipcodeFips,
            'state' => $request->zipcodeState,
            'zipcode' => $request->zipcodeNumber
        ];

        $curlChip = curl_init();

            curl_setopt_array($curlChip, array(
              CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/states/'. $request->zipcodeState .'/medicaid??apikey=$apikey',
              CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                    'Content-Type: text/plain'
                ),
            ));

            $responseChip = curl_exec($curlChip);

            curl_close($curlChip);

            $chip = json_decode($responseChip);

            if(isset($chip->message)){
                return $chip->error;
            }

            if(count($chip->chip)==0){
                $maxAgeChip = 18;
            }else {
                $maxAgeChip = $chip->chip[0]->max_age;
            }

        if(isset($request->offset)) {
            $offset = intval($request->offset);
        }else {
            $offset = 0;
        }

        if($request->issuers==null) {
            $issuers = [];
        }else {
            $issuers = $request->issuers;
        }

        if($request->metal_level==null) {
            $metalLevels = [];
        }else {
            $metalLevels = $request->metal_level;
        }

        if($request->deductible==null) {
            $reqDeductible = null;
        }else {
            $reqDeductible = intval($request->deductible);
        }

        if($request->premium==null) {
            $reqPremium = null;
        }else if($request->premiumsMin > $request->premium) {
            $reqPremium = ($request->premiumsMin * 1.2);
        }else {
            $reqPremium = (floatval($request->premium) * 1.2);
        }

        if($request->year==null) {
            $reqYear = 2022;
        }else {
            $reqYear = intval($request->year);
        }


        #region SEARCH PLANS
        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('US/Eastern'));
        $DateAndTime = $Object->format('Y');

        foreach($request->people as $key => $value) {
            if($value['age'] <= $maxAgeChip) {

                    $hasMec[$key] = true;

            }else{
                $hasMec[$key] = false;
            }
            $peopleEstimate[] = [
                'age' => intval($value['age']),
                'aptc_eligible' => filter_var($value['aptc_eligible'], FILTER_VALIDATE_BOOLEAN),
                'gender' => $value['gender'],
                'has_mec' => $hasMec[$key],
                'uses_tobacco' => filter_var($value['uses_tobacco'], FILTER_VALIDATE_BOOLEAN),
                "utilization_level"=> "Medium"
            ];
        };

        $bodyEstimate = [
            "household" => [
                "income" => intval(str_replace(',', '', $request->income)),
                "people" => $peopleEstimate,
            ],
            "market" => "Individual",
            "place" => $place,
            "year" => $reqYear,
        ];
        $curlEstimate = curl_init();

        curl_setopt_array($curlEstimate, array(
            CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/households/eligibility/estimates?apikey=$apikey&year='. $reqYear,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($bodyEstimate),
            CURLOPT_HTTPHEADER => array(
                'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                'Content-Type: application/json'
            ),
        ));

        $responseEstimate = curl_exec($curlEstimate);

        curl_close($curlEstimate);

        $estimate = json_decode($responseEstimate);

        if(isset($estimate->message)){
            return $estimate->error;
        }

        foreach($estimate->estimates as $key => $value) {
            if($value->is_medicaid_chip==true){
                $chips[] = 1;
            }else {
                $chips[] = 0;
            }
        };

        foreach($request->people as $key => $value) {
            if(in_array(1, $chips)==0 || in_array(0, $chips)==0){

                if(in_array(1, $chips)==0 || in_array(0, $chips)==1){
                    $hasMec[$key] = false;
                }else {
                    if($value['age'] <= $maxAgeChip) {
                        $hasMec[$key] = false;
                    }else{
                        $hasMec[$key] = false;
                    }
                }
            }else {
                if($estimate->estimates[0]->aptc!==0){
                    if($value['age'] <= $maxAgeChip) {
                        $hasMec[$key] = true;
                    }else{
                        $hasMec[$key] = false;
                    }
                }else {
                    if($value['age'] <= $maxAgeChip) {
                        $hasMec[$key] = false;
                    }else{
                        $hasMec[$key] = false;
                    }
                }
            }

            for($i=0; $i<count($childrenArray); $i++){
                if($key == $childrenArray[$i]){
                    $hasMec[$key] = false;
                }
            }
            $people[] = [
                'age' => intval($value['age']),
                'aptc_eligible' => filter_var($value['aptc_eligible'], FILTER_VALIDATE_BOOLEAN),
                'gender' => $value['gender'],
                'has_mec' => $hasMec[$key],
                'uses_tobacco' => filter_var($value['uses_tobacco'], FILTER_VALIDATE_BOOLEAN),
                "utilization_level"=> "Medium"
            ];
        };


        #region ALL PLANS
        $body = [
            "filter" => [
                "issuers" =>

                    $issuers

                ,
                "metal_levels" =>

                    $metalLevels

                ,
                "deductible" => $reqDeductible,
                "premium" => $reqPremium
            ],
            "household" => [
                "income" => intval(str_replace(',', '', $request->income)),
                "people" =>
                    $people
                ,
            ],
            "market" => "Individual",
            "place" => $place,
            "sort"=> "premium",
            "limit" => 10,
            "offset" => $offset,
            "year" => $reqYear,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/plans/search?apikey=$apikey',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => array(
                'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                'Content-Type: text/plain'
            ),
        ));
        $response = curl_exec($curl);
        if(curl_errno($curl)) {
            return 'Curl error: '.curl_error($curl);
        }
        curl_close($curl);
        $plan = json_decode($response);
        if(isset($plan->message)){
            return $plan->error;
        }
        $plans = $plan->plans;


        if(count($plans)==0) {
            $reqPremium = null;
            $body = [
                "filter" => [
                    "issuers" =>

                        $issuers

                    ,
                    "metal_levels" =>

                        $metalLevels

                    ,
                    "deductible" => $reqDeductible,
                    "premium" => $reqPremium
                ],
                "household" => [
                    "income" => intval(str_replace(',', '', $request->income)),
                    "people" =>
                        $people
                    ,
                ],
                "market" => "Individual",
                "place" => $place,
                "sort"=> "premium",
                "limit" => 10,
                "offset" => $offset,
                "year" => $reqYear,
            ];

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/plans/search?apikey=$apikey',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($body),
                CURLOPT_HTTPHEADER => array(
                    'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                    'Content-Type: text/plain'
                ),
            ));
            $response = curl_exec($curl);
            if(curl_errno($curl)) {
                return 'Curl error: '.curl_error($curl);
            }
            curl_close($curl);
            $plan = json_decode($response);
            if(isset($plan->message)){
                return $plan->error;
            }
            $plans = $plan->plans;
        }


        #endregion

        #endregion

        if(count($plans) == 0) {
            $plans = null;
            $rating = null;
            $doctorCost = null;
            $drugCost = null;
            $emergencyCost = null;
            $specialistCost = null;
        }else {
            foreach($plan->plans as $key => $value) {
                $benefits[] = $value->benefits;
                $rating[] = $value->quality_rating->global_rating;
                foreach($benefits[$key] as $keys => $values) {
                    if($values->name == 'Primary Care Visit to Treat an Injury or Illness') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $doctorCost[] = 'Free';
                                }else {
                                    $doctorCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Generic Drugs') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $drugCost[] = 'Free';
                                }else {
                                    $drugCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Specialist Visit') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $specialistCost[] = 'Free';
                                }else {
                                    $specialistCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Emergency Room Services') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $emergencyCost[] = 'Free';
                                }else {
                                    $emergencyCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                }
            }
        }

        return [
            'plan' => $plans,
            'ranges' => $plan,
            'body' => $body,
            'offset' => $offset,
            'benefitsDoctorVisits' => $doctorCost,
            'benefitsDrug' => $drugCost,
            'emergencyCost' => $emergencyCost,
            'specialistCost' => $specialistCost,
            'rating' => $rating
        ];

    }

    public function apiHealthSearchClean(Request $request) {

        $plans = null;
        $rating = null;
        $doctorCost = null;
        $drugCost = null;
        $emergencyCost = null;
        $specialistCost = null;

        $place = [
            'countyfips' => $request->zipcodeFips,
            'state' => $request->zipcodeState,
            'zipcode' => $request->zipcodeNumber
        ];

        $maxAgeChip = $request->maxAgeChip;

        if(isset($request->offset)) {
            $offset = intval($request->offset);
        }else {
            $offset = 0;
        }

        if($request->issuers==null) {
            $issuers = [];
        }else {
            $issuers = $request->issuers;
        }

        if($request->metal_level==null) {
            $metalLevels = [];
        }else {
            $metalLevels = $request->metal_level;
        }

        if($request->deductible==null) {
            $reqDeductible = null;
        }else {
            $reqDeductible = intval($request->deductible);
        }

        if($request->premium==null) {
            $reqPremium = null;
        }else if($request->premiumsMin > $request->premium) {
            $reqPremium = ($request->premiumsMin * 1.2);
        }else {
            $reqPremium = (floatval($request->premium) * 1.2);
        }

        #region SEARCH PLANS
        $Object = new DateTime();
        $Object->setTimezone(new DateTimeZone('US/Eastern'));
        $DateAndTime = $Object->format('Y');
        $reqYear = intval($DateAndTime);

        foreach($request->people as $key => $value) {
            if($value['age'] <= $maxAgeChip) {
                $age = $maxAgeChip + 1;
                $hasMec[$key] = true;

            }else{
                $age = intval($value['age']);
                $hasMec[$key] = false;
            }
        };

        $estimate = $request->estimate;

        foreach($request->people as $key => $value) {

                if($estimate!=0 || $estimate!=null){
                    if($value['age'] <= $maxAgeChip) {
                        $age = $maxAgeChip + 1;
                        $hasMec[$key] = false;
                    }else{
                        $age = intval($value['age']);
                        $hasMec[$key] = false;
                    }
                }else {
                    if($value['age'] <= $maxAgeChip) {
                        $age = $maxAgeChip + 1;
                        $hasMec[$key] = true;
                    }else{
                        $age = intval($value['age']);
                        $hasMec[$key] = false;
                    }
                }

            $people[] = [
                'age' => $age,
                'aptc_eligible' => filter_var($value['aptc_eligible'], FILTER_VALIDATE_BOOLEAN),
                'gender' => $value['gender'],
                'has_mec' => $hasMec[$key],
                'uses_tobacco' => filter_var($value['uses_tobacco'], FILTER_VALIDATE_BOOLEAN),
                "utilization_level"=> "Medium"
            ];
        };

        #region ALL PLANS
        $body = [
            "filter" => [
                "issuers" =>

                    $issuers

                ,
                "metal_levels" =>

                    $metalLevels

                ,
                "deductible" => $reqDeductible,
                "premium" => $reqPremium
            ],
            "household" => [
                "income" => intval(str_replace(',', '', $request->income)),
                "people" =>
                    $people
                ,
            ],
            "market" => "Individual",
            "place" => $place,
            "sort"=> "premium",
            "limit" => 10,
            "offset" => $offset,
            "year" => $reqYear,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/plans/search?apikey=$apikey',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => array(
                'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                'Content-Type: text/plain'
            ),
        ));
        $response = curl_exec($curl);
        if(curl_errno($curl)) {
            return 'Curl error: '.curl_error($curl);
        }
        curl_close($curl);
        $plan = json_decode($response);
        if(isset($plan->message)){
            return $plan->error;
        }
        $plans = $plan->plans;


        if(count($plans)==0) {
            $reqPremium = null;
            $body = [
                "filter" => [
                    "issuers" =>

                        $issuers

                    ,
                    "metal_levels" =>

                        $metalLevels

                    ,
                    "deductible" => $reqDeductible,
                    "premium" => $reqPremium
                ],
                "household" => [
                    "income" => intval(str_replace(',', '', $request->income)),
                    "people" =>
                        $people
                    ,
                ],
                "market" => "Individual",
                "place" => $place,
                "sort"=> "premium",
                "limit" => 10,
                "offset" => $offset,
                "year" => $reqYear,
            ];

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/plans/search?apikey=$apikey',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($body),
                CURLOPT_HTTPHEADER => array(
                    'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                    'Content-Type: text/plain'
                ),
            ));
            $response = curl_exec($curl);
            if(curl_errno($curl)) {
                return 'Curl error: '.curl_error($curl);
            }
            curl_close($curl);
            $plan = json_decode($response);
            if(isset($plan->message)){
                return $plan->error;
            }
            $plans = $plan->plans;
        }


        #endregion

        #endregion

        if(count($plans) == 0) {
            $plans = null;
            $rating = null;
            $doctorCost = null;
            $drugCost = null;
            $emergencyCost = null;
            $specialistCost = null;
        }else {
            foreach($plan->plans as $key => $value) {
                $benefits[] = $value->benefits;
                $rating[] = $value->quality_rating->global_rating;
                foreach($benefits[$key] as $keys => $values) {
                    if($values->name == 'Primary Care Visit to Treat an Injury or Illness') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $doctorCost[] = 'Free';
                                }else {
                                    $doctorCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Generic Drugs') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $drugCost[] = 'Free';
                                }else {
                                    $drugCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Specialist Visit') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $specialistCost[] = 'Free';
                                }else {
                                    $specialistCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Emergency Room Services') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $emergencyCost[] = 'Free';
                                }else {
                                    $emergencyCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                }
            }
        }

        return [
            'plan' => $plans,
            'ranges' => $plan,
            'body' => $body,
            'offset' => $offset,
            'benefitsDoctorVisits' => $doctorCost,
            'benefitsDrug' => $drugCost,
            'emergencyCost' => $emergencyCost,
            'specialistCost' => $specialistCost,
            'rating' => $rating
        ];

    }

    public function apiHealthCompareNew(Request $request) {

        #region vars
        if(isset($request->children)){
            $childrenArray = $request->children;
        }else {
            $childrenArray = [];
        }

        $plans = null;
        $rating = null;
        $doctorCost = null;
        $drugCost = null;
        $emergencyCost = null;
        $specialistCost = null;


        $place = [
            'countyfips' => $request->zipcodeFips,
            'state' => $request->zipcodeState,
            'zipcode' => $request->zipcodeNumber
        ];

        $curlChip = curl_init();

            curl_setopt_array($curlChip, array(
              CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/states/'. $request->zipcodeState .'/medicaid??apikey=$apikey',
              CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                    'Content-Type: text/plain'
                ),
            ));

            $responseChip = curl_exec($curlChip);

            curl_close($curlChip);

            $chip = json_decode($responseChip);

            if(count($chip->chip)==0){
                $maxAgeChip = 18;
            }else {
                $maxAgeChip = $chip->chip[0]->max_age;
            }

        if($request->year==null) {
            $reqYear = 2022;
        }else {
            $reqYear = intval($request->year);
        }

        foreach($request->planId as $key => $value) {
            $comparePlans[] =
                $value
            ;
        };
        #endregion

        #region SEARCH PLANS

        foreach($request->people as $key => $value) {
            if($value['age'] <= $maxAgeChip) {

                    $hasMec[$key] = true;

            }else{
                $hasMec[$key] = false;
            }
            $peopleEstimate[] = [
                'age' => intval($value['age']),
                'aptc_eligible' => filter_var($value['aptc_eligible'], FILTER_VALIDATE_BOOLEAN),
                'gender' => $value['gender'],
                'has_mec' => $hasMec[$key],
                'uses_tobacco' => filter_var($value['uses_tobacco'], FILTER_VALIDATE_BOOLEAN),
                "utilization_level"=> "Medium"
            ];
        };

        $bodyEstimate = [
            "household" => [
                "income" => intval(str_replace(',', '', $request->income)),
                "people" => $peopleEstimate,
            ],
            "market" => "Individual",
            "place" => $place,
            "year" => $reqYear,
        ];
        $curlEstimate = curl_init();

        curl_setopt_array($curlEstimate, array(
            CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/households/eligibility/estimates?apikey=$apikey&year='. $reqYear,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($bodyEstimate),
            CURLOPT_HTTPHEADER => array(
                'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                'Content-Type: application/json'
            ),
        ));

        $responseEstimate = curl_exec($curlEstimate);

        curl_close($curlEstimate);

        $estimate = json_decode($responseEstimate);
        if(isset($estimate->message)){
            return $estimate->error;
        }
        foreach($estimate->estimates as $key => $value) {
            if($value->is_medicaid_chip==true){
                $chips[] = 1;
            }else {
                $chips[] = 0;
            }
        };

        foreach($request->people as $key => $value) {
            if(in_array(1, $chips)==0 || in_array(0, $chips)==0){

                if(in_array(1, $chips)==0 || in_array(0, $chips)==1){
                    $hasMec[$key] = false;
                }else {
                    if($value['age'] <= $maxAgeChip) {
                        $hasMec[$key] = false;
                    }else{
                        $hasMec[$key] = false;
                    }
                }
            }else {
                if($estimate->estimates[0]->aptc!==0){
                    if($value['age'] <= $maxAgeChip) {
                        $hasMec[$key] = true;
                    }else{
                        $hasMec[$key] = false;
                    }
                }else {
                    if($value['age'] <= $maxAgeChip) {
                        $hasMec[$key] = false;
                    }else{
                        $hasMec[$key] = false;
                    }
                }
            }

            for($i=0; $i<count($childrenArray); $i++){
                if($key == $childrenArray[$i]){
                    $hasMec[$key] = false;
                }
            }
            $people[] = [
                'age' => intval($value['age']),
                'aptc_eligible' => filter_var($value['aptc_eligible'], FILTER_VALIDATE_BOOLEAN),
                'gender' => $value['gender'],
                'has_mec' => $hasMec[$key],
                'uses_tobacco' => filter_var($value['uses_tobacco'], FILTER_VALIDATE_BOOLEAN),
                "utilization_level"=> "Medium"
            ];
        };

        #endregion

        #region ALL PLANS
        $body = [
            "household" => [
                "income" => intval(str_replace(',', '', $request->income)),
                "people" =>
                    $people
                ,
            ],
            "market" => "Individual",
            "place" => $place,
            "plan_ids" =>
                $comparePlans
            ,
            "year" => 2023,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://marketplace.api.healthcare.gov/api/v1/plans?apikey=$apikey&year='. $reqYear,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => array(
                'apikey: OxsBefBljgY48Lf89P88ww5EGXcEgGrO',
                'Content-Type: text/plain'
            ),
        ));
        $response = curl_exec($curl);
        if(curl_errno($curl)) {
            return 'Curl error: '.curl_error($curl);
        }
        curl_close($curl);
        $plan = json_decode($response);
        if(isset($plan->message)){
            return $plan->error;
        }
        $plans = $plan->plans;
        #endregion

        if(count($plans) == 0) {
            $plans = null;
            $rating = null;
            $doctorCost = null;
            $drugCost = null;
            $emergencyCost = null;
            $specialistCost = null;
            $xRayCost = null;
            $imagingCost = null;
            $bloodCost = null;
            $preventiveCost = null;
        }else {
            foreach($plan->plans as $key => $value) {
                $benefits[] = $value->benefits;
                $rating[] = $value->quality_rating->global_rating;
                foreach($benefits[$key] as $keys => $values) {
                    if($values->name == 'Primary Care Visit to Treat an Injury or Illness') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $doctorCost[] = 'Free';
                                }else {
                                    $doctorCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Generic Drugs') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $drugCost[] = 'Free';
                                }else {
                                    $drugCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Specialist Visit') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {$a[]= $i;
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $specialistCost[] = 'Free';
                                }else {
                                    $specialistCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Emergency Room Services') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $emergencyCost[] = 'Free';
                                }else {
                                    $emergencyCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'X-rays and Diagnostic Imaging') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $xRayCost[] = 'Free';
                                }else {
                                    $xRayCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Imaging (CT/PET Scans, MRIs)') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $imagingCost[] = 'Free';
                                }else {
                                    $imagingCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Laboratory Outpatient and Professional Services') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $bloodCost[] = 'Free';
                                }else {
                                    $bloodCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                    if($values->name == 'Preventive Care/Screening/Immunization') {
                        for ($i = 0; $i < count($values->cost_sharings); $i++) {
                            if ($values->cost_sharings[$i]->network_tier == 'In-Network') {
                                if($values->cost_sharings[$i]->display_string  == 'No Charge') {
                                    $preventiveCost[] = 'Free';
                                }else {
                                    $preventiveCost[] = $values->cost_sharings[$i]->display_string;
                                }
                                break;
                            }
                        }
                    }
                }
            }
        }

        return [
            'plan' => $plans,
            'ranges' => $plan,
            'body' => $body,
            'benefitsDoctorVisits' => $doctorCost,
            'benefitsDrug' => $drugCost,
            'emergencyCost' => $emergencyCost,
            'specialistCost' => $specialistCost,
            'xRayCost' => $xRayCost,
            'imagingCost' => $imagingCost,
            'bloodCost' => $bloodCost,
            'preventiveCost' => $preventiveCost,
            'rating' => $rating
        ];

    }

    //CHARTS
    public function salesChart(){

        session_start();
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        if(!isset($_SESSION['usersAdmin'])){
            return redirect('/loginAdm');
        }

        $role = DB::connection('mysql2')->table('user_roles as userRole')
        ->join('roles AS role', 'userRole.role_id', '=', 'role.id_roles')
        ->join('crm_login AS login', 'userRole.user_id', '=', 'login.id_login')
        ->where('role.role_permission', 'view-all-reports')
        ->where('login.login_email', $_SESSION['usersAdmin']['email'])
        ->select('userRole.*', 'role.role_permission', 'login.is_admin', 'login.login_email')
        ->first();

        if(!isset($role) && $_SESSION['usersAdmin']['is_admin']==0){
            return redirect()->route('user.logoutCrmAdmin');
        }

        $t = strtotime("-1 week");
        $y = strtotime("+1 year");
        $weekAgo = date("Y-m-d", $t);
        $weekNow = date("Y-m-d");
        $fistOfMonth = date('Y-m-01');
        $lastMonth_ini = new DateTime("first day of last month");
        $lastMonth_end = new DateTime("last day of last month");

        $nextYear_ini = date('Y-01-01', $y);
        $nextYear_end = date('Y-12-31', $y);

        $fistLastMonth = $lastMonth_ini->format('Y-m-d');
        $endLastMonth = $lastMonth_end->format('Y-m-d');

        $companiesDependents = [];
        $companies = [];
        $companiesThisYear = [];
        $companiesThisYearDependents = [];
        $companiesNextYear = [];
        $companiesNextYearDependents = [];

        $modelHealthCare = new InsurancePlans;
        $modelHealthCare->setConnection('mysql2');

        $modelHealthCare2 = new CrmLogin;
        $modelHealthCare2->setConnection('mysql2');

        $modelHealthCare3 = new ClientHealth;
        $modelHealthCare3->setConnection('mysql2');

        $modelHealthCare4 = new Dependents;
        $modelHealthCare4->setConnection('mysql2');

        $data = $modelHealthCare->where('active', 1)->whereNotNull('seller')->whereNotNull('activated_at')->get();
        $dataCompanies = $modelHealthCare->where('active', 1)->whereNotNull('seller')->whereBetween('activated_at', array('2022-01-01','2022-12-31'))->get();
        $dataCompaniesNext = $modelHealthCare->where('active', 1)->whereNotNull('seller')->whereBetween('activated_at', array($nextYear_ini,$nextYear_end))->get();

        $dataDependents = DB::connection('mysql2')->table('insurance_plans')->where('active', 1)->whereNotNull('seller')->whereNotNull('activated_at')
        ->join('dependents', 'insurance_plans.id_client', '=', 'dependents.idclient')
        ->select('insurance_plans.*', 'dependents.idclient')
        ->get();

        $dataCompaniesDependents = DB::connection('mysql2')->table('insurance_plans')
        ->where('active', 1)->whereNotNull('seller')->whereNotNull('activated_at')->whereBetween('activated_at', array('2022-01-01','2022-12-31'))
        ->join('dependents', 'insurance_plans.id_client', '=', 'dependents.idclient')
        ->select('insurance_plans.*', 'dependents.idclient')
        ->get();

        $dataCompaniesNextDependents = DB::connection('mysql2')->table('insurance_plans')
        ->where('active', 1)->whereNotNull('seller')->whereNotNull('activated_at')->whereBetween('activated_at', array('2023-01-01','2023-12-31'))
        ->join('dependents', 'insurance_plans.id_client', '=', 'dependents.idclient')
        ->select('insurance_plans.*', 'dependents.idclient')
        ->get();

        $renewDependents = DB::connection('mysql2')->table('clients')->where('is_renewed', 1)->where('active', 1)->whereNotNull('activated_at')->whereBetween('until_date', array($nextYear_ini,$nextYear_end))
        ->join('insurance_plans', 'clients.idclient', '=', 'insurance_plans.id_client')
        ->join('dependents', 'clients.idclient', '=', 'dependents.idclient')
        ->select('clients.*', 'insurance_plans.until_date', 'dependents.idclient')
        ->get();

        $newDependents = DB::connection('mysql2')->table('clients')->where('is_new', 1)->where('active', 1)->whereNotNull('activated_at')->whereBetween('until_date', array($nextYear_ini,$nextYear_end))
        ->join('insurance_plans', 'clients.idclient', '=', 'insurance_plans.id_client')
        ->join('dependents', 'clients.idclient', '=', 'dependents.idclient')
        ->select('clients.*', 'insurance_plans.until_date', 'dependents.idclient')
        ->get();

        $renew = DB::connection('mysql2')->table('clients')->where('is_renewed', 1)->where('active', 1)->whereNotNull('activated_at')->whereBetween('until_date', array($nextYear_ini,$nextYear_end))
        ->join('insurance_plans', 'clients.idclient', '=', 'insurance_plans.id_client')
        ->select('clients.*', 'insurance_plans.until_date')
        ->get();

        $new = DB::connection('mysql2')->table('clients')->where('is_new', 1)->where('active', 1)->whereNotNull('activated_at')->whereBetween('until_date', array($nextYear_ini,$nextYear_end))
        ->join('insurance_plans', 'clients.idclient', '=', 'insurance_plans.id_client')
        ->select('clients.*', 'insurance_plans.until_date')
        ->get();

        foreach($dataDependents as $key => $value) {
            $companiesDependents[] = $value->insurance_company;
        }

        foreach($data as $key => $value) {
            $sellers[] = $value->seller;
            $companies[] = $value->insurance_company;
            $crmLogin = $modelHealthCare3->where('idclient', $value->id_client)->first();
            if($value->until_date>='2023-01-01' && $value->until_date<='2023-12-31'){
                if($crmLogin->is_renewed==1 || $crmLogin->is_new==1) {
                    $salesTotal[] = $value;
                }
            }
        }

        foreach($renew as $key => $value) {
            $countRenew[] = $value->idclient;
        }

        foreach($new as $key => $value) {
            $countNew[] = $value->idclient;
        }

        foreach($dataCompanies as $key => $value) {
            $companiesThisYear[] = $value->insurance_company;
        }

        foreach($dataCompaniesDependents as $key => $value) {
            $companiesThisYearDependents[] = $value->insurance_company;
        }

        foreach($dataCompaniesNext as $key => $value) {
            $companiesNextYear[] = $value->insurance_company;
        }

        foreach($dataCompaniesNextDependents as $key => $value) {
            $companiesNextYearDependents[] = $value->insurance_company;
        }

        $totalSales = count($new) + count($renew);
        $newSales = count($newDependents)+count($new);
        $renewSales = count($renewDependents)+count($renew);
        $dataSeller = array_unique($sellers);
        $idSeller = array_values($dataSeller);
        $countCompanies = array_count_values(array_merge($companies, $companiesDependents));
        $companiesName = array_keys($countCompanies);
        $companiesKeys = array_values($countCompanies);
        $countCompaniesThisYear = array_count_values(array_merge($companiesThisYear, $companiesThisYearDependents));
        $companiesNameThisYear = array_keys($countCompaniesThisYear);
        $companiesKeysThisYear = array_values($countCompaniesThisYear);
        $countCompaniesNextYear = array_count_values(array_merge($companiesNextYear, $companiesNextYearDependents));
        $companiesNameNextYear = array_keys($countCompaniesNextYear);
        $companiesKeysNextYear = array_values($countCompaniesNextYear);

        foreach($idSeller as $key => $value) {
            $crmLogin = $modelHealthCare2->where('id_login', $value)->first();
            if($crmLogin->enterprise==1000){
                $idSellers[] = $crmLogin->id_login;
                $sales[$key] = $modelHealthCare->where('active', 1)->where('seller', $value)->whereNotNull('activated_at')->get();
                $salesWeek[$key] = $modelHealthCare->where('active', 1)->where('seller', $value)->whereBetween('activated_at', array($weekAgo,$weekNow))->get();
                $salesMonth[$key] = $modelHealthCare->where('active', 1)->where('seller', $value)->whereBetween('activated_at', array($fistOfMonth,$weekNow))->get();
                $salesLastMonth[$key] = $modelHealthCare->where('active', 1)->where('seller', $value)->whereBetween('activated_at', array($fistLastMonth,$endLastMonth))->get();
                $salesToday[$key] = $modelHealthCare->where('active', 1)->where('seller', $value)->where('activated_at', $weekNow)->get();
                $salesDependent[] = DB::connection('mysql2')->table('insurance_plans')
                ->where('active', 1)->where('seller', $value)->whereNotNull('activated_at')
                ->join('dependents', 'insurance_plans.id_client', '=', 'dependents.idclient')
                ->select('insurance_plans.*', 'dependents.idclient')
                ->get();
                $nameSellers[] = $crmLogin->login_firstname;
                $fullNameSellers[] = $crmLogin->login_firstname .  ' '  . $crmLogin->login_lastname;
                $salesWeeksDependent[] = DB::connection('mysql2')->table('insurance_plans')
                ->where('active', 1)->where('seller', $value)->whereNotNull('activated_at')->whereBetween('activated_at', array($weekAgo,$weekNow))
                ->join('dependents', 'insurance_plans.id_client', '=', 'dependents.idclient')
                ->select('insurance_plans.*', 'dependents.idclient')
                ->get();
                $salesMonthsDependent[] = DB::connection('mysql2')->table('insurance_plans')
                ->where('active', 1)->where('seller', $value)->whereNotNull('activated_at')->whereBetween('activated_at', array($fistOfMonth,$weekNow))
                ->join('dependents', 'insurance_plans.id_client', '=', 'dependents.idclient')
                ->select('insurance_plans.*', 'dependents.idclient')
                ->get();
                $salesLastMonthsDependent[] = DB::connection('mysql2')->table('insurance_plans')
                ->where('active', 1)->where('seller', $value)->whereNotNull('activated_at')->whereBetween('activated_at', array($fistLastMonth,$endLastMonth))
                ->join('dependents', 'insurance_plans.id_client', '=', 'dependents.idclient')
                ->select('insurance_plans.*', 'dependents.idclient')
                ->get();
                $salesTodaysDependent[] = DB::connection('mysql2')->table('insurance_plans')
                ->where('active', 1)->where('seller', $value)->where('activated_at', $weekNow)
                ->join('dependents', 'insurance_plans.id_client', '=', 'dependents.idclient')
                ->select('insurance_plans.*', 'dependents.idclient')
                ->get();
                $totalClients[] = $modelHealthCare->where('seller', $value)->get();
                $activeClient[] = $modelHealthCare->where('active', 1)->where('seller', $value)->whereNotNull('activated_at')->get();
                $inactiveClient[] = $modelHealthCare->where([['seller', $value], ['active', 3]])->orWhere([['seller', $value], ['activated_at', null]])->get();
            }
        }

        foreach($sales as $key => $value) {
            $allSales = $value;
            $countSalesClient[] = count($allSales);
        }

        foreach($salesDependent as $key => $value) {
            $allSalesDependent = [];
            foreach($value as $keys => $values){
                $allSalesDependent[] = $values;
            }
            $countSalesDependent[] = count($allSalesDependent);
        }

        foreach($countSalesClient as $key => $value) {
            $countSales[] = $value + $countSalesDependent[$key];
        }

        foreach($salesWeek as $key => $value) {
            $allSalesWeek = $value;
            $countSalesWeekClient[] = count($allSalesWeek);
        }

        foreach($salesWeeksDependent as $key => $value) {
            $allSalesWeekDependent = [];
            foreach($value as $keys => $values){
                $allSalesWeekDependent[] = $values;
            }
            $countSalesWeekDependent[] = count($allSalesWeekDependent);
        }

        foreach($countSalesWeekClient as $key => $value) {
            $countSalesWeek[] = $value + $countSalesWeekDependent[$key];
        }

        foreach($salesMonth as $key => $value) {
            $allSalesMonth = $value;
            $countSalesMonthClient[] = count($allSalesMonth);
        }

        foreach($salesMonthsDependent as $key => $value) {
            $allSalesMonthDependent = [];
            foreach($value as $keys => $values){
                $allSalesMonthDependent[] = $values;
            }
            $countSalesMonthDependent[] = count($allSalesMonthDependent);
        }

        foreach($countSalesMonthClient as $key => $value) {
            $countSalesMonth[] = $value + $countSalesMonthDependent[$key];
        }

        foreach($salesLastMonth as $key => $value) {
            $allSalesLastMonth = $value;
            $countSalesLastMonthClient[] = count($allSalesLastMonth);
        }

        foreach($salesLastMonthsDependent as $key => $value) {
            $allSalesLastMonthDependent = [];
            foreach($value as $keys => $values){
                $allSalesLastMonthDependent[] = $values;
            }
            $countSalesLastMonthDependent[] = count($allSalesLastMonthDependent);
        }

        foreach($countSalesLastMonthClient as $key => $value) {
            $countSalesLastMonth[] = $value + $countSalesLastMonthDependent[$key];
        }

        foreach($salesToday as $key => $value) {
            $allSalesToday = $value;
            $countSalesTodayClient[] = count($allSalesToday);
        }

        foreach($salesTodaysDependent as $key => $value) {
            $allSalesTodayDependent = [];
            foreach($value as $keys => $values){
                $allSalesTodayDependent[] = $values;
            }
            $countSalesTodayDependent[] = count($allSalesTodayDependent);
        }

        foreach($countSalesTodayClient as $key => $value) {
            $countSalesToday[] = $value + $countSalesTodayDependent[$key];
        }

        return view('front.charts.salesChart', [
            'data'                  => $data,
            'companiesName'         => $companiesName,
            'companiesKeys'         => $companiesKeys,
            'companiesNameNextYear' => $companiesNameNextYear,
            'companiesKeysNextYear' => $companiesKeysNextYear,
            'companiesNameThisYear' => $companiesNameThisYear,
            'companiesKeysThisYear' => $companiesKeysThisYear,
            'totalSales'            => $totalSales,
            'newSales'              => $newSales,
            'renewSales'            => $renewSales,
            'nameSellers'           => $nameSellers,
            'fullNameSellers'       => $fullNameSellers,
            'idSellers'             => $idSellers,
            'totalClients'          => $totalClients,
            'inactiveClient'        => $inactiveClient,
            'activeClient'          => $activeClient,
            'countSales'            => $countSales,
            'countSalesWeek'        => $countSalesWeek,
            'countSalesMonth'       => $countSalesMonth,
            'countSalesToday'       => $countSalesToday,
            'countSalesLastMonth'   => $countSalesLastMonth
        ]);
    }

    public function salesChartCompanies(Request $request){

        if($request->year==2022){
            $year = '';
        }else if($request->year==2023){
            $year = 'Next Year';
        }else {
            $year = '';
        }
        $lastMonth_ini = new DateTime("first day of ".$request->month. ' ' .$year);
        $lastMonth_end = new DateTime("last day of ".$request->month. ' ' .$year);

        $month_ini = $lastMonth_ini->format('Y-m-d');
        $month_end = $lastMonth_end->format('Y-m-d');

        $modelHealthCare = new InsurancePlans;
        $modelHealthCare->setConnection('mysql2');

        $companiesDependents = [];
        $companies = [];

        $data = $modelHealthCare->where('active', 1)->whereNotNull('seller')->whereBetween('activated_at', array($month_ini, $month_end))->get();

        $dataDependents = DB::connection('mysql2')->table('insurance_plans')->where('active', 1)->whereNotNull('seller')->whereBetween('activated_at', array($month_ini, $month_end))
        ->join('dependents', 'insurance_plans.id_client', '=', 'dependents.idclient')
        ->select('insurance_plans.*', 'dependents.idclient')
        ->get();

        foreach($dataDependents as $key => $value) {
            $companiesDependents[] = $value->insurance_company;
        }

        foreach($data as $key => $value) {
            $companies[] = $value->insurance_company;
        }

        $countCompanies = array_count_values(array_merge($companies, $companiesDependents));
        $companiesName = array_keys($countCompanies);
        $companiesKeys = array_values($countCompanies);

        return [
            'companiesName'         => $companiesName,
            'companiesKeys'         => $companiesKeys
        ];

    }

    //PDF ACIDENTES E PROTEÇOES DOENÇAS
    public function accidentpolicy() {

        session_start();
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }
        $currlang = Language::where('id', 1)->first();

        return view('pdf.policy.accidentpolicy-pdf', compact('currlang'));

    }
    public function accidentsicknesspolicy() {

        session_start();
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }
        $currlang = Language::where('id', 1)->first();
        return view('pdf.policy.accidentsicknesspolicy-pdf', compact('currlang'));

    }
    public function cancercareprotector() {

        session_start();
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }
        $currlang = Language::where('id', 1)->first();
        return view('pdf.policy.cancercareprotector-pdf', compact('currlang'));

    }
    public function sickpayplus() {

        session_start();
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }
        $currlang = Language::where('id', 1)->first();
        return view('pdf.policy.sickpayplus-pdf', compact('currlang'));

    }
    public function accidentpolicyPt() {

        session_start();
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }
        $currlang = Language::where('id', 1)->first();
        return view('pdf.policy.accidentpolicyPt-pdf', compact('currlang'));

    }
    public function accidentsicknesspolicyPt() {

        session_start();
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }
        $currlang = Language::where('id', 1)->first();
        return view('pdf.policy.accidentsicknesspolicyPt-pdf', compact('currlang'));

    }
    public function cancercareprotectorPt() {

        session_start();
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }
        $currlang = Language::where('id', 1)->first();
        return view('pdf.policy.cancercareprotectorPt-pdf', compact('currlang'));

    }
    public function sickpayplusPt() {

        session_start();
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }
        $currlang = Language::where('id', 1)->first();
        return view('pdf.policy.sickpayplusPt-pdf', compact('currlang'));

    }
    public function accidentpolicyEs() {

        session_start();
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }
        $currlang = Language::where('id', 1)->first();
        return view('pdf.policy.accidentpolicyEs-pdf', compact('currlang'));

    }
    public function accidentsicknesspolicyEs() {

        session_start();
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }
        $currlang = Language::where('id', 1)->first();
        return view('pdf.policy.accidentsicknesspolicyEs-pdf', compact('currlang'));

    }
    public function cancercareprotectorEs() {

        session_start();
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }
        $currlang = Language::where('id', 1)->first();
        return view('pdf.policy.cancercareprotectorEs-pdf', compact('currlang'));

    }
    public function sickpayplusEs() {

        session_start();
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }
        $currlang = Language::where('id', 1)->first();
        return view('pdf.policy.sickpayplusEs-pdf', compact('currlang'));

    }
    public function printPdf() {
        $path = 'assets/images/policys/accidentprotector-7.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $path2 = 'assets/images/policys/arrow-right.png';
        $type2 = pathinfo($path2, PATHINFO_EXTENSION);
        $data2 = file_get_contents($path2);
        $logo2 = 'data:image/' . $type2 . ';base64,' . base64_encode($data2);
        $path3 = 'assets/front/img/footer_logo1638389275701890753.png';
        $type3 = pathinfo($path3, PATHINFO_EXTENSION);
        $data3 = file_get_contents($path3);
        $logo3 = 'data:image/' . $type3 . ';base64,' . base64_encode($data3);

        view()->share([
            'logo' => $logo,
            'logo2' => $logo2,
            'logo3' => $logo3
        ]);

        //return view('pdf.download.accidentsicknesspolicy-pdf');

        $name = 'arquivo';

        /* Options */
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', false);
        $options->set('isPhpEnabled', true);
        $options->set('isJavascriptEnabled', TRUE);

        /********/

        $dompdf = new Dompdf($options);

        /* Start Cache HTML */
        ob_start();

        require  dirname(__FILE__,5) . '/resources/views/pdf/download/accidentsicknesspolicy-pdf.blade.php';

        $dompdf->loadHtml(ob_get_clean());

        $dompdf->setPaper("a4", "portrait");

        $dompdf->render();

        $dompdf->stream(strtoupper($name).".pdf",["Attachment" => false]);

    }

    //IP
    static function info() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }
        elseif(preg_match('/Firefox/i',$u_agent))
        {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        }
        elseif(preg_match('/Chrome/i',$u_agent))
        {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        }
        elseif(preg_match('/Safari/i',$u_agent))
        {
            $bname = 'Apple Safari';
            $ub = "Safari";
        }
        elseif(preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Opera';
            $ub = "Opera";
        }
        elseif(preg_match('/Netscape/i',$u_agent))
        {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }
            else {
                $version= $matches['version'][1];
            }
        }
        else {
            $version= $matches['version'][0];
        }

        // check if we have a number
        if ($version==null || $version=="") {$version="?";}

        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );


    }
    function getBrowser(){
        $ua = FrontendController::info();


			$yourbrowser= "Sent By: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'] . " reports: <br >" . $ua['userAgent'] . '<br >' . date('M-d-Y H:i:s') ;

            $ipaddress = '';
            if (isset($_SERVER['HTTP_CLIENT_IP']))
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if (isset($_SERVER['HTTP_X_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            else if (isset($_SERVER['HTTP_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            else if (isset($_SERVER['REMOTE_ADDR']))
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            else
                $ipaddress = 'UNKNOWN';

			return $yourbrowser . '<br> IP:' . $ipaddress;
    }
    public function getHash($data = null){
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
    function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    //Contact
    public function sendContact(Request $request) {

        session_start();
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }


        if ($currlang->id==1){
            $message = 'Successfully Sent';
            $messageError = "You've already sent a message, one of our specialist will contact your shortly!";
        }
        if ($currlang->id==3){
            $message = 'Enviado com Sucesso';
            $messageError = 'Você já enviou uma mensagem, em breve entraremos em contato!';
        }
        if ($currlang->id==4){
            $message = 'Enviado con exito';
            $messageError = 'Ya enviaste un mensaje, ¡nos comunicaremos pronto!';
        }


        if(!isset($_SESSION["contact"])) {

            $modelHealthCare4 = new Leads;
            $modelHealthCare4->setConnection('mysql2');

            $Object = new DateTime();
            $Object->setTimezone(new DateTimeZone('US/Eastern'));
            $DateAndTime = $Object->format('Y-m-d H:i:s');

            $phone = $request->countryCode . ' ' . $request->phone_mobile;
            $newPhone = str_replace([' ','-','(',')','+'], '', $phone);

            $comment = $request->subject.' - '. $request->message;

            if(isset($request->email)){
                $email = $request->email;
            }else {
                $email = 'johndoe@2easy.com';
            }

            $modelHealthCare4::create([
                'firstname'     => $request->name,
                'lastname'      => '',
                'email'         => $email,
                'lead_method'   => 'Contato',
                'phone'         => $newPhone,
                'created_at'    => $DateAndTime,
                'comment'       => $comment,
                'is_converted'  => 0
            ]);

            $_SESSION["contact"] = 1;

            return redirect()->back()->with('message', $message);

        }else {

            return redirect()->back()->with('messageError', $messageError);
        }

    }

    //Faq page
    public function faq() {
         if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

        $faqs = Faq::where('status', 1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->get();
        return view('front.faq', compact('faqs'));
    }

    //About page
    public function about() {
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

        $data['features'] = Feature::where('status',1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->get();
        $data['why_selects'] = WhySelect::where('status',1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->get();
        $data['histories'] = History::where('status',1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->get();

        return view('front.about', $data);
    }

    //service page
    public function service() {
         if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

        $data['services'] = Service::where('status',1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->get();

        return view('front.service', $data);
    }

    public function service_details($slug){

      if (session()->has('lang')) {
        $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

            $data['service'] = Service::where('slug', $slug)->where('language_id', $currlang->id)->firstOrFail();
            $data['all_services'] = Service::where('status', 1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->get();

            return view('front.service-details', $data);
    }

    //INSURERS PAGE
    public function insurers() {
        if (session()->has('lang')) {
           $currlang = Language::where('code', session()->get('lang'))->first();
       } else {
           $currlang = Language::where('is_default', 1)->first();
       }

       return view('front.insurers');
   }

    //Portfolio page
    public function portfolio(Request $request) {
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

        $category = $request->category;
        $catid = null;
        if (!empty($category)) {
            $data['category'] = Service::where('slug', $category)->firstOrFail();
            $catid = $data['category']->id;
        }
        $data['all_services'] = Service::where('status', 1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->get();


        $data['portfolios'] = Portfolio::where('status',1)->where('language_id', $currlang->id)
                            ->when($catid, function ($query, $catid) {
                                return $query->where('service_id', $catid);
                            })
                            ->orderBy('serial_number', 'asc')->paginate(8);

        return view('front.portfolio', $data);
    }

    public function portfolio_details($slug){
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

        $data['portfolio'] = Portfolio::where('slug', $slug)->where('language_id', $currlang->id)->firstOrFail();
        $data['portfolio_images'] = PortfolioImage::where('portfolio_id', $data['portfolio']->id)->get();

        return view('front.portfolio-details', $data);
    }

    // Gallery Page
    public function gallery(Request $request) {

        if (session()->has('lang')) {
           $currlang = Language::where('code', session()->get('lang'))->first();
       } else {
           $currlang = Language::where('is_default', 1)->first();
       }

       $data['gcategories'] = Gcategory::where('status', 1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->get();
       $data['galleries'] = Gallery::where('status', 1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->get();




       return view('front.gallery', $data);
    }


    // Career Page
    public function career(Request $request){
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

        $category = $request->category;
        $catid = null;
        if (!empty($category)) {
            $data['category'] = Jcategory::where('slug', $category)->firstOrFail();
            $catid = $data['category']->id;
        }
        $term = $request->term;

        $data['jcategories'] = Jcategory::where('status',1)->where('language_id', $currlang->id)->orderBy('id', 'desc')->get();

        $data['alljobs'] = Job::where('status', 1)->where('language_id', $currlang->id)->get();

        $data['jobs'] = Job::where('status', 1)->where('language_id', $currlang->id)
                        ->when($catid, function ($query, $catid) {
                            return $query->where('jcategory_id', $catid);
                        })
                        ->when($term, function ($query, $term) {
                            return $query->where('title', 'like', '%'.$term.'%');
                        })
                        ->orderBy('id', 'desc')->paginate(10);

        return view('front.job', $data);
    }


    // Career  Details Page
    public function careerdetails($slug) {

        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

        $alljobs = Job::where('status', 1)->where('language_id', $currlang->id)->get();
        $job = Job::where('slug', $slug)->where('language_id', $currlang->id)->firstOrFail();
        $jcategories = Jcategory::where('status', 1)->where('language_id', $currlang->id)->orderBy('id', 'DESC')->get();

        return view('front.jobdetails', compact('job', 'jcategories', 'alljobs'));
    }

    // Job Apply Route
    public function job_apply(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'file' => 'required|mimes:pdf,PDF',
        ]);

            if(JobApplication::where('email',$request->email)->exists()){
                Session::flash('warning',__('Job Apply Allready Submitted'));
                return back();
            }

            $application = new JobApplication();


            $file = $request->file('file');
            $pdf = Str::random().$request->name.'.'.$file->getClientOriginalExtension();

            $file->move('assets/front/application/', $pdf);

            $job = Job::findOrFail($request->job_id);


            $application->status = '0';
            $application->job_title = $job->title;
            $application->type = $job->position;
            $application->phone = $request->phone;
            $application->file = $pdf;
            $application->name = $request->name;
            $application->email = $request->email;
            $application->message = $request->message;
            $application->expected_salary = $request->expected_salary;
            $application->save();


            Session::flash('success', 'Job Apply Submit Successfully');
            return back();

    }

    //package page
    public function package() {
         if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

        $data['plans'] = Package::where('status',1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->get();

        return view('front.package', $data);
    }

    //team page
    public function team() {
         if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

        $data['teams'] = Team::where('language_id', $currlang->id)->where('status',1)->orderBy('serial_number', 'asc')->paginate(6);

        return view('front.team', $data);
    }

    public function team_details($id){

        $team = Team::find($id);

        return view('front.team-details', compact('team'));
    }

    //contact page
    public function contact() {
         if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

        $data['sectionInfo'] = Sectiontitle::where('language_id', $currlang->id)->first();
        $data['socials'] = Social::all();

        return view('front.contact', $data);
    }
    public function contactSubmit(Request $request){



        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'message' => 'required',
            'subject' => 'required|string',
        ]);

        $visibility = Visibility::first();


        if($visibility->is_recaptcha == 1){
            $messages = [
                'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
                'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
            ];
            $rules['g-recaptcha-response'] = 'required|captcha';

            $request->validate($rules, $messages);
        }


        // Login Section
        $cs = Setting::first();
        $contactemail = $cs->contactemail;
        $name = $request->name;
        $fromemail = $request->email;
        $number = $request->phone;
        $subject = $request->subject;
        $mail = new PHPMailer(true);
        $em = Emailsetting::first();

        if ($em->is_smtp == 1) {
            try {
                $mail->isSMTP();
                $mail->Host       = $em->smtp_host;
                $mail->SMTPAuth   = true;
                $mail->Username   = $em->smtp_user;
                $mail->Password   = $em->smtp_pass;
                $mail->SMTPSecure = $em->email_encryption;
                $mail->Port       = $em->smtp_port;

                //Recipients
                $mail->setFrom($fromemail, $name);
                $mail->addAddress($contactemail);

                // Content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = "Name: ".$name."<br> Email: ".$fromemail."<br> Phone: ".$number."<br> Message: ".$request->message;

                $mail->send();
            } catch (Exception $e) {
                // die($e->getMessage());
            }
        } else {
            try {
                //Recipients
                $mail->setFrom($fromemail, $name);
                $mail->addAddress($contactemail);


                // Content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = "Name: ".$name."<br> Email: ".$fromemail."<br> Phone: ".$number."<br> Message: ".$request->message;

                $mail->send();
            } catch (Exception $e) {
                // die($e->getMessage());
            }
        }

        Session::flash('success', 'Mail send successfully');
        return redirect()->back();

    }

    // Blog Page  Funtion
    public function blogs(Request $request){

        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }


        $category = $request->category;
        $catid = null;
        if (!empty($category)) {
            $data['category'] = Bcategory::where('slug', $category)->firstOrFail();
            $catid = $data['category']->id;
        }

        $term = $request->term;
        $month = $request->month;
        $year = $request->year;

        if (!empty($month) && !empty($year)) {
            $archive = true;
        } else {
            $archive = false;
        }

        $bcategories = Bcategory::where('status', 1)->where('language_id', $currlang->id)->orderBy('id', 'DESC')->get();

        $latestblogs = Blog::where('status', 1)->where('language_id', $currlang->id)->orderBy('id', 'DESC')->limit(4)->get();
        $archives = Archive::orderBy('id', 'DESC')->get();

        $blogs = Blog::where('status', 1)->where('language_id', $currlang->id)
                        ->when($catid, function ($query, $catid) {
                            return $query->where('bcategory_id', $catid);
                        })
                        ->when($term, function ($query, $term) {
                            return $query->where('title', 'like', '%'.$term.'%');
                        })
                        ->when($archive, function ($query) use ($month, $year) {
                            return $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
                        })
                        ->orderBy('serial_number', 'asc')->paginate(5);

        return view('front.blogs', compact('blogs', 'bcategories', 'latestblogs', 'archives'));
    }

    // Blog Details  Funtion
    public function blogdetails($slug) {

        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

        $blog = Blog::where('slug', $slug)->where('language_id', $currlang->id)->firstOrFail();
        $latestblogs = Blog::where('status', 1)->where('language_id', $currlang->id)->orderBy('id', 'DESC')->limit(4)->get();
        $bcategories = Bcategory::where('status', 1)->where('language_id', $currlang->id)->orderBy('id', 'DESC')->get();
        $archives = Archive::orderBy('id', 'DESC')->get();

        return view('front.blogdetails', compact('blog', 'bcategories', 'latestblogs', 'archives'));
    }

    // Front Daynamic Page Function
    public function front_dynamic_page($slug){
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

        $front_daynamic_page = Daynamicpage::where('slug', $slug)->where('language_id', $currlang->id)->firstOrFail();

        return view('front.daynamicpage', compact('front_daynamic_page'));
    }
    public function front_dynamic_page_edit($slug){
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

        $front_daynamic_page = Daynamicpage::where('slug', $slug)->where('language_id', $currlang->id)->firstOrFail();

        return view('front.daynamicpage-edit', compact('front_daynamic_page'));
    }
    public function update_front_dynamic_page($slug, Request $request){
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

        Daynamicpage::where('slug', $slug)->where('language_id', $currlang->id)->update([
            'image' => $request->image,
            'content' => $request->getContent(),
            'content_1' => $request->image,
            'bt_link' => $request->bt_link,
            'bt_title' => $request->bt_title,
            'faq_title' => $request->faq_title,
            'faq_title_1' => $request->faq_title_1,
            'faq_content_1' => $request->faq_content_1,
            'faq_title_2' => $request->faq_title_2,
            'faq_content_2' => $request->faq_content_2,
            'faq_title_3' => $request->faq_title_3,
            'faq_content_3' => $request->faq_content_3
        ]);

        $notification = array(
            'messege' => 'Update successfully',
            'alert' => 'success'
          );

          return redirect()->back()->with('notification', $notification);
    }
    public function front_about_edit(){
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

        $data['features'] = Feature::where('status',1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->get();
        $data['why_selects'] = WhySelect::where('status',1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->get();
        $data['histories'] = History::where('status',1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->get();

        return view('front.about-edit', $data);
    }
    public function update_front_about(Request $request){
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

        Sectiontitle::where('language_id', $currlang->id)->update([
            'about_image' => $request->about_image,
            'about_sub_title' => $request->about_sub_title,
            'about_title_2' => $request->about_title_2,
            'about_text' => $request->about_text,
            'about_text_2' => $request->about_text_2,
            'about_text_3' => $request->about_text_3,
            'about_video' => $request->about_video,
            'about_diff_img_1' => $request->about_diff_img_1,
            'about_diff_title_1' => $request->about_diff_title_1,
            'about_diff_text_1' => $request->about_diff_text_1,
            'about_diff_img_2' => $request->about_diff_img_2,
            'about_diff_title_2' => $request->about_diff_title_2,
            'about_diff_text_2' => $request->about_diff_text_2,
            'about_diff_img_3' => $request->about_diff_img_3,
            'about_diff_title_3' => $request->about_diff_title_3,
            'about_diff_text_3' => $request->about_diff_text_3,
            'about_diff_img_4' => $request->about_diff_img_4,
            'about_diff_title_4' => $request->about_diff_title_4,
            'about_diff_text_4' => $request->about_diff_text_4,
            'meeet_us_text' => $request->meeet_us_text,
            'meeet_us_button_subtitle' => $request->meeet_us_button_subtitle,
            'meeet_us_button_link' => $request->meeet_us_button_link,
            'meeet_us_button_text' => $request->meeet_us_button_text,
            'meeet_us_bg_image' => $request->meeet_us_bg_image
        ]);

        $notification = array(
            'messege' => 'Update successfully',
            'alert' => 'success'
          );

          return redirect()->back()->with('notification', $notification);

    }
    public function service_edit_details($slug){
        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

        $data['service'] = Service::where('slug', $slug)->where('language_id', $currlang->id)->firstOrFail();
        $data['all_services'] = Service::where('status', 1)->where('language_id', $currlang->id)->orderBy('serial_number', 'asc')->get();

        return view('front.service-details-edit', $data);
    }
    public function service_update_details($slug, Request $request){

        if (session()->has('lang')) {
            $currlang = Language::where('code', session()->get('lang'))->first();
        } else {
            $currlang = Language::where('is_default', 1)->first();
        }

        Service::where('title', $slug)->where('language_id', $currlang->id)->update([
            'image_2' => $request->image_2,
            'image_4' => $request->image_4,
            'content_2' => $request->content_2,
            'content' => $request->getContent(),
            'bt_link' => $request->bt_link,
            'bt_title' => $request->bt_title,
            'image_3' => $request->image_3,
            'video' => $request->video,
            'faq_title' => $request->faq_title,
            'faq_title_1' => $request->faq_title_1,
            'faq_content_1' => $request->faq_content_1,
            'faq_title_2' => $request->faq_title_2,
            'faq_content_2' => $request->faq_content_2,
            'faq_title_3' => $request->faq_title_3,
            'faq_content_3' => $request->faq_content_3
        ]);

        $notification = array(
            'messege' => 'Update successfully',
            'alert' => 'success'
          );

          return redirect()->back()->with('notification', $notification);
    }

   // Front Quote Page Function
    public function quote()
    {
        return view('front.quote');
    }

    public function quote_submit(Request $request){

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'subject' => 'required|string',
            'description' => 'required',
            'file' => 'nullable|mimes:pdf,doc,docx,zip',
        ]);

        $commonsetting = Setting::where('id', 1)->first();

        if ($commonsetting->is_recaptcha == 1) {
            $messages = [
                'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
                'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
            ];
        }

        if ($commonsetting->is_recaptcha == 1) {
            $rules['g-recaptcha-response'] = 'required|captcha';

            $request->validate($rules, $messages);
        }




        $quote = new Quote();

        if($request->hasFile('file')){

            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $newfile = time().rand().'.'.$extension;
            $file->move('assets/front/quote/', $newfile);

            $quote->file = $newfile;
        }

        $quote->name = $request->name;
        $quote->email = $request->email;
        $quote->phone = $request->phone;
        $quote->skypenumber = $request->skypenumber;
        $quote->country = $request->country;
        $quote->budget = $request->budget;
        $quote->subject = $request->subject;
        $quote->description = $request->description;
        $quote->save();

        Session::flash('success', 'Quote send successfully');
        return redirect()->back();

    }

    public function slider_overlay(){
        return view('front.slider');
    }

    // Change Language
    public function changeLanguage($lang)
    {
        session_start();
        $_SESSION["MODAL"] = 'OK';

        session()->put('lang', $lang);

        app()->setLocale($lang);

        return redirect()->back();
    }

    // Change Currency
    public function changeCurrency($currency)
    {


        session()->put('currency', $currency);


        return redirect()->back();
    }

}
