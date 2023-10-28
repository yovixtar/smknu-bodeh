<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;

class GoogleDriveController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->client = new Google_Client();
            $this->client->setClientId('171738721418-n9774irnlhsafbjvgrlioqhlu7ud6f9a.apps.googleusercontent.com');
            $this->client->setClientSecret('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');
            $this->client->setRedirectUri('https://smknu-bodeh.sch.id/pjj/callback');
            $this->client->addScope(Google_Service_Drive::DRIVE);

            if ($request->session()->has('access_token')) {
                $this->client->setAccessToken($request->session()->get('access_token'));
            }

            return $next($request);
        });
    }

    public function cekAuth(Request $request)
    {
        if ($request->session()->has('access_token')) {
            return $this->index($request);
        } else {
            return redirect($this->client->createAuthUrl());
        }
    }

    public function login(Request $request)
    {
        return $this->cekAuth($request);
    }

    public function logout(Request $request)
    {
        if ($this->client->isAccessTokenExpired()) {
            $request->session()->forget('access_token');
            return redirect('/pjj/login');
        }
        return $this->listFiles('siswa');
    }

    public function index(Request $request)
    {
        if ($request->session()->has('access_token')) {
            if ($this->client->isAccessTokenExpired()) {
                $request->session()->forget('access_token');
                return redirect('/pjj/login');
            }
            return $this->listFiles('siswa');
        } else {
            return view('pjj/home-login');
        }
    }

    public function indexGuru(Request $request)
    {
        if ($request->session()->has('access_token')) {
            return $this->listFiles('guru');
        } else {
            return view('pjj/home-login');
        }
    }

    public function uploadPage(Request $request)
    {
        return view('pjj/upload');
    }

    public function callback(Request $request)
    {
        if (!$request->has('code')) {
            return redirect('/pjj');
        }

        $token = $this->client->fetchAccessTokenWithAuthCode($request->input('code'));
        $request->session()->put('access_token', $token);

        return redirect('/pjj');
    }

    public function uploadToGD(Request $request, $kelas, $hari)
    {
        if (!$request->hasFile('file')) {
            return redirect('/pjj/guru')->with('error', 'No file was provided');
        }

        // Ganti ini dengan ID folder Google Drive yang sesuai untuk setiap kelas dan hari
        $folderIds = [
            'X AKL' => [
                'Senin, 3 April' => '1Kd1jwK6XtiN6wiMdAwgwkWe7HMTohr2c',
                'Selasa, 4 April' => '1LZ1zW9vBhK3o9W2Si-BZp5LNIzlsiggx',
                'Rabu, 5 April' => '1Xfk0mSgldLV9dcWuzRqxyXkW9KJZBNT2',
                'Kamis, 6 April' => '1KOxwB3tk_C0J1y5OPkv1XolpB_6N0PDL',
                'Senin, 10 April' => '146H5ghllyzW60-S9wJn7l7ZqgxjWnfXg',
                'Selasa, 11 April' => '1W7YlGJ_IVcahkxWOdKmjJjmav_Aexvkb',
            ],
            'X TJKT' => [
                'Senin, 3 April' => '1p7DmB5sqRHjSJyISElHAPZXvgTzCXncp',
                'Selasa, 4 April' => '1jscWw8Le_cZlX8yQyNE2jwjmXfrZweMR',
                'Rabu, 5 April' => '1nFi2nFrVED7QKoRISn4fqrQEbk4ZJNmK',
                'Kamis, 6 April' => '1OjPnfxYb9Ltm9LzSlHG8uSt0EkHlNZf-',
                'Senin, 10 April' => '1fOD12Mzr1bxsvodgTRmRGdjn3bEO6FnH',
                'Selasa, 11 April' => '1I6nu4yalihTgv77tFP4K7RNPDVpo-VSX',
            ],
            'X TO' => [
                'Senin, 3 April' => '1jKkglZgbUNtJRmssMs_wKT7vWiNhkygj',
                'Selasa, 4 April' => '1266qr0OROkwjRrgi1OoXvuyDbxSQc5V8',
                'Rabu, 5 April' => '1yiu44zyykvpv7QaM4SlOpn23NSIGSgaK',
                'Kamis, 6 April' => '1wgvHwRnUF-NPn353XzBmRcgbDVKM6Rwv',
                'Senin, 10 April' => '1ZcqnvMzgNbdHUQnwv6q-BlEpGWP_12_z',
                'Selasa, 11 April' => '1H9GTeBpBTkHjkUq_9RKNdxe21j4mjV05',
            ],
            'XI AKL' => [
                'Senin, 3 April' => '12bia_tHgyl721a6FV-vF0c5eZrfL3HpT',
                'Selasa, 4 April' => '16ispf0h3BA3vEBqVHVF2PHH4qvyLt1ZM',
                'Rabu, 5 April' => '1SWSL_elUEQoaCfzQuI8UOSd2x9kPbciE',
                'Kamis, 6 April' => '1NBJ7QxPUvwc5ijvDbh4NVe74Td-GngtN',
                'Senin, 10 April' => '1rp3vyefKbIzXbQex_CjHOQm9cUS6gvW9',
                'Selasa, 11 April' => '1enr-JOdXsOifN7hEDqSPygvV-iJ-m086',
            ],
            'XI TBSM' => [
                'Senin, 3 April' => '1faElOAaaIikZ3ZUOX59cqLCzfnBgxw6Z',
                'Selasa, 4 April' => '1d6sipdgIK-JWE6E-S994DdJcUBWW9Y__',
                'Rabu, 5 April' => '1QGIJlgIKxmqfFUHMFatjLwui0cJFv9cQ',
                'Kamis, 6 April' => '1mf7JJKf_hEJwA7rKQ6zW_HiMVGPfHIbs',
                'Senin, 10 April' => '1okpv30PXyB8c__CeEpYlpNajBdHmwgN3',
                'Selasa, 11 April' => '14jiejfB20SQeTMzuVsKIaLZXBz9aXkWR',
            ],
            'XI TKJ' => [
                'Senin, 3 April' => '1TQqubToJpv4bS71JBfJuwXwsc3VPTVCJ',
                'Selasa, 4 April' => '1SMQjpmtiMKG4X0KGQ5p8rpSHk1lulx1M',
                'Rabu, 5 April' => '1M1xg8jEmr2DoNX3PKaDKiVToxUstmO8v',
                'Kamis' => '161sBVz9bVFB-YS_GXMe4ZzvfATh7tO82',
                'Senin, 10 April' => '1MgHjsvRWKPYfdUy9CsPS8rUa6g4m9xN6',
                'Selasa, 11 April' => '1XXS1hnlNSKffh3j5QJPBpkOgWubW5kPA',
            ],
            'XI TKRO' => [
                'Senin, 3 April' => '1R4WFiGv6jSphyORVTihvHi6DXqnYpGZR',
                'Selasa, 4 April' => '1ygT6FI4WlqNjuJR6kg_Ckbce2zKcqo_X',
                'Rabu, 5 April' => '17mdf2k4lXe3MMGEtS_K1r15793W6tpnS',
                'Kamis, 6 April' => '1g1oRsumXDpYIETAHxw3oD4dx8b---CMQ',
                'Senin, 10 April' => '1zDOQI6upwBF1ifcOZVBZB65CqG4bQUgy',
                'Selasa, 11 April' => '1_46GsMysB3TEwk5qIkX_oAyUdZ86swum',
            ],
        ];

        $file = $request->file('file');
        $path = $file->getRealPath();

        $service = new Google_Service_Drive($this->client);

        $folderId = $folderIds[$kelas][$hari];

        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $file->getClientOriginalName(),
            'parents' => [$folderId]
        ]);

        $content = file_get_contents($path);
        $createdFile = $service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $file->getMimeType(),
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);

        return redirect('/pjj/guru')->with('success', 'File uploaded successfully: ' . $createdFile->id);
    }

    public function listFiles($role = 'siswa')
    {
        $service = new Google_Service_Drive($this->client);
        $files = [];

        // Ganti ini dengan ID folder Google Drive yang sesuai untuk setiap kelas dan hari
        $folderIds = [
            'X AKL' => [
                'Senin, 3 April' => '1Kd1jwK6XtiN6wiMdAwgwkWe7HMTohr2c',
                'Selasa, 4 April' => '1LZ1zW9vBhK3o9W2Si-BZp5LNIzlsiggx',
                'Rabu, 5 April' => '1Xfk0mSgldLV9dcWuzRqxyXkW9KJZBNT2',
                'Kamis, 6 April' => '1KOxwB3tk_C0J1y5OPkv1XolpB_6N0PDL',
                'Senin, 10 April' => '146H5ghllyzW60-S9wJn7l7ZqgxjWnfXg',
                'Selasa, 11 April' => '1W7YlGJ_IVcahkxWOdKmjJjmav_Aexvkb',
            ],
            'X TJKT' => [
                'Senin, 3 April' => '1p7DmB5sqRHjSJyISElHAPZXvgTzCXncp',
                'Selasa, 4 April' => '1jscWw8Le_cZlX8yQyNE2jwjmXfrZweMR',
                'Rabu, 5 April' => '1nFi2nFrVED7QKoRISn4fqrQEbk4ZJNmK',
                'Kamis, 6 April' => '1OjPnfxYb9Ltm9LzSlHG8uSt0EkHlNZf-',
                'Senin, 10 April' => '1fOD12Mzr1bxsvodgTRmRGdjn3bEO6FnH',
                'Selasa, 11 April' => '1I6nu4yalihTgv77tFP4K7RNPDVpo-VSX',
            ],
            'X TO' => [
                'Senin, 3 April' => '1jKkglZgbUNtJRmssMs_wKT7vWiNhkygj',
                'Selasa, 4 April' => '1266qr0OROkwjRrgi1OoXvuyDbxSQc5V8',
                'Rabu, 5 April' => '1yiu44zyykvpv7QaM4SlOpn23NSIGSgaK',
                'Kamis, 6 April' => '1wgvHwRnUF-NPn353XzBmRcgbDVKM6Rwv',
                'Senin, 10 April' => '1ZcqnvMzgNbdHUQnwv6q-BlEpGWP_12_z',
                'Selasa, 11 April' => '1H9GTeBpBTkHjkUq_9RKNdxe21j4mjV05',
            ],
            'XI AKL' => [
                'Senin, 3 April' => '12bia_tHgyl721a6FV-vF0c5eZrfL3HpT',
                'Selasa, 4 April' => '16ispf0h3BA3vEBqVHVF2PHH4qvyLt1ZM',
                'Rabu, 5 April' => '1SWSL_elUEQoaCfzQuI8UOSd2x9kPbciE',
                'Kamis, 6 April' => '1NBJ7QxPUvwc5ijvDbh4NVe74Td-GngtN',
                'Senin, 10 April' => '1rp3vyefKbIzXbQex_CjHOQm9cUS6gvW9',
                'Selasa, 11 April' => '1enr-JOdXsOifN7hEDqSPygvV-iJ-m086',
            ],
            'XI TBSM' => [
                'Senin, 3 April' => '1faElOAaaIikZ3ZUOX59cqLCzfnBgxw6Z',
                'Selasa, 4 April' => '1d6sipdgIK-JWE6E-S994DdJcUBWW9Y__',
                'Rabu, 5 April' => '1QGIJlgIKxmqfFUHMFatjLwui0cJFv9cQ',
                'Kamis, 6 April' => '1mf7JJKf_hEJwA7rKQ6zW_HiMVGPfHIbs',
                'Senin, 10 April' => '1okpv30PXyB8c__CeEpYlpNajBdHmwgN3',
                'Selasa, 11 April' => '14jiejfB20SQeTMzuVsKIaLZXBz9aXkWR',
            ],
            'XI TKJ' => [
                'Senin, 3 April' => '1TQqubToJpv4bS71JBfJuwXwsc3VPTVCJ',
                'Selasa, 4 April' => '1SMQjpmtiMKG4X0KGQ5p8rpSHk1lulx1M',
                'Rabu, 5 April' => '1M1xg8jEmr2DoNX3PKaDKiVToxUstmO8v',
                'Kamis' => '161sBVz9bVFB-YS_GXMe4ZzvfATh7tO82',
                'Senin, 10 April' => '1MgHjsvRWKPYfdUy9CsPS8rUa6g4m9xN6',
                'Selasa, 11 April' => '1XXS1hnlNSKffh3j5QJPBpkOgWubW5kPA',
            ],
            'XI TKRO' => [
                'Senin, 3 April' => '1R4WFiGv6jSphyORVTihvHi6DXqnYpGZR',
                'Selasa, 4 April' => '1ygT6FI4WlqNjuJR6kg_Ckbce2zKcqo_X',
                'Rabu, 5 April' => '17mdf2k4lXe3MMGEtS_K1r15793W6tpnS',
                'Kamis, 6 April' => '1g1oRsumXDpYIETAHxw3oD4dx8b---CMQ',
                'Senin, 10 April' => '1zDOQI6upwBF1ifcOZVBZB65CqG4bQUgy',
                'Selasa, 11 April' => '1_46GsMysB3TEwk5qIkX_oAyUdZ86swum',
            ],
        ];

        foreach ($folderIds as $class => $dayFolders) {
            $fileGroups[$class] = [];
            foreach ($dayFolders as $day => $folderId) {
                $fileGroups[$class][$day] = [];
                $query = "mimeType!='application/vnd.google-apps.folder' and '{$folderId}' in parents";
                $pageToken = null;
                do {
                    $result = $service->files->listFiles([
                        'q' => $query,
                        'spaces' => 'drive',
                        'fields' => 'nextPageToken, files(id, name, webViewLink)',
                        'pageToken' => $pageToken
                    ]);

                    foreach ($result->getFiles() as $file) {
                        $fileGroups[$class][$day][] = [
                            'id' => $file->getId(),
                            'name' => $file->getName(),
                            'link' => $file->getWebViewLink(),
                        ];
                    }

                    $pageToken = $result->getNextPageToken();
                } while ($pageToken != null);
            }
        }

        if ($role == 'guru') {
            return view('pjj/home-list', ['fileGroups' => $fileGroups]);
        } else {
            return view('pjj/siswa-list', ['fileGroups' => $fileGroups]);
        }
    }

    public function download($fileId)
    {
        $service = new Google_Service_Drive($this->client);

        try {
            $file = $service->files->get($fileId, ['alt' => 'media']);
            $headers = [
                'Content-Type' => $file->getMimeType(),
                'Content-Disposition' => 'attachment; filename="' . $file->getName() . '"',
            ];

            return response($file->getBody(), 200, $headers);
        } catch (Exception $e) {
            return response('File not found.', 404);
        }
    }
}
