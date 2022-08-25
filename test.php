public function checkstatus()
    {
        $clientId = '3291';
        $sharedkey = 'IBRnBngTRqcPSjax';
        $systrace = rand(1, 1000);
        $secretKey = '99a1780fa6bbc6c24ae41d6593729a57';
        $abc = $clientId . $sharedkey . $systrace;
        $words = hash_hmac('sha1', $abc, $secretKey, false);
        $urlsignon = 'https://staging.doku.com/dokupay/h2h/signon?clientId=' . $clientId . '&clientSecret=' . $secretKey . '&systrace=' . $systrace . '&words=' . $words . '&version=1.0&responseType=1';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlsignon,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
        ));

        $responsesignon = curl_exec($curl);
        curl_close($curl);
        $hasilsignon = json_decode($responsesignon, true);
        $accesstoken = $hasilsignon['accessToken'];
        $transactionid = 'INV-1661253919';
        $abc = $clientId . $systrace . $clientId . $transactionid . $sharedkey; //(clientId + systrace when SignOn + dpMallId + transactionId + sharedkey)
        $wordscheckstatus = hash_hmac('sha1', $abc, $secretKey, false);
        $urlcheckstatus = 'https://staging.doku.com/dokupay/h2h/checkstatusqris?clientId=' . $clientId . '&accessToken=' . $accesstoken . '&dpMallId=' . $clientId . '&words=' . $wordscheckstatus . '&version=3.0&transactionId=' . $transactionid;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $urlcheckstatus,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
        ));
        $responsechekstatus = curl_exec($curl);
        curl_close($curl);
        $hasilcheckstatus = json_decode($responsechekstatus, true);

        var_dump($hasilcheckstatus);
    }
