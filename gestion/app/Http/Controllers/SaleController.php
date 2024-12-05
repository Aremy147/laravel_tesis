<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleFormRequest;
use App\Http\Requests\UpdSaleFormRequest;
use App\Models\DetailSale;
use App\Models\Sale;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        //
        if($request)
        {
            $query=     trim($request->get('searchText'));
            $ventas=    DB::table('sales as v')
                        ->join('entities as p','v.client_id','=','p.id')
                        ->join('detail_sales as ds','v.id','=','ds.sale_id')
                        ->select('v.id',DB::raw("DATE_FORMAT(v.created_at,'%d/%m/%Y') as created_at"),
                        'p.name','v.type_voucher','v.serial_voucher','v.number_voucher','v.status','v.total')
                        ->where('v.number_voucher','LIKE','%'.$query.'%')
                        ->orderBy('v.id','desc')
                        ->groupBy('v.id','v.created_at','p.name','v.type_voucher','v.serial_voucher','v.number_voucher','v.status','v.total')
                        ->paginate(7);
            return view('ventas.venta.index',["ventas"=>$ventas,"searchText"=>$query]);    
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $personas=DB::table('entities')->where('type','=','Cliente')->get();
        $transportes=DB::table('carriers')->where('status','=','1')->get();
        $articulos= DB::table('items as art')
                    ->join('detail_incomes as di','art.id','=','di.item_id')
                    ->select(DB::raw('CONCAT(art.codevar," ",art.name) as articulo'),'art.id'
                    ,'art.stock',DB::raw('avg(di.sale_price) as precio_promedio'))
                    ->where('art.status','=','1')
                    ->where('art.stock','>','0')
                    ->groupBy('articulo','art.id','art.stock')
                    ->get();
        return view("ventas.venta.create",["personas"=>$personas,"articulos"=>$articulos,"transportes"=>$transportes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaleFormRequest $request)
    {
        //
        try {
            //code...
            DB::beginTransaction();
            $venta=new Sale;
            $venta->client_id=$request->get('client_id');
            $venta->carrier_id=$request->get('carrier_id');
            $venta->type_voucher=$request->get('type_voucher');
            $venta->serial_voucher=$request->get('serial_voucher');
            $venta->number_voucher=$request->get('number_voucher');
            $venta->total=$request->get('total');
            $venta->status=$request->get('status');
            $venta->save();

            $idarticulo=$request->get('item_id');
            $cantidad=$request->get('quantity');
            //$precio_compra=$request->get('purchase_price');
            $precio_venta=$request->get('sale_price');

            $cont=0;
            while($cont<count($idarticulo)){
                $detalle=new DetailSale();
                $detalle->sale_id=$venta->id;
                $detalle->item_id=$idarticulo[$cont];
                $detalle->quantity=$cantidad[$cont];
                //$detalle->purchase_price=$precio_compra[$cont];
                $detalle->sale_price=$precio_venta[$cont];
                $detalle->save();
                $cont=$cont+1;
            }
            DB::commit();

        } 
        catch (Exception $e){
            //Log::error()
            Log::error('Error en la transacción: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            DB::rollBack();
        }
        return redirect('ventas/venta');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $venta= DB::table('sales as v')
        ->join('entities as p','i.client_id','=','p.id')
        ->join('detail_incomes as di','di.income_id','=','i.id')
        ->select('v.id','v.created_at','p.name','v.type_voucher','v.serial_voucher',
        'v.number_voucher','v.status','v.total')
        ->where('i.id','=',$id)
        ->groupBy('v.id', 'v.created_at', 'p.name', 'i.type_voucher', 'i.serial_voucher','i.number_voucher','i.status')
        ->first();

        $detalles=  DB::table('detail_sale as d')
                    ->join('items as a','d.item_id','=','a.id')
                    ->select('a.name as articulo','d.quantity','d.sale_price')
                    ->where('d.sale_id','=',$id)
                    ->get();
        return view('compras.ingreso.show',['venta'=>$venta,'detalles'=>$detalles]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $venta= DB::table('sales as v')
        ->join('entities as p','v.client_id','=','p.id')
        ->join('detail_incomes as di','di.income_id','=','v.id')
        ->select('v.id','v.created_at','p.name','v.type_voucher','v.serial_voucher',
        'v.number_voucher','v.status','v.total')
        ->where('v.id','=',$id)
        ->groupBy('v.id', 'v.created_at', 'p.name', 'v.type_voucher', 'v.serial_voucher','v.number_voucher','v.status','v.total')
        ->first();

        $detalles=  DB::table('detail_sales as d')
                    ->join('items as a','d.item_id','=','a.id')
                    ->select('a.name as articulo','d.quantity','d.sale_price')
                    ->where('d.sale_id','=',$id)
                    ->get();
        return view('ventas.venta.edit',['venta'=>$venta,'detalles'=>$detalles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdSaleFormRequest $request, string $id)
    {
        //
        $venta=Sale::findOrFail($id);
        $venta->status=$request->get('status');
        $venta->update();
        return redirect('ventas/venta');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $venta=Sale::findOrFail($id);
        $venta->status='Anulado';
        $venta->update();

        return redirect('ventas/venta');
    }
}
