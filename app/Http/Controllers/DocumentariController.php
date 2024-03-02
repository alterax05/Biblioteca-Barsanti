<?php

namespace App\Http\Controllers;


use App\Models\Documentari;
use App\Models\Reparto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentariController extends Controller
{
    public function index($docum)
    {
        $reparti = Reparto::where('id_reparto', '>', 0)
            ->selectRaw('reparti.id_reparto,
            reparti.reparto,
            reparti.icon,
            (SELECT COUNT(*) FROM documentari WHERE documentari.tipologia = reparti.id_reparto GROUP BY documentari.tipologia) numeri')
            ->orderByDesc('numeri')
            ->get();

        $documentario = Documentari::where('id_documentario', $docum)
            ->join('fornitori', 'fornitori.id_fornitore', 'documentari.fornitore')
            ->first();

        if($documentario == null)
            return redirect('/documentaries/list');

        return view('documentari.index')
            ->with('reparti', $reparti)
            ->with('documentario', $documentario);
    }

    public function add(Request $request) {
        $this->validate($request, [
            'video' => 'required|string',
            'tipologia' => 'required|int',
        ]);

        $embed = explode('v=', $request->input('video'))[1];
        $info = json_decode(file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=id%2C+snippet&id=".$embed."&key=AIzaSyDjGkSNde1S92vxY7sExigTwNoARXKUc-4"), true);

        $documentario = null;
        if($info != null) {
            $documentario = Documentari::create([
                'titolo' => $info['items'][0]['snippet']['title'],
                'subtitolo' => $info['items'][0]['snippet']['channelTitle'],
                'embed' => $embed,
                'uploader' => Auth::id(),
                'tipologia' => $request->input('tipologia'),
                'link' => $request->input('video'),
                'thumbnail' => "",
                'fornitore' => "1",
            ]);
        }

        return redirect("/documentaries/" . $documentario->id_documentario);
    }

    public function list($reparto = 0)
    {
        $reparti = Reparto::where('id_reparto', '>', 0)
            ->selectRaw('reparti.id_reparto,
            reparti.reparto,
            reparti.icon,
            (SELECT COUNT(*) FROM documentari WHERE documentari.tipologia = reparti.id_reparto GROUP BY documentari.tipologia) numeri')
            ->orderByDesc('numeri')
            ->get();

        $documentari = Documentari::where('id_documentario', '>', 0);
        if($reparto != 0) {
            $documentari->where('tipologia', $reparto);
        }

        $documentari->join('fornitori', 'fornitori.id_fornitore', 'documentari.fornitore');
        $documentari->orderBy('id_documentario');
        $documentari = $documentari->paginate(9);

        return view('documentari.list')
                ->with('documentari', $documentari)
                ->with('reparti', $reparti);
    }
}
