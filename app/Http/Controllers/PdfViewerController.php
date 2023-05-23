<?php

namespace App\Http\Controllers;

use App\Models\RandomCode;
use Illuminate\Http\Request;
Use DateTime;

class PdfViewerController extends Controller
{
    /**
     * It returns a 5 random digit
     * @return string
     */
    private function generateRandomId(): string
    {
        return substr(md5(microtime(true).mt_Rand()). 0, -5);

    }
    public function share($randomCode = null)
    {
        echo $randomCode;
        if ($randomCode === null) {
            $randomCode = $this->generateRandomId();
            RandomCode::create([
                'code' => $randomCode
            ]);

            return redirect('/share/'.$randomCode);
        }

        //return Response::make(file_get_contents('images/file.pdf'), 200, [
        //  'content-type'=>'application/pdf',
        //]);
        return view('viewer')->with(compact('randomCode'));
    }

    public function saveTime(Request $request) {
        $theRecord = RandomCode::where('code', $request['randomcode'])->first();
        $theRecord->updated_at = now();
        $theRecord->save();
        return response()->json(['success'=>'Laravel ajax example is being processed.']);
    }

    public function reporter() {
        $records = RandomCode::all();
        foreach ($records as $index => $record) {
            $start_date = new DateTime($record['created_at']);
            $since_start = $start_date->diff(new DateTime($record['updated_at']));
            $records[$index]['time_spent'] = $since_start->i.' hours, '.$since_start->i.' minutes, '.$since_start->s.' secs';
        }
        return view('reporter')->with(compact('records'));
    }
}
