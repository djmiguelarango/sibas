<?php

namespace Sibas\Http\Controllers\Admin;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use Sibas\Entities\RetailerProduct;
use Sibas\Http\Requests;


class ContentAdminController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_de($nav, $action, $id_retailer_product)
    {
        //dd($id_retailer_product);
        $main_menu = $this->menu_principal();
        $array_data = $this->array_data();
        if($action=='list'){
            $query = \DB::table('ad_contents')
                ->where('ad_retailer_product_id', $id_retailer_product)
                ->first();
            $query_retailer = RetailerProduct::join('ad_company_products as acp', 'acp.id', '=', 'ad_retailer_products.ad_company_product_id')
                ->join('ad_products as ap', 'ap.id', '=', 'acp.ad_product_id')
                ->select('ap.name as product')
                ->where('ad_retailer_products.id',$id_retailer_product)
                ->first();
            //dd($query);
            return view('admin.de.content.list', compact('nav', 'action', 'id_retailer_product', 'query', 'main_menu', 'query_retailer', 'array_data'));
        }elseif($action=='new'){
            $query_retailer = RetailerProduct::join('ad_company_products as acp', 'acp.id', '=', 'ad_retailer_products.ad_company_product_id')
                ->join('ad_products as ap', 'ap.id', '=', 'acp.ad_product_id')
                ->select('ap.name as product')
                ->where('ad_retailer_products.id',$id_retailer_product)
                ->first();
            return view('admin.de.content.new', compact('nav', 'action', 'id_retailer_product', 'main_menu', 'query_retailer', 'array_data'));
        }
    }

    public function index_vi($nav, $action, $id_retailer_product)
    {
        //dd($action);
        $main_menu = $this->menu_principal();
        $array_data = $this->array_data();
        if($action=='list'){
            $query = \DB::table('ad_contents')
                ->where('ad_retailer_product_id', $id_retailer_product)
                ->first();
            $query_retailer = RetailerProduct::join('ad_company_products as acp', 'acp.id', '=', 'ad_retailer_products.ad_company_product_id')
                ->join('ad_products as ap', 'ap.id', '=', 'acp.ad_product_id')
                ->select('ap.name as product')
                ->where('ad_retailer_products.id',$id_retailer_product)
                ->first();
            //dd($query);
            return view('admin.vi.content.list', compact('nav', 'action', 'id_retailer_product', 'query', 'main_menu', 'query_retailer', 'array_data'));
        }elseif($action=='new'){
            $query_retailer = RetailerProduct::join('ad_company_products as acp', 'acp.id', '=', 'ad_retailer_products.ad_company_product_id')
                ->join('ad_products as ap', 'ap.id', '=', 'acp.ad_product_id')
                ->select('ap.name as product')
                ->where('ad_retailer_products.id',$id_retailer_product)
                ->first();
            return view('admin.vi.content.new', compact('nav', 'action', 'id_retailer_product', 'main_menu', 'query_retailer', 'array_data'));
        }
    }

    public function index_au($nav, $action, $id_retailer_product)
    {
        //dd($action);
        $main_menu = $this->menu_principal();
        $array_data = $this->array_data();
        if($action=='list'){
            $query = \DB::table('ad_contents')
                ->where('ad_retailer_product_id', $id_retailer_product)
                ->first();
            $query_retailer = RetailerProduct::join('ad_company_products as acp', 'acp.id', '=', 'ad_retailer_products.ad_company_product_id')
                ->join('ad_products as ap', 'ap.id', '=', 'acp.ad_product_id')
                ->select('ap.name as product')
                ->where('ad_retailer_products.id',$id_retailer_product)
                ->first();
            //dd($query);
            return view('admin.au.content.list', compact('nav', 'action', 'id_retailer_product', 'query', 'main_menu', 'query_retailer', 'array_data'));
        }elseif($action=='new'){
            $query_retailer = RetailerProduct::join('ad_company_products as acp', 'acp.id', '=', 'ad_retailer_products.ad_company_product_id')
                ->join('ad_products as ap', 'ap.id', '=', 'acp.ad_product_id')
                ->select('ap.name as product')
                ->where('ad_retailer_products.id',$id_retailer_product)
                ->first();
            return view('admin.au.content.new', compact('nav', 'action', 'id_retailer_product', 'main_menu', 'query_retailer', 'array_data'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * MULTIRIESGO
     */
    public function index_mr($nav, $action, $id_retailer_product)
    {
        //dd($action);
        $main_menu = $this->menu_principal();
        $array_data = $this->array_data();
        if($action=='list'){
            $query = \DB::table('ad_contents')
                ->where('ad_retailer_product_id', $id_retailer_product)
                ->first();
            $query_retailer = RetailerProduct::join('ad_company_products as acp', 'acp.id', '=', 'ad_retailer_products.ad_company_product_id')
                ->join('ad_products as ap', 'ap.id', '=', 'acp.ad_product_id')
                ->select('ap.name as product')
                ->where('ad_retailer_products.id',$id_retailer_product)
                ->first();
            //dd($query);
            return view('admin.td.content.list', compact('nav', 'action', 'id_retailer_product', 'query', 'main_menu', 'query_retailer', 'array_data'));
        }elseif($action=='new'){
            $query_retailer = RetailerProduct::join('ad_company_products as acp', 'acp.id', '=', 'ad_retailer_products.ad_company_product_id')
                ->join('ad_products as ap', 'ap.id', '=', 'acp.ad_product_id')
                ->select('ap.name as product')
                ->where('ad_retailer_products.id',$id_retailer_product)
                ->first();
            return view('admin.td.content.new', compact('nav', 'action', 'id_retailer_product', 'main_menu', 'query_retailer', 'array_data'));
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *DESGRAVAMEN
     */
    public function store_de(Request $request)
    {
        $this->validate($request, [
            'txtFile' => 'required|mimes:jpeg,jpg,png,x-png'
        ]);

        //dd($request->file('txtFile'));

        // upload the image //
        $file = $request->file('txtFile');
        $destination_path = 'assets/files/';
        $file_id = date('U') . '_' . md5(uniqid('@F#1$' . time(), true));
        $filename = $file_id . '.' . $file->getClientOriginalExtension();
        $file->move($destination_path, $filename);
        $field_image = $destination_path . $filename;

        try {
            $query_insert = \DB::table('ad_contents')->insert(
                [
                    'ad_retailer_product_id' => $request->input('id_retailer_product'),
                    'title' => $request->input('txtTitulo'),
                    'content' => $request->input('txtContenido'),
                    'file' => $field_image,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]
            );

            return redirect()->route('admin.de.content.list', ['nav' => 'contentde', 'action' => 'list', 'id_retailer_product' => $request->input('id_retailer_product')])->with(array('ok'=>'Se registro correctamente los datos del formulario'));

        }catch(QueryException $e){
            return redirect()->back()->with(array('error'=>$e->getMessage()));
        }
    }

    /*VIDA*/
    public function store_vi(Request $request)
    {
        $this->validate($request, [
            'txtFile' => 'required|mimes:jpeg,jpg,png,x-png'
        ]);

        //dd($request->file('txtFile'));

        // upload the image //
        $file = $request->file('txtFile');
        $destination_path = 'assets/files/';
        $file_id = date('U') . '_' . md5(uniqid('@F#1$' . time(), true));
        $filename = $file_id . '.' . $file->getClientOriginalExtension();
        $file->move($destination_path, $filename);
        $field_image = $destination_path . $filename;

        try {
            $query_insert = \DB::table('ad_contents')->insert(
                [
                    'ad_retailer_product_id' => $request->input('id_retailer_product'),
                    'title' => $request->input('txtTitulo'),
                    'content' => $request->input('txtContenido'),
                    'file' => $field_image,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]
            );

            return redirect()->route('admin.vi.content.list', ['nav' => 'contentvi', 'action' => 'list', 'id_retailer_product' => $request->input('id_retailer_product')])->with(array('ok'=>'Se registro correctamente los datos del formulario'));

        }catch(QueryException $e){
            return redirect()->back()->with(array('error'=>$e->getMessage()));
        }
    }

    /*AUTOMOTORES*/
    public function store_au(Request $request)
    {
        $this->validate($request, [
            'txtFile' => 'required|mimes:jpeg,jpg,png,x-png'
        ]);

        //dd($request->file('txtFile'));

        // upload the image //
        $file = $request->file('txtFile');
        $destination_path = 'assets/files/';
        $file_id = date('U') . '_' . md5(uniqid('@F#1$' . time(), true));
        $filename = $file_id . '.' . $file->getClientOriginalExtension();
        $file->move($destination_path, $filename);
        $field_image = $destination_path . $filename;

        try {
            $query_insert = \DB::table('ad_contents')->insert(
                [
                    'ad_retailer_product_id' => $request->input('id_retailer_product'),
                    'title' => $request->input('txtTitulo'),
                    'content' => $request->input('txtContenido'),
                    'file' => $field_image,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]
            );

            return redirect()->route('admin.au.content.list', ['nav' => 'au_content', 'action' => 'list', 'id_retailer_product' => $request->input('id_retailer_product')])->with(array('ok'=>'Se registro correctamente los datos del formulario'));

        }catch(QueryException $e){
            return redirect()->back()->with(array('error'=>$e->getMessage()));
        }
    }

    /*MULTIRIESGO*/
    public function store_mr(Request $request)
    {
        $this->validate($request, [
            'txtFile' => 'required|mimes:jpeg,jpg,png,x-png'
        ]);

        //dd($request->file('txtFile'));

        // upload the image //
        $file = $request->file('txtFile');
        $destination_path = 'assets/files/';
        $file_id = date('U') . '_' . md5(uniqid('@F#1$' . time(), true));
        $filename = $file_id . '.' . $file->getClientOriginalExtension();
        $file->move($destination_path, $filename);
        $field_image = $destination_path . $filename;

        try {
            $query_insert = \DB::table('ad_contents')->insert(
                [
                    'ad_retailer_product_id' => $request->input('id_retailer_product'),
                    'title' => $request->input('txtTitulo'),
                    'content' => $request->input('txtContenido'),
                    'file' => $field_image,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]
            );

            return redirect()->route('admin.td.content.list', ['nav' => 'mr_content', 'action' => 'list', 'id_retailer_product' => $request->input('id_retailer_product')])->with(array('ok'=>'Se registro correctamente los datos del formulario'));

        }catch(QueryException $e){
            return redirect()->back()->with(array('error'=>$e->getMessage()));
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * DESGRAVAMEN
     */
    public function edit_de($nav, $action, $id_retailer_product, $id_content)
    {
        $main_menu = $this->menu_principal();
        $array_data = $this->array_data();
        $query = \DB::table('ad_contents')
            ->where('id', $id_content)
            ->where('ad_retailer_product_id', $id_retailer_product)
            ->first();
        $query_retailer = RetailerProduct::join('ad_company_products as acp', 'acp.id', '=', 'ad_retailer_products.ad_company_product_id')
            ->join('ad_products as ap', 'ap.id', '=', 'acp.ad_product_id')
            ->select('ap.name as product')
            ->where('ad_retailer_products.id',$id_retailer_product)
            ->first();
        //dd($query);
        return view('admin.de.content.edit', compact('nav', 'action', 'main_menu', 'query', 'query_retailer', 'id_retailer_product', 'array_data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * VIDA
     */
    public function edit_vi($nav, $action, $id_retailer_product, $id_content)
    {
        $main_menu = $this->menu_principal();
        $array_data = $this->array_data();
        $query = \DB::table('ad_contents')
            ->where('id', $id_content)
            ->where('ad_retailer_product_id', $id_retailer_product)
            ->first();
        $query_retailer = RetailerProduct::join('ad_company_products as acp', 'acp.id', '=', 'ad_retailer_products.ad_company_product_id')
            ->join('ad_products as ap', 'ap.id', '=', 'acp.ad_product_id')
            ->select('ap.name as product')
            ->where('ad_retailer_products.id',$id_retailer_product)
            ->first();
        //dd($query);
        return view('admin.vi.content.edit', compact('nav', 'action', 'main_menu', 'query', 'query_retailer', 'id_retailer_product', 'array_data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * AUTOMOTORES
     */
    public function edit_au($nav, $action, $id_retailer_product, $id_content)
    {
        $main_menu = $this->menu_principal();
        $array_data = $this->array_data();
        $query = \DB::table('ad_contents')
            ->where('id', $id_content)
            ->where('ad_retailer_product_id', $id_retailer_product)
            ->first();
        $query_retailer = RetailerProduct::join('ad_company_products as acp', 'acp.id', '=', 'ad_retailer_products.ad_company_product_id')
            ->join('ad_products as ap', 'ap.id', '=', 'acp.ad_product_id')
            ->select('ap.name as product')
            ->where('ad_retailer_products.id',$id_retailer_product)
            ->first();
        //dd($query);
        return view('admin.au.content.edit', compact('nav', 'action', 'main_menu', 'query', 'query_retailer', 'id_retailer_product', 'array_data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * MULTIRIESGO
     */
    public function edit_mr($nav, $action, $id_retailer_product, $id_content)
    {
        $main_menu = $this->menu_principal();
        $array_data = $this->array_data();
        $query = \DB::table('ad_contents')
            ->where('id', $id_content)
            ->where('ad_retailer_product_id', $id_retailer_product)
            ->first();
        $query_retailer = RetailerProduct::join('ad_company_products as acp', 'acp.id', '=', 'ad_retailer_products.ad_company_product_id')
            ->join('ad_products as ap', 'ap.id', '=', 'acp.ad_product_id')
            ->select('ap.name as product')
            ->where('ad_retailer_products.id',$id_retailer_product)
            ->first();
        //dd($query);
        return view('admin.td.content.edit', compact('nav', 'action', 'main_menu', 'query', 'query_retailer', 'id_retailer_product', 'array_data'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * DESGRAVAMEN
     */
    public function update_de(Request $request)
    {
        $this->validate($request, [
            'txtFile' => 'mimes:jpeg,jpg,png,x-png'
        ]);

        //dd($request->file('txtFile'));
        if(count($request->file('txtFile'))>0){
            // upload the image //
            $file = $request->file('txtFile');
            $destination_path = 'assets/files/';
            $file_id = date('U') . '_' . md5(uniqid('@F#1$' . time(), true));
            $filename = $file_id . '.' . $file->getClientOriginalExtension();
            $file->move($destination_path, $filename);
            $field_image = $destination_path . $filename;
        }else{
            $field_image = $request->input('aux_file');
        }

        try {
            // save image data into database //
            $query_update = \DB::table('ad_contents')
                ->where('id', $request->input('id_content'))
                ->where('ad_retailer_product_id', $request->input('id_retailer_product'))
                ->update([
                    'title' => $request->input('txtTitulo'),
                    'content' => $request->input('txtContenido'),
                    'file' => $field_image,
                    'updated_at' => date("Y-m-d H:i:s")
                ]);
            if ($query_update) {
                return redirect()->route('admin.de.content.list', ['nav' => 'contentde', 'action' => 'list', 'id_retailer_product' => $request->input('id_retailer_product')])->with(array('ok'=>'Se actualizo correctamente los datos del formulario'));
            }
        }catch(QueryException $e){
            return redirect()->back()->with(array('error'=>$e->getMessage()));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * VIDA
     */
    public function update_vi(Request $request)
    {
        $this->validate($request, [
            'txtFile' => 'mimes:jpeg,jpg,png,x-png'
        ]);

        //dd($request->file('txtFile'));
        if(count($request->file('txtFile'))>0){
            // upload the image //
            $file = $request->file('txtFile');
            $destination_path = 'assets/files/';
            $file_id = date('U') . '_' . md5(uniqid('@F#1$' . time(), true));
            $filename = $file_id . '.' . $file->getClientOriginalExtension();
            $file->move($destination_path, $filename);
            $field_image = $destination_path . $filename;
        }else{
            $field_image = $request->input('aux_file');
        }

        try {
            // save image data into database //
            $query_update = \DB::table('ad_contents')
                ->where('id', $request->input('id_content'))
                ->where('ad_retailer_product_id', $request->input('id_retailer_product'))
                ->update([
                    'title' => $request->input('txtTitulo'),
                    'content' => $request->input('txtContenido'),
                    'file' => $field_image,
                    'updated_at' => date("Y-m-d H:i:s")
                ]);

            return redirect()->route('admin.vi.content.list', ['nav' => 'contentvi', 'action' => 'list', 'id_retailer_product' => $request->input('id_retailer_product')])->with(array('ok'=>'Se actualizo correctamente los datos del formulario'));

        }catch(QueryException $e){
            return redirect()->back()->with(array('error'=>$e->getMessage()));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * AUTOMOTORES
     */
    public function update_au(Request $request)
    {
        $this->validate($request, [
            'txtFile' => 'mimes:jpeg,jpg,png,x-png'
        ]);

        //dd($request->file('txtFile'));
        if(count($request->file('txtFile'))>0){
            // upload the image //
            $file = $request->file('txtFile');
            $destination_path = 'assets/files/';
            $file_id = date('U') . '_' . md5(uniqid('@F#1$' . time(), true));
            $filename = $file_id . '.' . $file->getClientOriginalExtension();
            $file->move($destination_path, $filename);
            $field_image = $destination_path . $filename;
        }else{
            $field_image = $request->input('aux_file');
        }

        try {
            // save image data into database //
            $query_update = \DB::table('ad_contents')
                ->where('id', $request->input('id_content'))
                ->where('ad_retailer_product_id', $request->input('id_retailer_product'))
                ->update([
                    'title' => $request->input('txtTitulo'),
                    'content' => $request->input('txtContenido'),
                    'file' => $field_image,
                    'updated_at' => date("Y-m-d H:i:s")
                ]);

            return redirect()->route('admin.au.content.list', ['nav' => 'au_content', 'action' => 'list', 'id_retailer_product' => $request->input('id_retailer_product')])->with(array('ok'=>'Se actualizo correctamente los datos del formulario'));

        }catch(QueryException $e){
            return redirect()->back()->with(array('error'=>$e->getMessage()));
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * MULTIRIESGO
     */
    public function update_mr(Request $request)
    {
        $this->validate($request, [
            'txtFile' => 'mimes:jpeg,jpg,png,x-png'
        ]);

        //dd($request->file('txtFile'));
        if(count($request->file('txtFile'))>0){
            // upload the image //
            $file = $request->file('txtFile');
            $destination_path = 'assets/files/';
            $file_id = date('U') . '_' . md5(uniqid('@F#1$' . time(), true));
            $filename = $file_id . '.' . $file->getClientOriginalExtension();
            $file->move($destination_path, $filename);
            $field_image = $destination_path . $filename;
        }else{
            $field_image = $request->input('aux_file');
        }

        try {
            // save image data into database //
            $query_update = \DB::table('ad_contents')
                ->where('id', $request->input('id_content'))
                ->where('ad_retailer_product_id', $request->input('id_retailer_product'))
                ->update([
                    'title' => $request->input('txtTitulo'),
                    'content' => $request->input('txtContenido'),
                    'file' => $field_image,
                    'updated_at' => date("Y-m-d H:i:s")
                ]);

            return redirect()->route('admin.td.content.list', ['nav' => 'mr_content', 'action' => 'list', 'id_retailer_product' => $request->input('id_retailer_product')])->with(array('ok'=>'Se actualizo correctamente los datos del formulario'));

        }catch(QueryException $e){
            return redirect()->back()->with(array('error'=>$e->getMessage()));
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
